<?php

declare(strict_types=1);

namespace App\Controller;

use PDO;
use Swoole\Runtime;
use Swoole\Coroutine;
use Swoole\Database\PDOConfig;
use App\Kernel\Database\PDOPool;
use Hyperf\Server\Exception\RuntimeException;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

/**
 * @AutoController
 */
class TestController
{
    const N = 1024;

    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $response->json([]);
    }

    public function pool()
    {
        Runtime::enableCoroutine();
        $s = microtime(true);
        echo 'start:', $s, PHP_EOL;
        
        $db = config('databases.oa');
        $pdoConfig = (new PDOConfig())
            ->withDriver($db['driver'])
            ->withHost($db['host'])
            ->withPort($db['port'])
            // ->withUnixSocket('/tmp/mysql.sock')
            ->withDbName($db['database'])
            ->withCharset($db['charset'])
            ->withUsername($db['username'])
            ->withPassword($db['password'])
            ->withOptions($db['options']);
        $pool = new PDOPool($pdoConfig);
        for ($n = static::N; $n--;) {
            go(function () use ($pool) {
                $pdo = $pool->get();
                $statement = $pdo->prepare('SELECT :a + :b');
                if (!$statement) {
                    throw new RuntimeException('Prepare failed');
                }
                $a = mt_rand(1, 100);
                $b = mt_rand(1, 100);

                $statement->bindValue(':a', $a, PDO::PARAM_INT);
                $statement->bindValue(':b', $b, PDO::PARAM_INT);
                $result = $statement->execute();
                if (!$result) {
                    throw new RuntimeException('Execute failed');
                }
                $result = $statement->fetchAll();
                if ($a + $b !== (int) $result[0][0]) {
                    throw new RuntimeException('Bad result');
                }
                echo microtime(true), ' result: ', $a, " + ", $b, ' = ', $result[0][0], PHP_EOL;
                $pool->put($pdo);
            });
        }
        echo 'end:', microtime(true) . PHP_EOL;

        $s = microtime(true) - $s;
        echo 'Use ' . $s . 's for ' . static::N . ' queries' . PHP_EOL;
    }

    public function sql()
    {
        $tsql = 'select :a + :b';
        $pdo = new PDO("sqlsrv:Server=172.16.0.231,1433,Database=ecology", 'sa', 'fanwei123456!');
        $stmt = $pdo->prepare($tsql);
        $a = mt_rand(1, 100);
        $b = mt_rand(1, 100);
        $stmt->bindValue(':a', $a, PDO::PARAM_INT);
        $stmt->bindValue(':b', $b, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll();
        var_dump($res);
        echo microtime(true), ' result: ', $a, " + ", $b, ' = ', $res[0][0], PHP_EOL;
    }
}

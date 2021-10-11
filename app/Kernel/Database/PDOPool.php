<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace App\Kernel\Database;

use PDO;
use Swoole\ConnectionPool;
use Swoole\Database\PDOProxy;
use Swoole\Database\PDOConfig;

/**
 * @method PDO|PDOProxy get()
 * @method void put(PDO|PDOProxy $connection)
 */
class PDOPool extends ConnectionPool
{
    /** @var int */
    protected $size = 64;

    /** @var PDOConfig */
    protected $config;

    public function __construct(PDOConfig $config, int $size = self::DEFAULT_SIZE)
    {
        $this->config = $config;
        parent::__construct(function () {
            if ($this->config->getDriver() == 'sqlsrv') {
                $dsn = "{$this->config->getDriver()}:" .
                ("Server={$this->config->getHost()}" . ",{$this->config->getPort()};") .
                "Database={$this->config->getDbname()}";
            } else {
                $dsn = "{$this->config->getDriver()}:" .
                    ($this->config->hasUnixSocket() ?
                        "unix_socket={$this->config->getUnixSocket()};" :
                        "host={$this->config->getHost()};" . "port={$this->config->getPort()};") .
                    "dbname={$this->config->getDbname()};" .
                    "charset={$this->config->getCharset()}";
            }
            return new PDO(
                $dsn,
                $this->config->getUsername(),
                $this->config->getPassword(),
                $this->config->getOptions()
            );
        }, $size, PDOProxy::class);
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', function (RequestInterface $request, ResponseInterface $response) {
    return $response->redirect('/admin/index.html');
});
Router::get('/admin[/]', function (RequestInterface $request, ResponseInterface $response) {
    return $response->redirect('/admin/index.html');
});

Router::get('/favicon.ico', function () {
    return '';
});

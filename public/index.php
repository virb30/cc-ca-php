<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Infra\Database\PdoMysqlConnectionAdapter;
use App\Infra\Factory\DatabaseRepositoryFactory;
use App\Infra\Http\SlimHttp;
use App\Infra\Http\SymfonyHttp;
use App\Infra\Http\LumenHttp;
use App\Infra\Http\Router;

$connection = new PdoMysqlConnectionAdapter();
$repositoryFactory = new DatabaseRepositoryFactory($connection);
$http = new LumenHttp();
$router = new Router($http, $repositoryFactory);
$router->init();
$http->run();
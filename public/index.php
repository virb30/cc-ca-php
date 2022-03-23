<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Application\UseCase\GetOrders\GetOrders;
use App\Infra\Database\PdoMysqlConnectionAdapter;
use App\Infra\Factory\DatabaseRepositoryFactory;
use App\Infra\Http\Http;
use App\Infra\Http\SlimHttp;
use App\Infra\Http\SymfonyHttp;
use App\Infra\Http\LumenHttp;


function init(Http $http)
{
  $http->route('get', '/orders', function($params, $body) {
    $connection = new PdoMysqlConnectionAdapter();
    $repositoryFactory = new DatabaseRepositoryFactory($connection);
    $getOrders = new GetOrders($repositoryFactory);
    $output = $getOrders->execute();
    return $output;
  });
  
  $http->run();
}

// init slim app
init(new SlimHttp());

// init symfony app
// init(new SymfonyHttp());

// init lumen app
// init(new LumenHttp());

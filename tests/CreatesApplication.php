<?php declare(strict_types=1);

namespace Tests;

use Slim\Factory\AppFactory;

trait CreatesApplication
{
  public function createApplication()
  {
      // Instantiate the app
      $app = AppFactory::create();

      // Register routes
      $routes = require __DIR__ . '/../app/routes.php';
      $routes($app);

      return $app;
  }
}
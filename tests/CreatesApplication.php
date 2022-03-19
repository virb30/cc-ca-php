<?php declare(strict_types=1);

namespace Tests;

use App\Infra\Http\SlimHttp;
use Slim\Factory\AppFactory;

trait CreatesApplication
{
  public function createApplication()
  {
      // Instantiate the app
      $app = new SlimHttp();
      return $app;
  }
}
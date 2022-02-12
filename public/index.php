<?php

require __DIR__."/../vendor/autoload.php";

use App\Example;

$example = new Example(false);

$example->execute();

phpinfo();
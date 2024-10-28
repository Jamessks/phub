<?php

use Core\Database;
use Dotenv\Dotenv;
use Core\Container;

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'Core/functions.php';

$container = new Container();

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$container->bind('Core\Database', function () {
    return new Database();
});

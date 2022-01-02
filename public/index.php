<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__DIR__)));

$autoload = ROOT . "/vendor/autoload.php";

if (!is_file($autoload)) {
    die("!!You need composer autoloader to use this framework!!");
}

require $autoload;
require ROOT . '/bootstrap/bootstrap.php';

use Raymonds\Application\Application;

$app = new Application(ROOT);
$app->run()
    ->setSession()
    ->handleRoute();

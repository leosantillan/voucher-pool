<?php

namespace Newsletter2Go;

require '../vendor/autoload.php';

$app = new \Slim\App(['settings' => require __DIR__ . '/../config/settings.php']);

$dotenv = new \Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

require  __DIR__ . '/../config/container.php';
require __DIR__ . '/../config/routes.php';

$app->run();

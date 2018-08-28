<?php

use Slim\Container;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Connection;

$container = $app->getContainer();

$container['environment'] = function () {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $_SERVER['SCRIPT_NAME'] = dirname(dirname($scriptName)) . '/' . basename($scriptName);
    return new Slim\Http\Environment($_SERVER);
};

// Logger
$container['logger'] = function (Container $container) {
    $settings = $container->get('settings');
    $logger = new Logger($settings['logger']['name']);
    
    $level = $settings['logger']['level'];
    if (!isset($level)) {
        $level = Logger::ERROR;
    }
    
    $logFile = $settings['logger']['file'];
    $handler = new RotatingFileHandler($logFile, 0, $level, true, 0775);
    $logger->pushHandler($handler);
    
    return $logger;
};

// Querybuilder
$container['db'] = function (Container $container) {
    $settings = $container->get('settings');
    
    $config = [
        'driver' => 'mysql',
        'host' => $settings['db']['host'],
        'database' => $settings['db']['database'],
        'username' => $settings['db']['username'],
        'password' => $settings['db']['password'],
        'port' => $settings['db']['port'],
        'charset'  => $settings['db']['charset'],
        'collation' => $settings['db']['collation'],
    ];
    
    $factory = new ConnectionFactory(new \Illuminate\Container\Container());
    
    return $factory->make($config);
};

// Eloquent
$config = [
    'driver' => 'mysql',
    'host' => $settings['db']['host'],
    'database' => $settings['db']['database'],
    'username' => $settings['db']['username'],
    'password' => $settings['db']['password'],
    'port' => $settings['db']['port'],
    'charset'  => $settings['db']['charset'],
    'collation' => $settings['db']['collation'],
];
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection($config);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Controllers
$container['SpecialOfferController'] = function ($container) {
    return new \Newsletter2Go\Controllers\SpecialOfferController($container);
};

$container['VoucherCodeController'] = function ($container) {
    return new \Newsletter2Go\Controllers\VoucherCodeController($container);
};

$container['RecipientController'] = function ($container) {
    return new \Newsletter2Go\Controllers\RecipientController($container);
};


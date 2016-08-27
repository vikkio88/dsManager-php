<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = new Dotenv\Dotenv(__DIR__ . "/../");
$dotenv->load();

/**
 * Configure the database and boot Eloquent
 */
$capsule = new Capsule;
$capsule->addConnection(array(
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'dsmanager',
    'username' => empty(getenv('USERNAME')) ? 'root' : getenv('USERNAME'),
    'password' => empty(getenv('PASSWORD')) ? '' : getenv('PASSWORD'),
    'charset' => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix' => ''
));
$capsule->setAsGlobal();
$capsule->bootEloquent();
// set timezone for timestamps etc
date_default_timezone_set('UTC');
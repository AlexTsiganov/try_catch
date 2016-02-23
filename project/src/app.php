<?php
require_once __DIR__.'../../vendor/autoload.php';

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

date_default_timezone_set('Europe/Moscow');

// Include app parameters
$parameters = require_once __DIR__ . '/config/config.php';

$app = new Silex\Application();

if ($parameters['debug']) {
    $app['debug'] = true;
}

// Define resources
require __DIR__ . '/config/resources.php';

// Define routes
require __DIR__ . '/routes.php';

return $app;

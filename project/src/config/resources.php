<?php
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;

// Register database
$app->register(new DoctrineServiceProvider(), array(
    'db.options' => $parameters['database']
));

// Register Twig
$app->register(new TwigServiceProvider(), array(
    'twig.path' => $parameters['twig']['path']
));

// Create controller
// $app['paste.controller'] = $app->share(function() use ($app) {
//     return new PasteController($app['paste.gateway'], $app['twig']);
// });

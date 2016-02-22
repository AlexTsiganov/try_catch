<?php
require_once '/../vendor/autoload.php';
$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => '/../views'
));
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html');
});
$app->get('/{variable}', function ($variable) use ($app) {
    return $app['twig']->render('index.html', array('variable' => $variable));
});
$app->run();

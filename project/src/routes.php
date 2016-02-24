<?php

use code\controllers\HomeController;
use code\controllers\ApiController;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app['home.controller'] = $app->share(function() use ($app) {
    return new HomeController($app);
});

$app['api.controller'] = $app->share(function() use ($app) {
    return new ApiController($app);
});

// define controllers for a home
$home = $app['controllers_factory'];
$home->get('/', "home.controller:home")->bind('home');

$api = $app['controllers_factory'];
$api->get('/', "api.controller:api");
$api->get('/statistic-seller', "api.controller:statistic_seller");
$api->get('/maxDate', "api.controller:maxDate");
$api->get('/services', "api.controller:services");

$app->mount('/', $home);
$app->mount('/api', $api);

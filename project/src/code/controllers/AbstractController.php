<?php
namespace code\controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use code\models\StatisticModel;

class AbstractController
{

    protected $app;
    protected $model;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->model = new StatisticModel($app);
    }

    protected function redirect($url, $statusCode = 302)
    {
        return new RedirectResponse($url, $statusCode);
    }

    protected function jsonResopne($jsonObj)
    {
      return new Response(
                  json_encode($jsonObj),
                  200,
                  ['Content-Type' => 'application/json']
              );
    }
}

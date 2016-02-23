<?php
namespace code\controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AbstractController
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
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

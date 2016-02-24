<?php

namespace code\controllers;

use code\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    public function home(Request $request)
    {
      return $this->app['twig']->render('index.html');
    }

    public function about()
    {
        return "Delevoped by Try_catch 2016";
    }
}

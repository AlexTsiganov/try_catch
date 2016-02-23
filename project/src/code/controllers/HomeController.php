<?php

namespace code\controllers;

use code\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    public function home(Request $request)
    {
      echo "hell";
      $variable = "world!";
      return "asdas";
      //return $app['twig']->render('index.html', array('variable' => $variable));
    }

    public function about()
    {
        return "Delevoped by Try_catch 2016";
    }
}

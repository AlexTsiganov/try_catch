<?php

namespace code\controllers;

use code\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class ApiController extends AbstractController
{
    public function api(Request $request)
    {
      return $this->jsonResopne($this->fetch_statistic_saller());
    }

    public function statistic_saller(Request $request, Application $app)
    {
      echo "app=".$this->app;
      $saller_statistic = $this->fetchSalersStatistic();
      return $this->jsonResopne($saller_statistic);
    }

    public function fetch_statistic_saller($saller_id = -1)
    {
      /*
      SELECT
       `seller`.`id` AS `sid`,
       FORMAT(SUM(`purchased_services`.`backed_price`) / 100, 2) AS `sells`,
       SUM(`purchased_services`.`amount`) AS `number_of_sold_services`
      FROM
       `old-hotel_rt-dev`.`seller`
       LEFT JOIN `old-hotel_rt-dev`.`order` ON `order`.seller_id = `seller`.`id`
       LEFT JOIN `old-hotel_rt-dev`.`purchased_services` ON `purchased_services`.`order_id` = `order`.`id`
      WHERE
       `order`.`date` BETWEEN '2015-12-05 00:00:00' AND '2015-12-05 23:59:59'
      GROUP BY
       `seller`.`id`
      */
        if ($saller_id == -1) {
          $sql = '
          SELECT
           `seller`.`id` AS `sid`,
           FORMAT(SUM(`purchased_services`.`backed_price`) / 100, 2) AS `sells`,
           SUM(`purchased_services`.`amount`) AS `number_of_sold_services`
          FROM
           `old-hotel_rt-dev`.`seller`
           LEFT JOIN `sales_test_db`.`order` ON `order`.`seller_id` = `seller`.`id`
           LEFT JOIN `sales_test_db`.`purchased_services` ON `purchased_services`.`order_id` = `order`.`id`
          WHERE
           `sales_test_db`.`order`.`date` BETWEEN '2015-12-05 00:00:00' AND '2015-12-05 23:59:59'
          GROUP BY
           `seller`.`id`
          ';
          $result = $this->app['db']->fetchAll($sql);
        }
        else {
          $sql = 'SELECT * FROM seller WHERE id = ?';
          $result = $this->app['db']->fetchAssoc($sql, array((int) $saller_id));
        }

         return $result;
    }
}

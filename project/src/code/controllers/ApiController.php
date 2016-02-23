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
       `seller`.`id` AS `seller_id`,
       SUM(`perchased_services`.`baked_price`) AS `sells`
      FROM
       `sales_db.sql`.`seller`
       LEFT JOIN `sales_db.sql`.`order` ON `seller`.`id` = `order`.`seller_id`
       LEFT JOIN `sales_db.sql`.`perchased_services` ON `perchased_services`.`order_id` = `order`.`id`
      WHERE
       `order`.`date` BETWEEN '2015-02-22 00:00:00' AND '2015-02-22 23:59:59'
      GROUP BY
       `seller`.`id`
      */
        if ($saller_id == -1) {
          $sql = 'SELECT s.*, p.*, SUM(purchased_services.baked_price) AS sells FROM seller
          LEFT JOIN order ON seller.id = order.seller_id
          LEFT JOIN perchased_services ON perchased_services.order_id = order.id
          GROUP BY seller.id';
          $result = $this->app['db']->fetchAll($sql);
        }
        else {
          $sql = 'SELECT * FROM seller WHERE id = ?';
          $result = $this->app['db']->fetchAssoc($sql, array((int) $saller_id));
        }

         return $result;
    }
}

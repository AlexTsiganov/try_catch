<?php

namespace code\controllers;

use code\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use code\models\StatisticModel;

class ApiController extends AbstractController
{
    public function api(Request $request)
    {
      $result = $this->fetch_seller_statistic($dto);

      return $this->app->json($result);
    }

    public function maxDate(Request $request)
    {
      $result = $this->model->getMaxDate();
      return $this->app->json($result);
    }

    public function services(Request $request)
    {
      $result = $this->model->getServices();
      return $this->app->json($result);
    }

    public function statistic_seller(Request $request)
    {
      $dto = $this->getDTOFromRequest($request);
      if (empty($dto['seller_id']))
      {
        echo "set";
        # code...
      }
      else {
        echo "string".json_encode($dto);
        $saller_statistic1 = $this->model->get_statistic_sellers1($dto);

        $saller_statistic3 = $this->model->get_statistic_sellers3($dto);
        return $this->jsonResopne(array_merge(
                            [$saller_statistic1],
                            $saller_statistic3
                        ));

      }
    }

    private function getDTOFromRequest($request)
    {
      if (empty($request->query->all()['seller_id'])) {
        $dto['seller_id'] = $request->query->all()['seller_id'];
      }

      if (empty($request->query->all()['start_date'])) {

        $dto['start_date'] = "1970-01-01 00:00:00";
      }else {
          $dto['start_date'] = $request->query->all()['start_date'];
        }
        if (empty($request->query->all()['end_date'])) {
          $dto['end_date'] = "1970-01-01 23:59:59";
        }else {
            $dto['end_date'] = $request->query->all()['end_date'];
          }
      return $dto;
    }

    public function fetch_seller_statistic($dto)
    {
      /*
      SELECT
       `seller`.`id` AS `sid`,
       FORMAT(SUM(`purchased_services`.`backed_price`) / 100, 2) AS `sells`,
       SUM(`purchased_services`.`amount`) AS `number_of_sold_services`
      FROM
       `old-hotel_rt-dev`.`seller`
       LEFT JOIN `order` ON `order`.seller_id = `seller`.`id`
       LEFT JOIN `purchased_services` ON `purchased_services`.`order_id` = `order`.`id`
      WHERE
       `order`.`date` BETWEEN '2015-12-05 00:00:00' AND '2015-12-05 23:59:59'
      GROUP BY
       `seller`.`id`
      */
      if (isset($dto['seller_id'])) {
        $sql = 'SELECT * FROM seller WHERE id = ?';
        $result = $this->app['db']->fetchAssoc($sql, array((int) $dto['seller_id']));

      }
      else {

        $sql = "SELECT
                  seller.id AS sid,
       FORMAT(SUM(purchased_services.backed_price) / 100, 2) AS sells,
       SUM(purchased_services.amount) AS `number_of_sold_services`
      FROM
        `seller`
       LEFT JOIN `order` ON `order`.seller_id = `seller`.`id`
       LEFT JOIN `purchased_services` ON `purchased_services`.`order_id` = `order`.`id`
      WHERE
       `order`.`date` BETWEEN '2015-12-05 00:00:00' AND '2015-12-05 23:59:59'
      GROUP BY
       `seller`.`id`";

        $result = $this->app['db']->fetchAll($sql);
      }

         return $result;
    }
}

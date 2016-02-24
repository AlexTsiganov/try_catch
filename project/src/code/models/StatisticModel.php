<?php

namespace code\models;

use Silex\Application;

class StatisticModel
{
    protected $app;
    protected $db;

    public function __construct($app)
    {
      $this->db = $app['db'];
      $this->app = $app;
    }

    public function get_statistic_sellers1($dto)
    {
        $res = $this->db->fetchAll("
          SELECT
              `seller`.`id` AS `sid`,
              FORMAT(SUM(`backed_price`) / 100, 2) AS `sells`,
              SUM(`amount`) AS `number_of_sold_services`,
              CONCAT(`personal_data`.`secondname`, ' ', `personal_data`.`firstname`, ' ', `personal_data`.`thirdname`) AS `FIO`
          FROM
              `seller`
              LEFT JOIN `order` ON `order`.`seller_id` = `seller`.`id`
              LEFT JOIN `purchased_services` ON `order_id` = `order`.`id`
              LEFT JOIN `personal_data` ON `personal_data`.`id` = `seller`.`id`
          WHERE
                `order`.`date` BETWEEN '" . $this->app->escape($dto['start_date']) . "' AND '" . $this->app->escape($dto['end_date']) . "'
            GROUP BY
                `seller`.`id`
            ORDER BY `seller`.`id`
        ");
        echo json_encode($res);
        return $res;
    }

    public function get_statistic_sellers3($dto)
    {
        $res = $this->db->fetchAll("
        SELECT
            `seller`.`id` AS `sid`,
            `service`.`id` AS `service_id`,
            FORMAT(SUM(`backed_price`) / 100, 2) AS `sells`,
            SUM(`amount`) AS `number_of_sold_services`,
            CONCAT(`personal_data`.`secondname`, ' ', `personal_data`.`firstname`, ' ', `personal_data`.`thirdname`) AS `FIO`
        FROM
            `seller`
            LEFT JOIN `order` ON `order`.`seller_id` = `seller`.`id`
            LEFT JOIN `purchased_services` ON `order_id` = `order`.`id`
            LEFT JOIN `service` ON `service`.`id` = `purchased_services`.`service_id`
            LEFT JOIN `personal_data` ON `personal_data`.`id` = `seller`.`id`
        WHERE
            `order`.`date` BETWEEN '" . $this->app->escape($dto['start_date']) . "' AND '" . $this->app->escape($dto['end_date']) . "'
        GROUP BY
            `seller`.`id`, `service`.`id`
        ORDER BY `seller`.`id`
        ");
        return $res;
    }

    public function get_statistic_salers2($dto)
    {
        $res = $this->db->fetchAll("
        SELECT
            `category`.`id` AS `cid`,
            FORMAT(SUM(`backed_price`) / 100, 2) AS `sells`,
            SUM(`amount`) AS `number_of_sold_services`,
            `category`.`name` AS `name`
        FROM
            `order`
            LEFT JOIN `purchased_services` ON `order_id` = `order`.`id`
            LEFT JOIN `service` ON `service`.`id` = `purchased_services`.`service_id`
            LEFT JOIN `category` ON `category`.`id` = `service`.`category_id`
        WHERE
            `order`.`seller_id` = " . $this->db->escape($sellerId) . " AND
            `order`.`date` BETWEEN " . $this->db->escape($sDate) . " AND " . $this->db->escape($eDate) . "
        GROUP BY
            `service`.`category_id`
        ORDER BY
            `category`.`name`
        ");
        return $res;
    }

    public function getMaxDate()
    {
        $res = $this->db->fetchAll("
            SELECT
                MAX(`order`.`date`) AS `max_date`
            FROM
                `order`
        ");
        $maxDate = date_create($res[0]['max_date']);
        return ['max_date' => date_format($maxDate, 'y-m-d')];

    }

    public function getServices()
    {
      return $this->db->fetchAll("
          SELECT
              `service`.`id` as `id`,
              `service`.`name` AS `name`
          FROM
              `service`
      ");
    }
}

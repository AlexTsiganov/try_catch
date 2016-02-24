<?php

class Model_charts extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getChartData1($sDate, $eDate)
    {
        $res = $this->db->query("
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
                `order`.`date` BETWEEN " . $this->db->escape($sDate) . " AND " . $this->db->escape($eDate) . "
            GROUP BY
                `seller`.`id`
            ORDER BY `seller`.`id`
        ");
        $data = [];
        foreach ($res->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getChartData3($sDate, $eDate)
    {
        $res = $this->db->query("
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
                `order`.`date` BETWEEN " . $this->db->escape($sDate) . " AND " . $this->db->escape($eDate) . "
            GROUP BY
                `seller`.`id`, `service`.`id`
            ORDER BY `seller`.`id`
        ");
        $data = [];
        foreach ($res->result() as $row) {
            $data[$row->service_id][] = $row;
        }
        return $data;
    }

    public function getChartData4($sDate, $eDate)
    {
        $res = $this->db->query("
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
                `order`.`date` BETWEEN " . $this->db->escape($sDate) . " AND " . $this->db->escape($eDate) . "
            GROUP BY
                `seller`.`id`
            ORDER BY `seller`.`id`
        ");
        $data = [];
        foreach ($res->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getMaxDate()
    {
        $res = $this->db->query("
            SELECT
                MAX(`order`.`date`) AS `max_date`
            FROM
                `order`
        ");
        $data = [];
        foreach ($res->result() as $key => $value) {
            $data['max_date'] = date('Y-m-d', strtotime($value->max_date));
        }
        return $data;
    }

    public function getListServices()
    {
        $res = $this->db->query("
            SELECT
                `service`.`id` as `id`,
                `service`.`name` AS `name`
            FROM
                `service`
        ");
        $data = [];
        foreach ($res->result() as $row) {
            $data[$row->id] = $row;
        }
        return $data;
    }
}
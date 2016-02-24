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

    public function getChartData2($sDate, $eDate, $sellerId = 1)
    {
        $res = $this->db->query("
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
        $data = [];
        $sumSells = $sum = 0;
        $data[0] = [];
        foreach ($res->result() as $row) {
            $data[] = $row;
            $sumSells += floatval(str_replace(',', '', $row->sells));
            $sum += $row->number_of_sold_services;
        }
        $data[0] = [
            'cid' => 0,
            'sells' => $sumSells,
            'number_of_sold_services' => $sum,
            'name' => 'Продаж по всем категориям'
        ];
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

    public function getSellers()
    {
        $res = $this->db->query("
            SELECT
                `seller`.`id` as `id`,
                CONCAT(`personal_data`.`secondname`, ' ', `personal_data`.`firstname`, ' ', `personal_data`.`thirdname`) AS `FIO`
            FROM
                `seller`
                LEFT JOIN `personal_data` ON `personal_data`.`id` = `seller`.`id`
        ");
        $data = [];
        foreach ($res->result() as $row) {
            $data[$row->id] = $row;
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
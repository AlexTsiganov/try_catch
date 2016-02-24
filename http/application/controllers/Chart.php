<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_charts', 'charts', true);
    }

    public function index()
    {
        return $this->get();
    }

    public function get($num = 1)
    {
        switch($num) {
            case '1':
                $sDate = $this->input->get('start_date');
                $eDate = $this->input->get('end_date');
                if ($sDate && $eDate) {
                    echo json_encode(
                        array_merge(
                            [$this->charts->getChartData1($sDate, $eDate)],
                            $this->charts->getChartData3($sDate, $eDate)
                        )
                    );
                }
                break;
            case '2':
                $sDate = $this->input->get('start_date');
                $eDate = $this->input->get('end_date');
                $sellerId = $this->input->get('seller_id');
                if ($sDate && $eDate && $sellerId) {
                    echo json_encode(
                        $this->charts->getChartData2($sDate, $eDate, $sellerId)
                    );
                }
                break;
        }
    }

    public function getMaxDate()
    {
        echo json_encode($this->charts->getMaxDate());
    }

    public function getListServices()
    {
        echo json_encode($this->charts->getListServices());
    }

    public function getSellers()
    {
        echo json_encode($this->charts->getSellers());
    }
}
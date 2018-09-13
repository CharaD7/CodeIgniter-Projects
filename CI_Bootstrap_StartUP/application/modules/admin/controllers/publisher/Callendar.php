<?php

/*
 * @Author:    Kiril Kirkov
 *  Github:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Callendar extends ADMIN_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Reservations_model');
    }

    public function index($page = 0)
    {
        $head = array();
        $data = array();
        $head['title'] = 'Administration - Callendar';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['date'])) {
            $this->Reservations_model->setReservedDate($_POST['date']);
            redirect('admin/callendar');
        }

        if (isset($_GET['delete'])) {
            $this->Reservations_model->deleteReservedDate($_GET['delete']);
            redirect('admin/callendar');
        }

        $rowscount = $this->Reservations_model->getCountReservedDates();
        $data['dates'] = $this->Reservations_model->getAllReservedDates($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/callendar', $rowscount, $this->num_rows, 3);

        $this->load->view('_parts/header', $head);
        $this->load->view('publisher/callendar', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to callendar page');
    }

}

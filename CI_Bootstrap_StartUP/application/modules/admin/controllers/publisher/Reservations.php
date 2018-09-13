<?php

/*
 * @Author:    Kiril Kirkov
 *  Github:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Reservations extends ADMIN_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reservations_model');
    }

    public function index($page = 0)
    {
        $head = array();
        $data = array();
        $head['title'] = 'Administration - Reservations';
        $head['description'] = '!';
        $head['keywords'] = '';

        $rowscount = $this->Reservations_model->getCountReservations();
        $data['dates'] = $this->Reservations_model->getAllReservations($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/callendar', $rowscount, $this->num_rows, 3);

        $this->load->view('_parts/header', $head);
        $this->load->view('publisher/reservations', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to callendar page');
    }

    public function delete($id)
    {
        $this->Reservations_model->reservationDelete($id);
        redirect(base_url('/admin/reservations'));
    }

}

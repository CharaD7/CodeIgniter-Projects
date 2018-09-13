<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reservations extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Reservations_model');
    }

    public function index($page = 0)
    {
        if (isset($_POST['names'])) {
            $errors = false;
            // noob prevent from big spam. i will add google protection instead this
            if (isset($_SESSION['num_added']) && $_SESSION['num_added'] > 5) {
                $errors = true;
            }
            if ($errors == false) {
                if (!isset($_SESSION['num_added'])) {
                    $_SESSION['num_added'] = 1;
                } else {
                    $_SESSION['num_added'] += 1;
                }
                $this->Public_model->setReservation($_POST);
                $this->session->set_flashdata('yesReserved', lang('its_reserved'));
                $msg = "Имена: " . $_POST['names'] . "\n Брой хора: " . $_POST['peoples'] . "\n Настаняване на: " . $_POST['date_check_in'] . "\n Напускане на: " . $_POST['date_check_out'] . "\n Имейл: " . $_POST['email'] . "\n Телефон: " . $_POST['phone'];
                //mail("email@", "Nова резервация", $msg);
            }
            redirect(base_url('reservations'));
        }
        $data = array();
        $head = array();
        $head['title'] = ' ';
        $head['description'] = ' ';
        $head['keywords'] = '';
        $dr = [];
        $r_d = $this->Reservations_model->getAllReservedDates(null, null, true); 
        foreach ($r_d as $rd) {
            $dr[] = date('Y-m-d', $rd['date']);
        }
        $data['reservedDates'] = implode('","', $dr);
        $this->render('reservations', $head, $data);
    }

}

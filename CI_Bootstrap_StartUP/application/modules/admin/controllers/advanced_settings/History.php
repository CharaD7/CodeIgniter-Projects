<?php

/*
 *  Author:    Kiril Kirkov
 *  Github:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class History extends ADMIN_Controller
{

    private $num_rows = 20;

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - History';
        $head['description'] = '!';
        $head['keywords'] = '';

        $rowscount = $this->Admin_model->historyCount();
        $data['actions'] = $this->Admin_model->getHistory($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/history', $rowscount, $this->num_rows, 3);
        $data['history'] = $this->history;

        $this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/history', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to History');
        }
    }

}

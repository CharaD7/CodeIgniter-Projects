<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Texts extends ADMIN_Controller
{

    private $num_rows = 20;

    public function index($page = 0)
    {
        $head = array();
        $data = array();
        $head['title'] = 'Administration - Texts';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['value'])) {
            $result = $this->AdminModel->setValueStore($_POST['my_key'], $_POST['value'], $_POST['update']);
            if ($result == true) {
                $this->session->set_flashdata('result', 'Value Store added!');
            } else {
                $this->session->set_flashdata('result', 'Problem with value store! Maybe the key is taken?');
            }
            redirect('admin/texts');
        }

        if (isset($_GET['edit'])) {
            $result = $this->AdminModel->getOneValueStore($_GET['edit']);
            $data['my_key'] = $result['my_key'];
            $data['value'] = $result['value'];
        }

        if (isset($_GET['delete'])) {
            $this->AdminModel->deleteValueStore($_GET['delete']);
            redirect('admin/texts');
        }

        $rowscount = $this->AdminModel->valueStoresCount();
        $data['valueStores'] = $this->AdminModel->getValueStores($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/texts', $rowscount, $this->num_rows, 3);

        $this->load->view('_parts/header', $head);
        $this->load->view('newspaper/texts', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to value store page');
    }

}

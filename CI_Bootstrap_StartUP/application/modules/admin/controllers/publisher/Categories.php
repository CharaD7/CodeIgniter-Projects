<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Categories extends ADMIN_Controller
{

    private $num_rows = 20;

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Categories';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['categories'] = $this->AdminModel->getCategories($this->num_rows, $page);
        $data['languages'] = $this->AdminModel->getLanguages();
        $rowscount = $this->AdminModel->categoriesCount();
        $data['links_pagination'] = pagination('admin/categories', $rowscount, $this->num_rows, 3);
        if (isset($_GET['delete'])) {
            $this->saveHistory('Delete categorie');
            $result = $this->AdminModel->deleteCategorie($_GET['delete']);
            if ($result == true) {
                $this->saveHistory('Home Categorie id - ' . $_GET['delete']);
                $this->session->set_flashdata('result_delete', 'Categorie is deleted!');
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with Categorie delete!');
            }
            redirect('admin/categories');
        }
        if (isset($_POST['submit'])) {
            $result = $this->AdminModel->setCategorie($_POST);
            if ($result === true) {
                $this->session->set_flashdata('result_add', 'Categorie is added!');
                $this->saveHistory('Added categorie');
            } else {
                $this->session->set_flashdata('result_add', 'Problem with categorie add!');
            }
            redirect('admin/categories');
        }
        if (isset($_POST['editSubId'])) {
            $result = $this->AdminModel->editCategorieSub($_POST);
            if ($result === true) {
                $this->session->set_flashdata('result_add', 'Subcategory changed!');
                $this->saveHistory('Change subcategory for category id - ' . $_POST['editSubId']);
            } else {
                $this->session->set_flashdata('result_add', 'Problem with category change!');
            }
            redirect('admin/categories');
        }
        $this->load->view('_parts/header', $head);
        $this->load->view('publisher/categories', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to shop categories');
    }

    /*
     * Called from ajax
     */

    public function editCategorie()
    {
        $this->login_check();
        $result = $this->AdminModel->editCategorie($_POST);
        $this->saveHistory('Edit shop categorie to ' . $_POST['name']);
    }

    /*
     * Called from ajax
     */

    public function changeNavVisibility()
    {
        $this->login_check();
        $this->AdminModel->changeNavVisiblity($_POST);
    }

}

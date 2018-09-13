<?php

/*
 *  Author:    Kiril Kirkov
 *  Github:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Articles extends ADMIN_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
    }

    public function index($page = 0)
    {
        $this->login_check();
        $this->saveHistory('Go to articles');
        if (isset($_GET['delete'])) {
            $result = $this->Admin_model->deleteArticle($_GET['delete']);
            if ($result == true) {
                $this->session->set_flashdata('result_delete', 'Article is deleted!');
                $this->saveHistory('Delete article id - ' . $_GET['delete']);
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with article delete!');
            }
            redirect('admin/articles');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Articles';
        $head['description'] = '!';
        $head['keywords'] = '';

        if ($this->input->get('search') !== NULL) {
            $search = $this->input->get('search');
            $this->saveHistory('Search for article - ' . $search);
        } else {
            $search = null;
        }
        if ($this->input->get('orderby') !== NULL) {
            $orderby = $this->input->get('orderby');
        } else {
            $orderby = null;
        }
        $rowscount = $this->Admin_model->articlesCount($search);
        $data['articles'] = $this->Admin_model->getArticles($this->num_rows, $page, $search, $orderby);
        $data['links_pagination'] = pagination('admin/articles', $rowscount, $this->num_rows, 3);
        $data['languages'] = $this->Admin_model->getLanguages();

        $this->load->view('_parts/header', $head);
        $this->load->view('publisher/articles', $data);
        $this->load->view('_parts/footer');
    }

    /*
     * called from ajax
     */

    public function articlestatusChange()
    {
        $this->login_check();
        $result = $this->Admin_model->articleStatusChange($_POST['id'], $_POST['to_status']);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Change product id ' . $_POST['id'] . ' to status ' . $_POST['to_status']);
    }

}

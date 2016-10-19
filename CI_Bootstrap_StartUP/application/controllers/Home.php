<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    private $num_rows = 20;

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('pagination'));
    }

    public function index($page = 0) {
        $data = array();
        $head = array();
        $head['title'] = 'Title information‎';
        $head['description'] = 'Description info';
        $head['keywords'] = 'key,words,for,seo';
        $data['articles'] = $this->Articles_model->getArticles('test', $this->my_lang);
        /* Pagination
          $rowscount = $this->Articles_model->articlesCount('blog');
          $data['news'] = $this->Articles_model->get_all($this->num_rows, $page);
          $data['links_pagination'] = pagination('новини', $rowscount, $this->num_rows);
         */
        $this->render('home', $head, $data);
    }

}

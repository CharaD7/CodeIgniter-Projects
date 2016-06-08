<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class View_article extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($id) {
        $data = array();
        $head = array();
        //$this->load->vars($data_header);
        $data['article'] = $this->Articles_model->getOneArticle($id, null);
        if ($data['article'] === null) {
            show_404();
        }
        $head['title'] = $data['article']['title'];
        $description = url_title(character_limiter(strip_tags($data['article']['description']), 130));
        $description = str_replace("-", " ", $description) . '..';
        $head['description'] = $description;
        $head['keywords'] = '';
        $this->render('view_article', $head, $data);
    }

}

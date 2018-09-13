<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('pagination'));
    }

    public function index($page = 0)
    {
        $data = array();
        $head = array();
        $head['title'] = 'Title information‎';
        $head['description'] = 'Description info';
        $head['keywords'] = 'key,words,for,seo';
        $article = $this->Public_model->getOneArticle(1);

        /*
         * Get images from article
         */
        $data['description'] = $this->replaceGalleryImages($article['description']); 
        $this->render('home', $head, $data);
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aboutus extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array();
        $head = array();
        $head['title'] = '';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->render('about_us', $head, $data);
    }

}

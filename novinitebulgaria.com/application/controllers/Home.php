<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array();
        $head = array();
        if (isset($_GET['add-news']) && $_GET['add-news'] == 'добави-твоя-новина') {
            $head['title'] = 'Добави твоя новина в NoviniteBulgaria.com';
            $head['description'] = 'Description info';
        } else {
            $head['title'] = 'Title information‎';
            $head['description'] = 'Description info';
        }
        $head['keywords'] = 'key,words,for,seo';
        if (isset($_POST['setPublicArticle'])) {
            $this->setPublicArticle();
        }
        $data['sliderArticles'] = $this->Articles_model->getSliderArticles();
        $data['lastGosspis'] = $this->Articles_model->getLastGossips();
        $data['categoriesNoNav'] = $this->Articles_model->getNoNavCategories();
        $data['mostReadCategs'] = $this->Articles_model->getMostReadCategories();
        $this->render('home', $head, $data);
    }

    private function setPublicArticle()
    {
        $errors = array();
        if (mb_strlen(trim($_POST['title'])) == 0) {
            $errors[] = 'No Title';
        }
        if (mb_strlen(trim(strip_tags($_POST['description']))) == 0) {
            $errors[] = 'No Description';
        }
        if (empty($errors) && $_SESSION['iPublish'] < 10) {
            unset($_POST['setPublicArticle']);
            $config['upload_path'] = './attachments/images/';
            $allowed_img_types = $this->config->item('allowed_img_types');
            $config['allowed_types'] = $allowed_img_types;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('userfile')) {
                log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
            }
            $img = $this->upload->data();
            if ($img['file_name'] != null) {
                $_POST['image'] = $img['file_name'];
            }
            $translations = array(
                'abbr' => array('bg'),
                'title' => array($_POST['title']),
                'description' => array($_POST['description'])
            );
            $_POST['visibility'] = '0';
            $_POST['from_public'] = '1';
            $_POST['category'] = '1';
            $_POST['title_for_url'] = $_POST['title'];
            unset($_POST['title'], $_POST['description']);
            $insertId = $this->AdminModel->setArticle($_POST, 0);
            $this->AdminModel->setArticleTranslation($translations, $insertId, 0);
            if (!isset($_SESSION['iPublish'])) {
                $_SESSION['iPublish'] = 1;
            } else {
                $_SESSION['iPublish'] += 1;
            }
        }
        if (isset($_SESSION['iPublish']) && $_SESSION['iPublish'] >= 1000) {
            redirect('home/fuckyou');
        }
        $this->session->set_flashdata('publicPublishOk', lang('publishedOk'));
        redirect(base_url());
    }

    public function category($category, $page = 0)
    {
        $this->load->helper(array('pagination'));
        if ($category == null) {
            redirect(base_url());
        }
        $url = urldecode($category);
        $categoryInfo = $this->Articles_model->getCategoryIdByUrl($url);
        if ($categoryInfo == null) {
            redirect(base_url());
        }
        if (!isset($_SESSION['categ_views']) || !in_array($url, $_SESSION['categ_views'])) {
            $_SESSION['categ_views'][] = $url;
            $this->Articles_model->updateCategoryViews($url);
        }
        $data = array();
        $head = array();
        $head['title'] = 'Title information‎';
        $head['description'] = 'Description info';
        $head['keywords'] = 'key,words,for,seo';
        $data['categorieName'] = $categoryInfo['name'];
        $data['articles'] = $this->Articles_model->getArticlesByCategory($categoryInfo['id'], $this->num_rows, $page);
        $rowscount = $this->Articles_model->getArticlesByCategoryCount($categoryInfo['id']);
        $data['links_pagination'] = pagination('категория/' . $category, $rowscount, $this->num_rows, 3);
        $this->render('list_items', $head, $data);
    }

    public function search($page = 0)
    {
        $this->load->helper(array('pagination'));
        $data = array();
        $head = array();
        $head['title'] = 'Title information‎';
        $head['description'] = 'Description info';
        $head['keywords'] = 'key,words,for,seo';
        if (!isset($_GET['search'])) {
            redirect(base_url());
        }
        $data['articles'] = $this->Articles_model->getArticlesBySearch($_GET['search'], $this->num_rows, $page);
        $rowscount = $this->Articles_model->getArticlesBySearchCount($_GET['search']);
        $data['links_pagination'] = pagination('резултати/търсене', $rowscount, $this->num_rows, 3);
        $this->render('list_items', $head, $data);
    }

    public function fuckyou()
    {
        $this->Articles_model->addStupid();
    }

}

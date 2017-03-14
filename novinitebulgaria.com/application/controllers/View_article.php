<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class View_article extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($id)
    {
        $data = array();
        $head = array();
        $data['article'] = $this->Articles_model->getOneArticle($id);
        if ($data['article'] === null) {
            show_404();
        }
        if (!isset($_SESSION['views']) || !in_array($id, $_SESSION['views'])) {
            $_SESSION['views'][] = $id;
            $this->Articles_model->updateViews($id);
        }
        if (isset($data['article']['image'])) {
            $img = base_url('attachments/images/' . $data['article']['image']);
        } else {
            $img = $data['article']['image_link'];
        }
        $head['image'] = $data['image'] = $img;
        $head['title'] = $data['article']['title'];
        $description = url_title(character_limiter(strip_tags($data['article']['description']), 130));
        $description = str_replace("-", " ", $description) . '..';
        $head['description'] = $description;
        $head['keywords'] = str_replace(' ', ',', $head['title']);
        $data['sameCategory'] = $this->Articles_model->getArticlesByCategory($data['article']['category'], 15, 0);
        $this->render('view_article', $head, $data);
    }

}

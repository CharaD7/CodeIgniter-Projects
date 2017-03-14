<?php

class MY_Controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function render($view, $head, $data = null, $footer = null)
    {
        $head['topNews'] = $this->Articles_model->getTopArticleNews();
        $all_categories = $this->Articles_model->getCategories();
        $allNoNavCategories = $this->Articles_model->getNoNavCategories();
        $vars = $this->loadValueStores();
        $this->load->vars($vars);
        $head['all_categories'] = buildTree($all_categories);
        $head['allNoNavCategories'] = buildTree($allNoNavCategories);
        $data['lastArticles'] = $this->Articles_model->getLastArticles();
        $data['mostReadArticles'] = $this->Articles_model->getMostReadArticles();
        $this->load->view('_parts/header', $head);
        $this->load->view($view, $data);
        $this->load->view('_parts/footer', $footer);
    }

    private function loadValueStores()
    {
        $valueStores = $this->AdminModel->getValueStores();
        $vars = array();
        if (!empty($valueStores)) {
            foreach ($valueStores as $valueStore) {
                $vars[$valueStore['my_key']] = $valueStore['value'];
            }
        }
        return $vars;
    }

}

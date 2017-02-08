<?php

class MY_Controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function render($view, $head, $data = null, $footer = null)
    {
        $this->loadValueStores();
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
        $this->load->vars($vars);
    }

}

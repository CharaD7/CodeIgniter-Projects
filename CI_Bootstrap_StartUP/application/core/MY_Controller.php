<?php

class MY_Controller extends MX_Controller {

    public $my_lang;
    public $def_lang;
    public $lang_link;

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/Admin_model');
        $this->setLanguage();
    }

    public function render($view, $head, $data = null, $footer = null) {
        $this->load->view('_parts/header', $head);
        $this->load->view($view, $data);
        $this->load->view('_parts/footer', $footer);
    }

    private function setLanguage() { //set language of site
        $langs = $this->Admin_model->getLanguages();
        $have = 0;
        $def_lang = $this->config->item('language');
        $def_lang_abbr = $this->def_lang = $this->config->item('language_abbr');
        if ($this->uri->segment(1) == $def_lang_abbr) {
            
        }
        foreach ($langs->result() as $lang) {
            if ($lang->abbr == $this->uri->segment(1)) {
                $this->session->set_userdata('lang', $lang->name);
                $this->session->set_userdata('lang_abbr', $lang->abbr);
                $have = 1;
            }
        }
        if ($have == 0)
            $this->session->unset_userdata('lang');

        if ($this->session->userdata('lang') !== NULL) {
            $this->lang->load("site", $this->session->userdata('lang'));
        } else {
            $this->session->set_userdata('lang', $def_lang);
            $this->session->set_userdata('lang_abbr', $def_lang_abbr);
            $this->lang->load("site", $def_lang);
        }
        $this->my_lang = $this->session->userdata('lang_abbr');

        $this->my_lang != $this->def_lang ? $this->lang_link = $this->my_lang . '/' : $this->lang_link = '';
    }

}

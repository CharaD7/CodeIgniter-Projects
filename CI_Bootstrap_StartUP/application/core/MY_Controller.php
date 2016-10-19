<?php

class MY_Controller extends MX_Controller
{

    public $my_lang;
    public $def_lang;
    public $lang_link;
    public $my_lang_full;
    public $all_langs;
    public $lang_url;

    public function __construct()
    {
        parent::__construct();
        $this->lang_url = rtrim(base_url($this->lang_link), '/');
        $this->load->model('admin/Admin_model');
        $this->setLanguage();
    }

    public function render($view, $head, $data = null, $footer = null)
    {
        $vars['lang_url'] = $this->lang_url;
        $this->load->vars($vars);
        $this->load->view('_parts/header', $head);
        $this->load->view($view, $data);
        $this->load->view('_parts/footer', $footer);
    }

    private function setLanguage()
    { //set language of site
        $langs = $this->Admin_model->getLanguages();
        $have = 0;
        $def_lang = $this->config->item('language');
        $def_lang_abbr = $this->def_lang = $this->config->item('language_abbr');
        $this->currency = $this->config->item('currency');
        if ($this->uri->segment(1) == $def_lang_abbr) {
            redirect(base_url());
        }
        foreach ($langs->result() as $lang) {
            $this->all_langs[$lang->abbr]['name'] = $lang->name;
            $this->all_langs[$lang->abbr]['flag'] = $lang->flag;
            if ($lang->abbr == $this->uri->segment(1)) {
                $this->session->set_userdata('lang', $lang->name);
                $this->session->set_userdata('lang_abbr', $lang->abbr);
                $this->currency = $lang->currency;
                $have = 1;
            }
        }
        if ($have == 0) {
            $this->session->unset_userdata('lang');
        }
        if ($this->session->userdata('lang') !== NULL) {
            $this->lang->load("site", $this->session->userdata('lang'));
        } else {
            $this->session->set_userdata('lang', $def_lang);
            $this->session->set_userdata('lang_abbr', $def_lang_abbr);
            $this->lang->load("site", $def_lang);
        }
        $this->my_lang = $this->session->userdata('lang_abbr');
        $this->my_lang_full = $this->session->userdata('lang');

        $this->my_lang != $this->def_lang ? $this->lang_link = $this->my_lang . '/' : $this->lang_link = '';
    }

}

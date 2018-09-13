<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ADMIN_Controller extends MX_Controller
{

    protected $username;
    protected $allowed_img_types;
    protected $history;
    protected $def_lang;

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->helper(
                array(
                    'file',
                    'pagination',
                    'except_letters',
                    'currencies',
                    'rcopy',
                    'rrmdir',
                    'rreadDir',
                    'savefile'
                )
        );
        $this->history = $this->config->item('admin_history');
        $this->allowed_img_types = $this->config->item('allowed_img_types');
        $this->def_lang = $this->config->item('language_abbr');
    }

    protected function login_check()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin');
        }
        $this->username = $this->session->userdata('logged_in');
    }

    protected function saveHistory($activity)
    {
        if ($this->history === true) {
            $usr = $this->username;
            $this->Admin_model->setHistory($activity, $usr);
        }
    }

    public function getActivePages()
    {
        return $this->Admin_model->getPages(true, false);
    }

}

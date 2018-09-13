<?php

/*
 *  Author:    Kiril Kirkov
 *  Github:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Publish extends ADMIN_Controller
{

    private $gallery_path;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Categories_model');
        $this->gallery_path = GALLERY_PATH;
    }

    public function index($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Admin_model->getOneArticle($id);
            $trans_load = $this->Admin_model->getTranslations($id, 'article');
        }
        if (isset($_POST['submit'])) {
            if ($id > 0) {
                $is_update = true;
            }
            unset($_POST['submit']);
            $config['upload_path'] = './attachments/images/';
            $config['allowed_types'] = $this->allowed_img_types;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('userfile')) {
                log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
            }
            $img = $this->upload->data();
            if ($img['file_name'] != null) {
                $_POST['image'] = $img['file_name'];
            }
            $this->do_upload_others_images();
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $translations = array(
                'abbr' => $_POST['translations'],
                'title' => $_POST['title'],
                'description' => $_POST['description']
            );
            $flipped = array_flip($_POST['translations']);
            $_POST['title_for_url'] = $_POST['title'][$flipped[$this->def_lang]];
            unset($_POST['translations'], $_POST['title'], $_POST['description'], $_POST['price'], $_POST['old_price']); //remove for product
            $result = $this->Admin_model->setArticle($_POST, $id);
            if ($result !== false) {
                $this->Admin_model->setArticleTranslation($translations, $result, $is_update); // send to translation table
                $this->session->set_flashdata('result_publish', 'product is published!');
                if ($id == 0) {
                    $this->saveHistory('Success published product');
                } else {
                    $this->saveHistory('Success updated product');
                }
                redirect('admin/articles');
            } else {
                $this->session->set_flashdata('result_publish', 'Problem with product publish!');
            }
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Publish Article';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Admin_model->getLanguages();
        $data['categories'] = $this->Categories_model->getAllCategories();
        $gallery_dirs = array_filter(glob('./attachments/gallery/*'), 'is_dir');
        foreach ($gallery_dirs as &$gallery_dir) {
            $gallery_dir = str_replace('./' . $this->gallery_path, '', $gallery_dir);
        }

        $data['gdirs'] = $gallery_dirs;
        $this->load->view('_parts/header', $head);
        $this->load->view('publisher/publish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish article');
    }

    private function do_upload_others_images()
    {
        $upath = './attachments/images/' . $_POST['folder'] . '/';
        if (!file_exists($upath)) {
            mkdir($upath, 0777);
        }

        $this->load->library('upload');

        $files = $_FILES;
        $cpt = count($_FILES['others']['name']);
        for ($i = 0; $i < $cpt; $i++) {
            unset($_FILES);
            $_FILES['others']['name'] = $files['others']['name'][$i];
            $_FILES['others']['type'] = $files['others']['type'][$i];
            $_FILES['others']['tmp_name'] = $files['others']['tmp_name'][$i];
            $_FILES['others']['error'] = $files['others']['error'][$i];
            $_FILES['others']['size'] = $files['others']['size'][$i];

            $this->upload->initialize(array(
                'upload_path' => $upath,
                'allowed_types' => $this->allowed_img_types
            ));
            $this->upload->do_upload('others');
        }
    }

    public function removeOtherImage()
    {
        if ($this->input->is_ajax_request()) {
            $img = './attachments/images/' . $_POST['folder'] . '/' . $_POST['image'];
            unlink($img);
        }
    }

}

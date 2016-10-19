<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
date_default_timezone_set('Europe/Sofia');

class Admin extends MX_Controller
{

    private $num_rows = 10;
    private $thumb_width = 300;
    private $thumb_height = 300;
    private $def_lang;
    private $def_lang_name;
    private $username;
    private $history;
    private $allowed_img_types = 'gif|jpg|png|jpeg|JPG|PNG|JPEG';

    //$data['links_pagination'] = pagination('admin/view_all', $rowscount, $this->num_rows, 3);

    public function __construct()
    {
        parent::__construct();
        $this->history = $this->config->item('admin_history');
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('text', 'file', 'pagination', 'text', 'except_letters', 'currencies', 'rcopy', 'rrmdir', 'rreadDir', 'savefile'));
        $this->def_lang = $this->config->item('language_abbr');
        $this->def_lang_name = $this->config->item('language');
        $this->load->Model('Admin_model');
    }

    public function index()
    {
        $data = array();
        $head = array();
        $head['title'] = 'Administration';
        $head['description'] = '!';
        $head['keywords'] = '';
        $this->load->view('_parts/header', $head);
        if ($this->session->userdata('logged_in')) {
            //$this->load->view('home_adm', $data);
            $this->username = $this->session->userdata('logged_in');
            redirect('admin/publish');
        } else {
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if ($this->form_validation->run($this)) {
                $result = $this->Admin_model->loginCheck($_POST);
                if (!empty($result)) {
                    $this->session->set_userdata('logged_in', $result['username']);
                    $this->username = $this->session->userdata('logged_in');
                    $this->saveHistory('User ' . $result['username'] . ' logged in');
                    redirect('admin/publish');
                } else {
                    $this->saveHistory('Cant login with - User:' . $_POST['username'] . ' and Pass:' . $_POST['username']);
                    $this->session->set_flashdata('err_login', 'Wrong username or password!');
                }
            }
            $this->load->view('login');
        }
        $this->load->view('_parts/footer');
    }

    public function publish($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Admin_model->getOneArticle($id);
            $trans_load = $this->Admin_model->getTranslations($id, 'article');
        }
        if (isset($_POST['submit'])) {
            if ($id > 0)
                $is_update = true;
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
                'basic_description' => $_POST['basic_description'],
                'description' => $_POST['description']
            );
            $flipped = array_flip($_POST['translations']);
            $_POST['title_for_url'] = $_POST['title'][$flipped[$this->def_lang]];
            unset($_POST['translations'], $_POST['title'], $_POST['basic_description'], $_POST['description'], $_POST['price'], $_POST['old_price']); //remove for product
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
        $head['title'] = 'Administration - Publish Product';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Admin_model->getLanguages();
        $data['categories'] = $this->Admin_model->getCategories();
        $this->load->view('_parts/header', $head);
        $this->load->view('publish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
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

    public function articles($page = 0)
    {
        $this->login_check();
        $this->saveHistory('Go to articles');
        if (isset($_GET['delete'])) {
            $result = $this->Admin_model->deleteArticle($_GET['delete']);
            if ($result == true) {
                $this->session->set_flashdata('result_delete', 'Article is deleted!');
                $this->saveHistory('Delete article id - ' . $_GET['delete']);
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with article delete!');
            }
            redirect('admin/articles');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Articles';
        $head['description'] = '!';
        $head['keywords'] = '';

        if ($this->input->get('search') !== NULL) {
            $search = $this->input->get('search');
            $this->saveHistory('Search for article - ' . $search);
        } else {
            $search = null;
        }
        if ($this->input->get('orderby') !== NULL) {
            $orderby = $this->input->get('orderby');
        } else {
            $orderby = null;
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Admin_model->articlesCount($search);
        $data['products'] = $this->Admin_model->getArticles($this->num_rows, $page, $search, $orderby);
        $data['links_pagination'] = pagination('admin/articles', $rowscount, $this->num_rows, 3);
        $data['languages'] = $this->Admin_model->getLanguages();

        $this->load->view('_parts/header', $head);
        $this->load->view('articles', $data);
        $this->load->view('_parts/footer');
    }

    public function adminUsers()
    {
        $this->login_check();
        if (isset($_GET['delete'])) {
            $result = $this->Admin_model->deleteAdminUser($_GET['delete']);
            if ($result == true) {
                $this->saveHistory('Delete user id - ' . $_GET['delete']);
                $this->session->set_flashdata('result_delete', 'User is deleted!');
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with user delete!');
            }
            redirect('admin/adminUsers');
        }
        if (isset($_GET['edit']) && !isset($_POST['username'])) {
            $_POST = $this->Admin_model->getAdminUsers($_GET['edit']);
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Admin Users';
        $head['description'] = '!';
        $data['def_lang'] = $this->def_lang;
        $head['keywords'] = '';
        $data['users'] = $this->Admin_model->getAdminUsers();
        $this->form_validation->set_rules('username', 'User', 'trim|required');
        if ($this->form_validation->run($this)) {
            $result = $this->Admin_model->setAdminUser($_POST);
            if ($result === true) {
                $this->session->set_flashdata('result_add', 'User is added!');
                $this->saveHistory('Create admin user - ' . $_POST['username']);
            } else {
                $this->session->set_flashdata('result_add', 'Problem with user add!');
                $this->saveHistory('Cant add admin user');
            }
            redirect('admin/adminUsers');
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('adminUsers', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Admin Users');
    }

    public function languages()
    {
        $this->login_check();
        if (isset($_GET['delete'])) {
            $result = $this->Admin_model->deleteLanguage($_GET['delete']);
            if ($result == true) {
                $this->saveHistory('Delete language id - ' . $_GET['delete']);
                $this->session->set_flashdata('result_delete', 'Language is deleted!');
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with language delete!');
            }
            redirect('admin/languages');
        }
        if (isset($_GET['editLang'])) {
            $num = $this->Admin_model->countLangs($_GET['editLang']);
            if ($num == 0)
                redirect('admin/languages');
            $langFiles = $this->getLangFolderForEdit();
        }
        if (isset($_POST['goDaddyGo'])) {
            $this->saveLanguageFiles();
            redirect('admin/languages');
        }
        if (!is_writable('application/languages/')) {
            $data['writable'] = 'Languages folder is not writable!';
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Languages';
        $head['description'] = '!';
        $data['def_lang'] = $this->def_lang;
        if (isset($langFiles)) {
            $data['arrPhpFiles'] = $langFiles[0];
            $data['arrJsFiles'] = $langFiles[1];
        }
        $head['keywords'] = '';
        $data['languages'] = $this->Admin_model->getLanguages();

        if (isset($_POST['name']) && isset($_POST['abbr'])) {
            $dublicates = $this->Admin_model->countLangs($_POST['name'], $_POST['abbr']);
            if ($dublicates == 0) {
                $config['upload_path'] = './attachments/lang_flags/';
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('userfile')) {
                    $error = $this->upload->display_errors();
                    log_message('error', 'Language image upload error: ' . $error);
                } else {
                    $img = $this->upload->data();
                    if ($img['file_name'] != null)
                        $_POST['flag'] = $img['file_name'];
                }
                $result = $this->Admin_model->setLanguage($_POST);
                if ($result === true) {
                    $this->createLangFolders();
                    $this->session->set_flashdata('result_add', 'Language is added!');
                    $this->saveHistory('Create language - ' . $_POST['abbr']);
                } else {
                    $this->session->set_flashdata('result_add', 'Problem with language add!');
                }
            } else
                $this->session->set_flashdata('result_add', 'This language exsists!');
            redirect('admin/languages');
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('languages', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to languages');
    }

    private function saveLanguageFiles()
    {
        $i = 0;
        $prevFile = 'none';
        $phpFileInclude = "<?php \n";
        foreach ($_POST['php_files'] as $phpFile) {
            if ($phpFile != $prevFile && $i > 0) {
                savefile($prevFile, $phpFileInclude);
                $phpFileInclude = "<?php \n";
            }
            $phpFileInclude .= '$lang[\'' . htmlentities($_POST['php_keys'][$i]) . '\'] = \'' . htmlentities($_POST['php_values'][$i]) . '\';' . "\n";
            $prevFile = $phpFile;
            $i++;
        }
        savefile($phpFile, $phpFileInclude);


        $i = 0;
        $prevFile = 'none';
        $jsFileInclude = "var lang = { \n";
        foreach ($_POST['js_files'] as $jsFile) {
            if ($jsFile != $prevFile && $i > 0) {
                $jsFileInclude .= "};";
                savefile($prevFile, $jsFileInclude);
                $jsFileInclude = "var lang = { \n";
            }
            $jsFileInclude .= htmlentities($_POST['js_keys'][$i]) . ':' . '"' . htmlentities($_POST['js_values'][$i]) . '",' . "\n";
            $prevFile = $jsFile;
            $i++;
        }
        $jsFileInclude .= "};";
        savefile($jsFile, $jsFileInclude);
    }

    private function getLangFolderForEdit()
    {
        $langFiles = array();
        $files = rreadDir('application/language/' . $_GET['editLang'] . '/');
        $arrPhpFiles = $arrJsFiles = array();
        foreach ($files as $ext => $filesLang) {
            foreach ($filesLang as $fileLang) {
                if ($ext == 'php') {
                    require $fileLang;
                    if (isset($lang)) {
                        $arrPhpFiles[$fileLang] = $lang;
                        unset($lang);
                    }
                }
                if ($ext == 'js') {
                    $jsTrans = file_get_contents($fileLang);
                    preg_match_all('/(.+?)"(.+?)"/', $jsTrans, $PMA);
                    $arrJsFiles[$fileLang] = $PMA;
                    unset($PMA);
                }
            }
        }
        $langFiles[0] = $arrPhpFiles;
        $langFiles[1] = $arrJsFiles;
        return $langFiles;
    }

    private function createLangFolders()
    {
        $newLang = strtolower(trim($_POST['name']));
        if ($newLang != '') {
            $from = 'application/language/' . $this->def_lang_name;
            $to = 'application/language/' . $newLang;
            rcopy($from, $to);
        }
    }

    public function categories()
    {
        $this->login_check();
        if (isset($_GET['delete'])) {
            $result = $this->Admin_model->deleteCategorie($_GET['delete']);
            if ($result == true) {
                $this->saveHistory('Delete categorie id - ' . $_GET['delete']);
                $this->session->set_flashdata('result_delete', 'Categorie is deleted!');
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with categorie delete!');
            }
            redirect('admin/categories');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Categories';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['categoiries'] = $this->Admin_model->getCategories();

        if (!isset($_POST['id']) || $_POST['id'] == 0) {
            $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[categories.name]');
        } else {
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
        }
        if ($this->form_validation->run($this)) {
            $result = $this->Admin_model->setCategorie($_POST);
            if ($result === true) {
                $this->session->set_flashdata('result_add', 'Categorie is added!');
                $this->saveHistory('Create categorie - ' . $_POST['name']);
                redirect('admin/categories');
            } else {
                $this->session->set_flashdata('result_add', 'Problem with categorie add!');
            }
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('categories', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to categories');
    }

    public function fileManager()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - File Manager';
        $head['description'] = '!';
        $head['keywords'] = '';

        $this->load->view('_parts/header', $head);
        $this->load->view('filemanager', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to File Manager');
    }

    public function querybuilder()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - QueryBuilder';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['query'])) {
            $this->saveHistory('Send query from querybuilder: ' . $_POST['query']);
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('querybuilder', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to QueryBuilder Page');
    }

    public function history($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - History';
        $head['description'] = '!';
        $head['keywords'] = '';

        $rowscount = $this->Admin_model->historyCount();
        $data['actions'] = $this->Admin_model->getHistory($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/history', $rowscount, $this->num_rows, 3);
        $data['history'] = $this->history;

        $this->load->view('_parts/header', $head);
        $this->load->view('history', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to History');
    }

    private function saveHistory($activity)
    {
        if ($this->history === true) {
            $usr = $this->username;
            $this->Admin_model->setHistory($activity, $usr);
        }
    }

    private function createThumb()
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = './attachments/images/' . $this->upload->file_name;
        $config['new_image'] = './attachments/thumbs/' . $this->upload->file_name;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = FALSE;
        $config['thumb_marker'] = '';
        $config['width'] = $this->thumb_width;
        $config['height'] = $this->thumb_height;

        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            log_message('error', 'Thumb Upload Error: ' . $this->image_lib->display_errors());
        }
    }

    public function changePass()
    {  //called from ajax
        $this->login_check();
        $result = $this->Admin_model->changePass($_POST['new_pass'], $this->username);
        if ($result == true)
            echo 1;
        else
            echo 0;
        $this->saveHistory('Password change for user: ' . $this->username);
    }

    public function articleStatusChange()
    { //called from ajax
        $this->login_check();
        $result = $this->Admin_model->articleStatusChagne($_POST['id'], $_POST['to_status']);
        if ($result == true)
            echo 1;
        else
            echo 0;
        $this->saveHistory('Change article id ' . $_POST['id'] . ' to status ' . $_POST['to_status']);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin');
    }

    private function login_check()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin');
        }
        $this->username = $this->session->userdata('logged_in');
    }

}

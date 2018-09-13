<?php

/*
 *  Author:    Kiril Kirkov
 *  Github:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Categories extends ADMIN_Controller
{  
	
    public function __construct()
    {
        parent::__construct();  
        $this->load->model('Categories_model');
    }

    public function index($id = 0)
    {
        $this->login_check();
		$translation_load = null; 
        if (isset($_POST['goSubmit']) && $id == 0) {
            $this->Categories_model->setCategory($_POST);
            $this->session->set_flashdata('result', 'Категорията е добавена');
			$this->saveHistory('Create category with name - '.$_POST['title'][0]); 
            redirect('admin/categories');
        } elseif(isset($_POST['goSubmit']) && $id > 0) {
			$_POST['edit'] = $id;
            $this->Categories_model->editCategory($_POST);
            $this->session->set_flashdata('result', 'Категорията е редактирана');
			$this->saveHistory('Edit category id - '.$id); 
            redirect('admin/categories/edit/'.$id);
		}
		if($id > 0) {
			$translation_load = $this->Categories_model->getCategory($id);
		} 
		$data = [];
		$head = [];
        $head['title'] = 'Категории';
        $head['description'] = '';
        $head['keywords'] = '';
		$data['languages'] = $this->Admin_model->getLanguages();
		$data['trans_load'] = $translation_load;
		$data['edit'] = $id;
		$data['allCategories'] = $this->Categories_model->getAllCategories($id);
		$data['categories'] = $this->Categories_model->getCategories(isset($_GET['parent_for'])?$_GET['parent_for']:null);
		if(isset($_GET['parent_for'])) {
			$data['parents'] = $this->Categories_model->getParents($_GET['parent_for']); 
		}
        $this->load->view('_parts/header', $head);
        $this->load->view('publisher/categories', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to categories page');
    } 
	
	public function delete($id)
	{
		$this->Categories_model->deleteCategorie($id);
		$this->session->set_flashdata('result', 'Категорията е изтрита');
		$this->saveHistory('Delete category - '.$id);
		redirect('admin/categories');
	}
	
	/*
	 * Ajax url checker
	 */
	public function urlcategorychecker()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} 
		echo $this->Categories_model->freeUrlCheck($_POST['title']);
	}
}

<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Blog extends ADMIN_Controller
{
	
	private $num_rows = 10;
 
    public function __construct()
    {
        parent::__construct(); 
		$this->load->model('Blog_model');
    }

    public function index($page = 0)
    {
        $this->login_check();
        $trans_load = null;
        if (isset($_GET['editPost']) && !isset($_POST['submitPost'])) {
			$this->saveHistory('Edit blog post id - '.$_GET['editPost']);
            $_POST = $this->Blog_model->getOnePost($_GET['editPost']);
            $trans_load = $this->Blog_model->getTranslations($_GET['editPost']);
        }
        if (isset($_POST['submitPost'])) {
            $_POST['image'] = $this->uploadImage();
			$_POST['id'] = isset($_GET['editPost']) ? $_GET['editPost'] : 0; 
			$this->saveHistory('Set/update blog post - '.$_POST['title'][0]);
            $this->Blog_model->setPost($_POST);
            $this->session->set_flashdata('result', 'Публикацията е добавена');
            redirect('admin/blog');
        }
        if (isset($_GET['editPostCategory']) && !isset($_POST['submitPostCategory'])) {
			$this->saveHistory('Edit blog post category - '.$_GET['editPostCategory']);
            $_POST = $this->Blog_model->getOneCategory($_GET['editPostCategory']);
            $trans_load = $this->Blog_model->getCategoryTranslations($_GET['editPostCategory']);
        }
        if (isset($_POST['submitPostCategory'])) {  
			$this->saveHistory('Set/update blog category - '.$_POST['title'][0]);
			$_POST['id'] = isset($_GET['editPostCategory']) ? $_GET['editPostCategory'] : 0; 
			$this->Blog_model->setBlogCategory($_POST);
            $this->session->set_flashdata('result', 'Категорията е добавена');
            redirect('admin/blog');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Управление - Блог';
        $head['description'] = '';
        $head['keywords'] = ''; 
		$data['languages'] = $this->Admin_model->getLanguages();
        $data['trans_load'] = $trans_load; 
		$rowscount = $this->Blog_model->postsCount();
        $data['posts'] = $this->Blog_model->getPosts($this->num_rows, $page); 
		$data['links_pagination'] = pagination('admin/blog', $rowscount, $this->num_rows, 3); 
		$data['categories'] = $this->Blog_model->getCategories(); 
        $this->load->view('_parts/header', $head);
        $this->load->view('blog', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to blog page');
    } 
	
	private function uploadImage()
    {
        $config['upload_path'] = './'.BLOG_IMAGE;
        $config['allowed_types'] = $this->allowed_img_types;
		$config['remove_spaces'] = TRUE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
	
	public function delete($id)
	{
		$this->Blog_model->deletePost($id);
		$this->session->set_flashdata('result', 'Публикацията е изтрита');
		$this->saveHistory('Delete blog post - '.$id);
		redirect('admin/blog');
	}

	public function deletecategory($id)
	{
		$this->Blog_model->deletePostCategory($id);
		$this->session->set_flashdata('result', 'Категорията е изтрита');
		$this->saveHistory('Delete blog category - '.$id);
		redirect('admin/blog');
	}
	
	/*
	 * Ajax url checker
	 */
	public function urlblogcategorychecker()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} 
		echo $this->Blog_model->freeCategoryUrlCheck($_POST['title']);
	}
	
	/*
	 * Ajax url checker
	 */
	public function urlblogchecker()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} 
		echo $this->Blog_model->freeUrlCheck($_POST['title']);
	}

}

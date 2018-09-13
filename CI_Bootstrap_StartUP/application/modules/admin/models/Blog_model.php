<?php

class Blog_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
	
    public function setPost($post)
    {
        $this->db->trans_begin();
        $is_update = false;
		$id = $post['id'];
        if ($id > 0) {
            $is_update = true;
            $this->db->where('id', $id);
            if (!$this->db->update('blog_posts', array(
				'category' => $post['category'],
				'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
				'position' => $post['position']
			))) {
			log_message('error', print_r($this->db->error(), true));
            }
        } else {
            /*
             * Lets get what is default tranlsation number
             * in titles and convert it to url
             * We want our plaform public ulrs to be in default 
             * language that we use
             */
            $i = 0;
            foreach ($_POST['translations'] as $translation) {
                if ($translation == MY_DEFAULT_LANGUAGE_ABBR) {
                    $myTranslationNum = $i;
                }
                $i++;
            }
            if (!$this->db->insert('blog_posts', array(
				'image' => $post['image'],
				'category' => $post['category'],
				'position' => $post['position'],
				'url' => except_letters($_POST['title'][$myTranslationNum]),
				'time' => time()
			))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id(); 
        }
        $this->setBlogTranslations($post, $id, $is_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
	
	private function setBlogTranslations($post, $id, $is_update)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id);
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
            $arr = array(
                'title' => $post['title'][$i],
                'description' => $post['description'][$i],
                'abbr' => $abbr,
                'for_id' => $id
            );
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                if (!$this->db->where('abbr', $abbr)->where('for_id', $id)->update('blog_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            } else {
                if (!$this->db->insert('blog_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            }
            $i++;
        }
    }
	
	public function getOnePost($id)
    {
		$this->db->where('deleted', 0); 
        $query = $this->db->where('id', $id)->get('blog_posts'); 
		return $query->row_array(); 
    }
	
	public function getOneCategory($id)
    {
		$this->db->where('deleted', 0); 
        $query = $this->db->where('id', $id)->get('blog_categories'); 
		return $query->row_array(); 
    }

    public function getTranslations($id)
    {
        $this->db->where('for_id', $id);
        $query = $this->db->get('blog_translations');
        $arr = array();
        foreach ($query->result() as $row) {
            $arr[$row->abbr]['title'] = $row->title;
            $arr[$row->abbr]['description'] = $row->description;
        }
        return $arr;
    }
	
    public function getCategoryTranslations($id)
    {
        $this->db->where('for_id', $id);
        $query = $this->db->get('blog_categories_translations');
        $arr = array();
        foreach ($query->result() as $row) {
            $arr[$row->abbr]['title'] = $row->title; 
        }
        return $arr;
    }
	
	public function postsCount()
    { 
		$this->db->where('deleted', 0); 
        return $this->db->count_all_results('blog_posts');
    }

    public function getPosts($limit, $page)
    {
		$this->db->where('deleted', 0);
		$this->db->order_by('position', 'asc');
		$this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id');
		$this->db->where('blog_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->select('blog_posts.id, blog_translations.title, blog_translations.description, blog_posts.url, blog_posts.time, blog_posts.image')->get('blog_posts', $limit, $page);
		return $query->result_array();
	}
	
	public function deletePost($id)
	{
		$this->db->where('id', $id);
		$this->db->update('blog_posts', ['deleted' => 1]);
	}
	
	public function deletePostCategory($id)
	{
		$this->db->where('id', $id);
		$this->db->update('blog_categories', ['deleted' => 1]);
	} 
	
	public function getCategories()
	{ 
		$this->db->where('deleted', 0);
		$this->db->order_by('position', 'asc');
		$this->db->join('blog_categories_translations', 'blog_categories_translations.for_id = blog_categories.id');
		$this->db->where('blog_categories_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
		$this->db->select('blog_categories_translations.*, blog_categories_translations.id as blog_trans_id, blog_categories.*');
        $query = $this->db->get('blog_categories');
		return $query->result_array();
	}
	
    public function setBlogCategory($post)
    {
        $this->db->trans_begin();
        $is_update = false;
		$id = $post['id'];
        if ($id > 0) {
            $is_update = true;
            $this->db->where('id', $id);
            if (!$this->db->update('blog_categories', array(
                        'position' => $post['position']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            /*
             * Lets get what is default tranlsation number
             * in titles and convert it to url
             * We want our plaform public ulrs to be in default 
             * language that we use
             */
            $i = 0;
            foreach ($_POST['translations'] as $translation) {
                if ($translation == MY_DEFAULT_LANGUAGE_ABBR) {
                    $myTranslationNum = $i;
                }
                $i++;
            }
            if (!$this->db->insert('blog_categories', array(
                        'position' => $post['position'],
						'url' => except_letters($_POST['title'][$myTranslationNum]),
                        'time' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id(); 
        }
        $this->setBlogCategoryTranslations($post, $id, $is_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
	
	private function setBlogCategoryTranslations($post, $id, $is_update)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id);
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
            $arr = array(
                'title' => $post['title'][$i],
				'abbr' => $abbr,
                'for_id' => $id
            );
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                if (!$this->db->where('abbr', $abbr)->where('for_id', $id)->update('blog_categories_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            } else {
                if (!$this->db->insert('blog_categories_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            }
            $i++;
        }
    }
	
	public function freeCategoryUrlCheck($title)
	{
		$url = except_letters($title);
		$this->db->where('url', $url);
        return $this->db->count_all_results('blog_categories'); 
	}
	
	public function freeUrlCheck($title)
	{
		$url = except_letters($title);
		$this->db->where('url', $url);
        return $this->db->count_all_results('blog_posts'); 
	}
    
}

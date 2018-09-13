<?php

class Public_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function articlesCount($category)
    {
        $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        $this->db->where('translations.type', 'article');
        $this->db->where('translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('category', $category);
        $this->db->where('visibility', 1);
        return $this->db->count_all_results('articles');
    }

    public function getArticles($category, $limit = null, $start = null)
    {
        if ($limit !== null && $start !== null) {
            $this->db->limit($limit, $start);
        }

        $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        $this->db->where('translations.type', 'article');
        $this->db->where('translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('category', $category);
        $this->db->where('visibility', 1);
        $query = $this->db->get('articles');
        return $query->result_array();
    }

    public function getOneArticle($id)
    {
        $this->db->where('articles.id', $id);
        $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        $this->db->where('translations.type', 'article');
        $this->db->where('translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $query = $this->db->get('articles');
        return $query->row_array();
    }

    public function getOneLanguage($myLang)
    {
        $this->db->select('*');
        $this->db->where('abbr', $myLang);
        $result = $this->db->get('languages');
        return $result->row_array();
    }

    public function setReservation($post)
    {
        $post['time_submited'] = time();
        $post['date_check_in'] = strtotime($post['date_check_in']);
        $post['date_check_out'] = strtotime($post['date_check_out']);
        $this->db->insert('reservations', $post);
    }

    public function blogPostsCount($url = null)
    {
        if ($url != null) {
            $url = urldecode(trim($url));
            $this->db->where('blog_categories.url', $url);
            $this->db->join('blog_categories', 'blog_categories.id = blog_posts.category');
            $this->db->where('blog_categories.deleted', 0);
        }
        $this->db->where('blog_posts.deleted', 0);
        return $this->db->count_all_results('blog_posts');
    }

    public function getLastBlogPosts($limit = 5, $category = null, $noId = null)
    {
        if ($category != null) {
            $this->db->where('category', $category);
        }
        if ($noId != null) {
            $this->db->where('blog_posts.id !=', $noId);
        }
        $this->db->select('blog_posts.*, blog_posts.id as blog_id, blog_translations.*, (SELECT title FROM blog_categories INNER JOIN blog_categories_translations 
		on blog_categories_translations.for_id = blog_categories.id WHERE abbr = "' . MY_LANGUAGE_ABBR . '" AND blog_categories.id = category LIMIT 1) as blog_category, (SELECT url FROM blog_categories INNER JOIN blog_categories_translations 
		on blog_categories_translations.for_id = blog_categories.id WHERE abbr = "' . MY_LANGUAGE_ABBR . '" AND blog_categories.id = category LIMIT 1) as category_url');
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $this->db->where('deleted', 0);
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id');
        $this->db->order_by('blog_posts.id', 'DESC');
        $this->db->limit($limit);
        $q = $this->db->get('blog_posts');
        return $q->result_array();
    }

    public function getBlogPosts($limit, $page, $url = null)
    {
        $this->db->where('blog_posts.deleted', 0);
        if ($url != null) {
            $url = urldecode(trim($url));
            $this->db->where('blog_categories.url', $url);
            $this->db->join('blog_categories', 'blog_categories.id = blog_posts.category');
            $this->db->where('blog_categories.deleted', 0);
        }
        $this->db->order_by('blog_posts.id', 'desc');
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id');
        $this->db->where('blog_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $this->db->select('blog_posts.*, blog_posts.id as blog_id, blog_translations.*, (SELECT title FROM blog_categories INNER JOIN blog_categories_translations 
		on blog_categories_translations.for_id = blog_categories.id WHERE abbr = "' . MY_LANGUAGE_ABBR . '" AND blog_categories.id = category LIMIT 1) as blog_category, (SELECT url FROM blog_categories INNER JOIN blog_categories_translations 
		on blog_categories_translations.for_id = blog_categories.id WHERE abbr = "' . MY_LANGUAGE_ABBR . '" AND blog_categories.id = category LIMIT 1) as category_url');
        $query = $this->db->get('blog_posts', $limit, $page);
        return $query->result_array();
    }

    public function getBlogCategories()
    {
        $this->db->select('title, url');
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $this->db->where('deleted', 0);
        $this->db->join('blog_categories_translations', 'blog_categories_translations.for_id = blog_categories.id');
        $this->db->order_by('position', 'ASC');
        $q = $this->db->get('blog_categories');
        return $q->result_array();
    }

    public function getBlogPostByUrl($url)
    {
        $url = urldecode(trim($url));
        $this->db->select('blog_posts.*, blog_posts.id as blog_id, blog_translations.*');
        $this->db->where('deleted', 0);
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $this->db->where('url', $url);
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id');
        $q = $this->db->get('blog_posts');
        return $q->row_array();
    }

}

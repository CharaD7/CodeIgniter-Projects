<?php

class Articles_model extends CI_Model
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

}

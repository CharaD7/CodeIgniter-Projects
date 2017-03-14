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

    public function updateViews($id)
    {
        $this->db->query('UPDATE articles SET views=views+1 WHERE id=' . $id);
    }

    public function getOneLanguage($myLang)
    {
        $this->db->select('*');
        $this->db->where('abbr', $myLang);
        $result = $this->db->get('languages');
        return $result->row_array();
    }

    public function getCategories()
    {
        $this->db->select('categories.sub_for, categories.id, categories.name as url, translations.name, IF(categories.sub_for = 0, 1, 0) as master');
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $this->db->where('nav =', 1);
        $this->db->where('type', 'categorie');
        $this->db->join('categories', 'categories.id = translations.for_id', 'INNER');
        $query = $this->db->get('translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr[] = $row;
            }
        }
        return $arr;
    }

    public function getSliderArticles()
    {
        $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        $this->db->where('translations.type', 'article');
        $this->db->where('translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('in_slider', 1);
        $query = $this->db->get('articles');
        return $query->result_array();
    }

    public function getLastArticles()
    {
        $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        $this->db->where('translations.type', 'article');
        $this->db->where('translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('in_slider', 0);
        $this->db->order_by('articles.id', 'desc');
        $this->db->limit(10);
        $query = $this->db->get('articles');
        return $query->result_array();
    }

    public function getMostReadArticles()
    {
        $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        $this->db->where('translations.type', 'article');
        $this->db->where('translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('in_slider', 0);
        $minusWeek = strtotime("-1 week");
        $this->db->where('time >', $minusWeek);
        $this->db->order_by('views', 'desc');
        $this->db->limit(10);
        $query = $this->db->get('articles');
        return $query->result_array();
    }

    public function getLastGossips()
    {
        $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        $this->db->where('translations.type', 'article');
        $this->db->where('translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('in_slider', 0);
        $this->db->order_by('articles.id', 'desc');
        $this->db->limit(5);
        $query = $this->db->get('articles');
        return $query->result_array();
    }

    public function getCategoryIdByUrl($url)
    {
        $this->db->select('categories.id, translations.name');
        $this->db->join('translations', 'translations.for_id = categories.id', 'left');
        $this->db->where('translations.type', 'categorie');
        $this->db->where('translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('categories.name', $url);
        $result = $this->db->get('categories');
        return $result->row_array();
    }

    public function getArticlesByCategory($id, $limit, $page)
    {
        $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        $this->db->where('translations.type', 'article');
        $this->db->where('translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('category', $id);
        $result = $this->db->get('articles', $limit, $page);
        return $result->result_array();
    }

    public function getArticlesByCategoryCount($id)
    {
        $this->db->where('category', $id);
        $this->db->where('visibility', 1);
        return $this->db->count_all_results('articles');
    }

    public function getArticlesBySearch($search, $limit, $page)
    {
        $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        $this->db->where('translations.type', 'article');
        $this->db->where('translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $search = $this->db->escape_like_str($search);
        $this->db->where("(translations.title LIKE '%$search%' OR translations.description LIKE '%$search%')");
        $result = $this->db->get('articles', $limit, $page);
        return $result->result_array();
    }

    public function getArticlesBySearchCount($search)
    {
        $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        $this->db->where('translations.type', 'article');
        $this->db->where('translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $search = $this->db->escape_like_str($search);
        $this->db->where("(translations.title LIKE '%$search%' OR translations.description LIKE '%$search%')");
        return $this->db->count_all_results('articles');
    }

    public function getNoNavCategories()
    {
        $this->db->select('categories.sub_for, categories.id, categories.name as url, translations.name, IF(categories.sub_for = 0, 1, 0) as master');
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $this->db->where('nav !=', 1);
        $this->db->where('type', 'categorie');
        $this->db->join('categories', 'categories.id = translations.for_id', 'INNER');
        $query = $this->db->get('translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr[] = $row;
            }
        }
        return $arr;
    }

    public function addStupid()
    {
        $this->db->query('INSERT INTO stupids (num) VALUES (1)');
    }

    public function updateCategoryViews($url)
    {
        $this->db->query("UPDATE categories SET views = views + 1 WHERE name LIKE '$url'");
    }

    public function getMostReadCategories()
    {
        $this->db->select('categories.name as url, translations.name');
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $this->db->where('type', 'categorie');
        $this->db->join('categories', 'categories.id = translations.for_id', 'INNER');
        $this->db->limit(10);
        $this->db->order_by('views', 'desc');
        $query = $this->db->get('translations');
        return $query->result_array();
    }

    public function getTopArticleNews()
    {
        $this->db->join('translations', 'translations.for_id = articles.id', 'left');
        $this->db->where('translations.type', 'article');
        $this->db->where('translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('topNews', 1);
        $this->db->limit(1);
        $result = $this->db->get('articles');
        return $result->row_array();
    }

}

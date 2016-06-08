<?php

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function loginCheck($values) {
        $arr = array(
            'username' => $values['username'],
            'password' => md5($values['password']),
        );
        $this->db->where($arr);
        $result = $this->db->get('users');
        $res_arr = $result->row_array();
        return $res_arr;
    }

    public function articlesCount($search = null, $category = null, $lang = null) {
        if ($search !== null) {
            $search = $this->db->escape_like_str($search);
            $this->db->where("(title LIKE '%$search%' OR description LIKE '%$search%')");
        }
        if ($category !== null) {
            $this->db->where('category', $category);
        }
        if ($lang != null) {
            $this->db->where('language', $lang);
        }
        return $this->db->count_all_results('articles');
    }

    public function getLanguages() {
        $query = $this->db->query('SELECT * FROM languages');
        return $query;
    }

    public function setLanguage($post) {
        $result = $this->db->insert('languages', $post);
        return $result;
    }

    public function deleteLanguage($id) {
        $this->db->where('id', $id);
        $result = $this->db->delete('languages');
        return $result;
    }

    public function setArticle($post, $id = 0) {
        $post['title'] = str_replace('"', "'", $post['title']);
        if ($id > 0) {
            $post['time_update'] = time();
            $result = $this->db->where('id', $id)
                    ->update('articles', $post);
        } else {
            $post['time'] = time();
            $result = $this->db->insert('articles', $post);
            $last_id = $this->db->insert_id();

            $arr = array();
            $arr['url'] = str_replace(' ', '_', except_letters($post['title'])) . '_' . $last_id;
            $this->db->where('id', $last_id);
            $this->db->update('articles', $arr);
        }
        return $result;
    }

    public function historyCount() {
        return $this->db->count_all_results('history');
    }

    public function setHistory($activity, $user) {
        $this->db->insert('history', array('activity' => $activity, 'username' => $user, 'time' => time()));
    }

    public function getHistory($limit, $page) {
        $this->db->order_by('id', 'desc');
        $query = $this->db->select('*')->get('history', $limit, $page);
        return $query;
    }

    public function getArticles($limit, $page, $search = null, $category = null, $orderby = null, $lang = null) {
        if ($search !== null) {
            $search = $this->db->escape_like_str($search);
            $this->db->where("(title LIKE '%$search%' OR description LIKE '%$search%')");
        }
        if ($category !== null) {
            $this->db->where('category', $category);
        }
        if ($orderby !== null) {
            $this->db->order_by('id', $orderby);
        } else {
            $this->db->order_by('id', 'desc');
        }
        if ($lang != null) {
            $this->db->where('language', $lang);
        }
        $query = $this->db->select('*')->get('articles', $limit, $page);
        return $query;
    }

    public function getCategories($lang = null) {
        if ($lang != null) {
            $where = " AND language = '$lang'";
        }
        $query = $this->db->query('SELECT categories.*, (SELECT COUNT(id) FROM articles WHERE articles.category = name) as num FROM `categories` ORDER BY `id` DESC ');
        return $query;
    }

    public function getOneArticle($id) {
        $query = $this->db->where('id', $id)
                ->get('articles');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function setCategorie($post) {
        $id = $post['id'];
        unset($post['id']);
        if ($id == 0) {
            $result = $this->db->insert('categories', $post);
        } else {
            if (isset($post['rename_all'])) {
                $this->db->where('category', $post['rename_all']);
                unset($post['rename_all']);
                $this->db->update('articles', array('category' => $post['name']));
            }
            $this->db->where('id', $id);
            $result = $this->db->update('categories', $post);
        }
        return $result;
    }

    public function deleteCategorie($id) {
        $this->db->where('id', $id);
        $result = $this->db->delete('categories');
        return $result;
    }

    public function deleteArticle($id) {
        $this->db->where('id', $id);
        $result = $this->db->delete('articles');
        return $result;
    }

    public function articleStatusChagne($id, $to_status) {
        $this->db->where('id', $id);
        $result = $this->db->update('articles', array('visibility' => $to_status));
        return $result;
    }

    public function changePass($new_pass, $username) {
        $this->db->where('username', $username);
        $result = $this->db->update('users', array('password' => md5($new_pass)));
        return $result;
    }

}

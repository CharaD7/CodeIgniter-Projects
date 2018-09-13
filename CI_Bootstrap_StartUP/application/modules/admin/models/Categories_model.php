<?php

class Categories_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function setCategory($post)
    {
        $this->db->trans_begin();
        $i = 0;
        foreach ($post['translations'] as $translation) {
            if ($translation == MY_DEFAULT_LANGUAGE_ABBR) {
                $myTranslationNum = $i;
            }
            $i++;
        }
        if (!$this->db->insert('categories', array(
                    'parent' => $post['parent'],
                    'position' => $post['position'],
                    'url' => except_letters($post['title'][$myTranslationNum])
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
        $id = $this->db->insert_id();
        $i = 0;
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $arr['abbr'] = $abbr;
            $arr['name'] = $post['title'][$i];
            $arr['for_id'] = $id;
            if (!$this->db->insert('categories_translations', $arr)) {
                log_message('error', print_r($this->db->error(), true));
            }
            $i++;
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    public function editCategory($post)
    {
        $this->db->trans_begin();

        $this->db->where('id', $post['edit']);
        if (!$this->db->update('categories', array(
                    'parent' => $post['parent'],
                    'position' => $post['position']
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
        $i = 0;
        foreach ($post['translations'] as $abbr) {
            $this->db->where('for_id', $post['edit']);
            $this->db->where('abbr', $abbr);
            if (!$this->db->update('categories_translations', ['name' => $post['title'][$i]])) {
                log_message('error', print_r($this->db->error(), true));
            }
            $i++;
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    public function getCategory($id)
    {
        $arr = [];
        $this->db->where('id', $id);
        $this->db->where('deleted', 0);
        $result = $this->db->get('categories');
        $arr = $result->row_array();
        $this->db->where('for_id', $id);
        $result = $this->db->get('categories_translations');
        $arrT = [];
        foreach ($result->result_array() as $val) {
            $arrT[$val['abbr']] = $val;
        }
        $arr['translations'] = $arrT;
        return $arr;
    }

    public function getAllCategories($id = 0) // all instead id..
    {
        if ($id > 0) {
            $this->db->where('categories.id !=', $id);
        }
        $this->db->select('categories.id, name, parent');
        $this->db->join('categories_translations', 'categories.id = categories_translations.for_id');
        $this->db->where('deleted', 0);
        $this->db->where('abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $q = $this->db->get('categories');
        return $q->result_array();
    }

    public function getCategories($parent)
    {
        if ($parent != null) {
            $parent_q = '`parent` = ' . $this->db->escape((int) $parent);
        } else {
            $parent_q = '`parent` = 0';
        }
        $q = $this->db->query("SELECT `categories`.`id` as category_id, `name`, `position`, (SELECT count(id) FROM `categories` WHERE `parent` = category_id) as have_parents FROM `categories` JOIN `categories_translations` ON `categories`.`id` = `categories_translations`.`for_id` WHERE " . $parent_q . " AND `deleted` = 0 AND `abbr` = 'bg'");
        return $q->result_array();
    }

    public function getParents($for)
    {
        $q = $this->db->query("SELECT T2.id, categories_translations.name FROM ( SELECT @r AS _id, (SELECT @r := parent FROM categories WHERE id = _id) AS parent, @l := @l + 1 AS lvl FROM (SELECT @r := " . $this->db->escape($for) . ", @l := 0) vars, categories h WHERE @r <> 0) T1 JOIN categories T2 ON T1._id = T2.id JOIN categories_translations ON categories_translations.for_id = T1._id ORDER BY T1.lvl DESC ");
        return $q->result_array();
    }

    public function deleteCategorie($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->update('categories', ['deleted' => 1]);
    }

    public function freeUrlCheck($title)
    {
        $url = except_letters($title);
        $this->db->where('url', $url);
        return $this->db->count_all_results('categories');
    }

}

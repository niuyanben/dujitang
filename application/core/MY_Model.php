<?php

class MY_Model extends CI_Model {

    protected $table = '';

    public function __construct() {
        parent::__construct();
    }

    public function getById($id, $filed = null) {
        if ($filed) {
            $this->db->select($filed);
        }
        return  $this->db->where('id', $id)->get($this->table)->row();
    }

    public function updateById($data, $id) {
        if(empty($id)){
            return 0;
        }
        $this->db->where ('id', $id);
        foreach ($data as $key => $val){
            if(is_array($val)){
                $this->db->set($key, $val[0], isset($val[1]) ? $val[1] : true);
            }else{
                $this->db->set($key, $val);
            }
        }
        return $this->db->update ( $this->table);
    }

    public function select_one($filed = NULL, $where = NULL) {
        if ($filed) {
            $this->db->select($filed);
        }
        if ($where) {
            $this->db->where($where);
        }
        return $this->db->get($this->table)->row();
    }

    public function select($filed = NULL, $where = NULL, $order = NULL, $limit = NULL, $offset = NULL) {
        if ($filed) {
            $this->db->select($filed);
        }
        if ($where) {
            $this->db->where($where);
        }
        if ($order) {
            $this->db->order_by($order);
        }
        return $this->db->get($this->table, $limit, $offset)->result();
    }

    public function group_by($filed = NULL, $where = NULL, $order = NULL, $group = NULL, $limit = null, $offset = NULL) {
        if ($filed) {
            $this->db->select($filed);
        }
        if ($where) {
            $this->db->where($where);
        }
        if ($order) {
            $this->db->order_by($order);
        }
        if ($group) {
            $this->db->group_by($group);
        }
        return $this->db->get($this->table, $limit, $offset)->result();
    }

    public function count($where = array()) {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function update($data, $where) {
        $this->db->where($where);
        return $this->db->update($this->table, $data);
    }

    public function update_batch($set, $value) {
        return $this->db->update_batch($this->table, $set, $value);
    }

    function update_escape($data = null, $where = null) {
        if (!empty($data)) {
            foreach ($data as $r) {
                count($r) == 3 ? $this->db->set($r[0], $r[1], $r[2]) : $this->db->set($r[0], $r[1]);
            }
        }
        if ($where) {
            $this->db->where($where);
        }
        $this->db->update($this->table);
    }


    public function insert($data) {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function insert_by_table($table, $data) {
        if ($this->db->insert($table, $data)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function delete($where, $orderby = null, $limit = null) {
        if (!$where) {
            return null;
        }
        $this->db->where($where);
        if ($orderby) {
            $this->db->order_by($orderby);
        }
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->delete($this->table);
    }

    public function deleteById($id) {
        if(empty($id)){
            return 0;
        }
        $this->db->where ('id', $id);
        return $this->db->delete ( $this->table);
    }

}
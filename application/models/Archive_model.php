<?php

class Archive_model extends MY_Model
{
    protected $table = 'archive';

    function __construct()
    {
        parent::__construct();
    }

    public function random($num = 20)
    {
    	return $this->archive_model->select(null, null, null, $num);
    }

    public function latest($page = 1, $where = [], $limit = 10)
    {
    	$offset = ($page - 1) * $limit;
    	return $this->archive_model->select(null, $where, 'createTime desc', $limit, $offset);
    }

    public function like($id)
    {
        $this->db->where('id',$id);
        $this->db->set('likes','likes+1', FALSE);
        return $this->db->update($this->table);
    }

}
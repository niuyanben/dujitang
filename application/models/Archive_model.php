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

    public function latest($page = 1, $limit = 10)
    {
    	$offset = ($page - 1) * $limit;
    	return $this->archive_model->select(null, null, 'createTime desc', $limit, $offset);
    }

}
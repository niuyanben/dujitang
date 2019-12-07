<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cli extends Base_Controller {


	function __construct() {
		parent::__construct();
        if(!is_cli()) {
			exit('只能在终端运行');
		}
    }
	
	public function redis() {

		$this->load->model('archive_model');
		$archiveCount = $this->archive_model->count();

		$limit = 20;
		$pages = ceil($archiveCount/$limit);

		echo "共 {$archiveCount} 条记录，每页 {$limit} 条，分 {$pages} 页..." . PHP_EOL;
		$this->load->driver('cache', ['adapter' => 'redis']);
		$this->cache->redis->delete('archives'); // 
		
		for ($i=0; $i < $pages; $i++) { 
			$offset = $i * $limit;
			echo "  开始导第 {$i} 页， 从 {$offset} 开始" . PHP_EOL;
			$archiveList = $this->archive_model->select(null, null, 'id asc', $limit, $offset);
			foreach($archiveList as $archive){
				$this->cache->redis->sadd('archives', json_encode($archive, JSON_UNESCAPED_UNICODE)); // 
			}
		}
		echo 'DONE' . PHP_EOL;
	}


}

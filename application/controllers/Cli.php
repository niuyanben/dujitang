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
		$archiveList = $this->archive_model->random(5);
		// 
		$this->load->driver('cache', ['adapter' => 'redis']);


		foreach($archiveList as $archive){
			$this->cache->redis->lpush('archives', json_encode($archive, JSON_UNESCAPED_UNICODE));
		}
		
		echo 'DONE' . PHP_EOL;
	}


}

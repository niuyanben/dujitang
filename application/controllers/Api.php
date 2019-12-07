<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Base_Controller {


	public function random($num = 20) {
		$this->load->model('archive_model');
		$this->load->driver('cache', ['adapter' => 'redis']);
		$data['archiveList'] = [];
		$archiveList = $this->cache->redis->srandmember('archives', $num); // 
		foreach($archiveList as $archive) {
			$data['archiveList'][] = json_decode($archive);
		}
		$this->success($data);
	}


}

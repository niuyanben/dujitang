<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Base_Controller {


	public function random($num = 1) {
		$this->load->model('archive_model');

		$data['archiveList'] = $this->archive_model->random($num);

		$this->success($data);
	}



}

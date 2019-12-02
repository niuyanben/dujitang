<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cli extends Base_Controller {


	function __construct() {
        if(!is_cli()) {
			exit('只能在终端运行');
		}
    }
	
	public function redis() {
		$this->load->model('archive_model');

		// 


	}


}

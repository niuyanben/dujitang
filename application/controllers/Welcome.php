<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index() {
		$this->load->view('welcome_message');
	}

	public function publish() {

		$this->load->library('form_validation');
		$this->form_validation->set_rules('content', 'Username', 'required|max_length[255]');
		$this->form_validation->set_rules('author', 'Password', 'required|max_length[64]');

		if ($this->form_validation->run() == FALSE) {
			
			
		} else {
			echo 'true';
		}
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends App_Controller {


	public function index() {
		$this->load->view('welcome_message');
	}

	public function publish() {

		$this->load->library('form_validation');
		$this->form_validation->set_rules('content', 'Username', 'required|max_length[255]');
		$this->form_validation->set_rules('author', 'Password', 'max_length[64]');


		$data = [
			'content' => $this->input->post('content'),
			'author' => $this->input->post('author'),
			'createTime' => time()
		];


		if ($this->form_validation->run() == FALSE) {
			$this->error('参数错误');
		} else {
			 $this->load->model('archive_model');
			 $id = $this->archive_model->insert($data);
			 $id > 0 ? $this->success() : $this->error();
		}
	}
}

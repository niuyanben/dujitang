<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends App_Controller {


	public function index() {
		$this->load->view('welcome_message');
	}

	public function login()
	{
		$token = $this->input->get('token');
		if($token == '1') {
			$this->load->library('session');
			$this->session->set_userdata('isLogin', TRUE);
			redirect('dashboard');
		}
	}

	public function publish() {

		$this->load->library('form_validation');
		$this->form_validation->set_rules('content', 'Username', 'required|max_length[255]');
		$this->form_validation->set_rules('author', 'Password', 'max_length[64]');


		$data = [
			'content' => $this->input->post('content'),
			'author' => $this->input->post('author'),
			'attachJson' => json_encode(['ip' => $this->input->ip_address()], JSON_UNESCAPED_UNICODE),
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


	public function like()
	{
		// ip 限制 on redis

		$id = $this->input->post('id');
		$this->load->model('archive_model');
		$archive = $this->archive_model->getById($id);
		if(empty($archive)) {
			$this->error('404');
		}
		$effected = $this->archive_model->like($id);
		$effected > 0 ? $this->success() : $this->error();
	}

}

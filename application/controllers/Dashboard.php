<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends App_Controller {

	const LIMIT = 10;

	protected $isLogin = FALSE;

	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->isLogin = $this->session->userdata('isLogin');
		if(!$this->isLogin) {
			redirect();
		}
    }

	public function index() {
		$this->load->model('archive_model');

		$p = $this->input->get ( 'p', true ) ?: 1;
		

		$data['archiveList'] = $this->archive_model->latest($p, self::LIMIT);

		//
		// $this->libraries->load('pagination');
		$this->config->load ( 'pagination' );
		$config ['total_rows'] = $this->archive_model->count();
		$config ['first_url'] = 'dashboard';
		$config ['per_page'] = self::LIMIT;
		$this->pagination->initialize ( $config );
		$pager = $this->pagination->create_links ();


		$data['pager'] = $pager;

		$this->load->view('dashboard', $data);
	}

	public function delete() {
		$id = $this->input->get('id');
		if(empty($id)) {
			$this->error();
		}
		$this->load->model('archive_model');
		$effected = $this->archive_model->deleteById($id);
		$effected >0 ? $this->success() : $this->error();
	}
}

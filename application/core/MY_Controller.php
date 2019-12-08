<?php

class Base_Controller extends CI_Controller {

    protected $userinfo;


    
    public function success($data = [], $msg = 'success')
    {
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
    	echo json_encode([
    		'code' => 200,
    		'msg' => $msg,
    		'data' => $data
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }

    public function error($msg = 'error', $code = -1)
    {
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
    	echo json_encode([
    		'code' => $code,
    		'msg' => $msg
        ]);
        exit();
    }

}

class App_Controller extends Base_Controller {

    const SUCCESS = 1;
    const ERROR = 0;
    const SYSTEM_UID = 1;

    function __construct() {
        parent::__construct();
    }
}

class Admin_Controller extends Base_Controller
{

    protected $limit = 10;

    function __construct()
    {
        parent::__construct();

    }
}
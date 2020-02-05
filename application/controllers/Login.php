<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
	}
	
	public function index() {
		//validasi
		$this->form_validation->set_rules('username','Username','required',
			array(	'required' => '%s harus diisi'));
		$this->form_validation->set_rules('password','Password','required',
			array(	'required' => '%s harus diisi'));
			
		if($this->form_validation->run()) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			//proses ke simple login
			$this->simple_login->doLogin($username,$password);
		}

		$this->load->view('login/index');
	}

	public function logout(){
		//ambil function logout dari library simple login
		$this->simple_login->logout();
	}
}

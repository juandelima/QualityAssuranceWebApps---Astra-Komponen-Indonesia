<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller { 

	function __construct() {
		parent::__construct();
		$this->load->model('customer_model');
		$this->load->model('listpart_model');
	}

	public function index() {
		$listpart_model = $this->listpart_model->list_part();
		$data = array(
			'listpart' => $listpart_model
		);
		$this->load->view('master_data/customer/index', $data);
	}
	
	public function testting() {
		$this->customer_model->testing();
	}

	public function data_customer() {
		$data = $this->customer_model->customer_list();
		echo json_encode($data);
	}

	public function save_customer($nama_customer) {
		$data = $this->customer_model->save_customer($nama_customer);
		echo json_encode($data);
	}

	public function update_customer() {
		$data = $this->customer_model->update_customer();
		echo json_encode($data);
	}

	public function delete_customer() {
		$data = $this->customer_model->delete_customer();
		echo json_encode($data);
	}

}

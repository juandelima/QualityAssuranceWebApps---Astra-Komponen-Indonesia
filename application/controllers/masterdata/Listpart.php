<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Listpart extends CI_Controller { 

	function __construct() {
		parent::__construct();
		$this->load->helper('text');
		$this->load->model('customer_model');
		$this->load->model('listpart_model');
		$this->load->database();
		$this->load->helper('url');
	}

	// public function index() {
	// 	$listpart_model = $this->listpart_model->list_part();
	// 	$data = array(
	// 		'listpart' => $listpart_model
	// 	);
	// 	$this->load->view('master_data/list_part/index', $data);
	// }

	public function index() {
		
		$slug = $this->uri->segment(2);
		$get_data_part = $this->listpart_model->get_data_part();
		$data = array(
			'listpart' => $get_data_part,
			'slug' => $slug
		);
		$this->load->view('master_data/list_part/new_part', $data);
	}

	public function add_new_data_part() {
		$valid = $this->form_validation;
		$valid->set_rules('no_sap', 'NO SAP', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('s_grade', 'SAFETY GRADE', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('nama_part', 'NAMA PART', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('type_part', 'TYPE PART', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('proses', 'PROSES', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('customer', 'Customer', 'required', 
		array('required' => '%s harus di isi'));

		if($valid->run()) {
			$created_at = date('Y-m-d');
			$updated_at = date('Y-m-d');
			$data = array(
				'no_sap' => $this->input->post('no_sap'),
				'safety_grade' => $this->input->post('s_grade'),
				'nama_part' => $this->input->post('nama_part'),
				'type' => $this->input->post('type_part'),
				'proses' => $this->input->post('proses'),
				'customer' => $this->input->post('customer'),
			);
			$exist_customer = $this->customer_model->check_exist_customer($data['customer']);

			if($exist_customer === FALSE) {
				$this->customer_model->save_customer($data['customer']);
			}

			$get_data_customer = $this->customer_model->customer_list();
			$id_customer = null;
			foreach($get_data_customer as $row) {
				if($data['customer'] === $row->nama_customer) {
					$id_customer = $row->id_customer;
					$data['customer'] = $id_customer;
					break;
				}
			}

			$data2 = array(
				'no_sap' => $data['no_sap'],
				'safety_grade' => $data['safety_grade'],
				'nama_part' => $data['nama_part'],
				'type' => $data['type'],
				'proses' => $data['proses'],
				'id_customer' => $id_customer,
				'created_at' => $created_at,
				'updated_at' => $updated_at
			);

			$this->listpart_model->save_new_part($data);
			$this->listpart_model->save_part($data2);
			$this->session->set_flashdata('sukses', 'DATA BARU PART BERHASIL TERSIMPAN');
			redirect(base_url('masterdata/listpart'), 'refresh');
		}
	}

	function get_autocomplete(){
		if (isset($_GET['term'])) {
		  	$result = $this->listpart_model->search_no_sap($_GET['term']);
		   	if (count($result) > 0) {
		    	foreach ($result as $row)
					$arr_result[] = $row->NO_SAP; 
					echo json_encode($arr_result); 
		   	}
		}
	}

	public function get_customer() {
		if(isset($_GET['term'])) {
			$search_customer = $this->customer_model->search_customer($_GET['term']);
			if(count($search_customer) > 0) {
				foreach ($search_customer as $row)
					$arr_result[] = $row->nama_customer;
					echo json_encode($arr_result); 
			}
		}
	}

	public function get_autofill() {
		$no_sap = $_GET['no_sap'];
		$search = $this->listpart_model->search_dataPart_by_noSap($no_sap);
		echo json_encode($search);
	}
	

	public function create_new_part() {
		$slug = $this->uri->segment(3);
		$data = array(
			'slug' => $slug
		);
		$this->load->view('master_data/list_part/create_new_part', $data);
	}

	public function create() {
		$session_role = $this->session->userdata['role'];
		if($session_role != 'Super Admin' and $session_role != 'Admin') {
			$this->session->set_flashdata('error', "CANNOT ACCESS THIS PAGE!!!");
			redirect(base_url(), 'refresh');
		}
		$customer_model = $this->customer_model->customer_list();
		$data = array(
			'customer' => $customer_model
		);
		$this->load->view('master_data/list_part/create', $data);
	}

	public function save() {
		$valid = $this->form_validation;
		$valid->set_rules('no_sap', 'NO SAP', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('s_grade', 'SAFETY GRADE', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('nama_part', 'NAMA PART', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('type_part', 'TYPE PART', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('proses', 'PROSES', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('id_customer', 'Customer', 'required', 
		array('required' => '%s harus di isi'));

		if($valid->run()) {
			date_default_timezone_set("Asia/Jakarta");
			$created_at = date('Y-m-d');
			$updated_at = date('Y-m-d');
			$post_id_customer = $this->input->post('id_customer');

			$exist_customer = $this->customer_model->check_exist_customer($post_id_customer);

			if($exist_customer === FALSE) {
				$this->customer_model->save_customer($post_id_customer);
			}

			$get_data_customer = $this->customer_model->customer_list();
			$id_customer = null;
			foreach($get_data_customer as $row) {
				if($post_id_customer === $row->nama_customer) {
					$id_customer = $row->id_customer;
					break;
				}
			}
			$data = array(
				'no_sap' => $this->input->post('no_sap'),
				'safety_grade' => $this->input->post('s_grade'),
				'nama_part' => $this->input->post('nama_part'),
				'type' => $this->input->post('type_part'),
				'proses' => $this->input->post('proses'),
				'id_customer' => $id_customer,
				'created_at' => $created_at,
				'updated_at' => $updated_at
			);
			$this->listpart_model->save_part($data);
			$this->session->set_flashdata('sukses', 'DATA PART BERHASIL TERSIMPAN');
			redirect(base_url('masterdata/listpart'), 'refresh');
		}
	}

	public function edit($id_part) {
		$session_role = $this->session->userdata['role'];
		if($session_role != 'Super Admin' and $session_role != 'Admin') {
			$this->session->set_flashdata('error', "CANNOT ACCESS THIS PAGE!!!");
			redirect(base_url(), 'refresh');
		}
		$listpart = $this->listpart_model->edit_part($id_part);
		$customer_model = $this->customer_model->customer_list();
		$valid = $this->form_validation;
		$valid->set_rules('no_sap', 'NO SAP', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('s_grade', 'SAFETY GRADE', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('nama_part', 'NAMA PART', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('type_part', 'TYPE PART', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('proses', 'PROSES', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('id_customer', 'Customer', 'required', 
		array('required' => '%s harus di isi'));
		if($valid->run()) {
			date_default_timezone_set("Asia/Jakarta");
			$updated_at = date('Y-m-d');
			$data = array(
				'id_part' => $id_part,
				'no_sap' => $this->input->post('no_sap'),
				'safety_grade' => $this->input->post('s_grade'),
				'nama_part' => $this->input->post('nama_part'),
				'type' => $this->input->post('type_part'),
				'proses' => $this->input->post('proses'),
				'customer' => $this->input->post('customer'),
				'updated_at' => $updated_at
			);

			$this->listpart_model->update_part($data);
			$this->session->set_flashdata('sukses', 'DATA PART BERHASIL DIUBAH');
			redirect(base_url('masterdata/listpart'), 'refresh');
		}

		$get_data = array(
			'part' => $listpart,
			'customer' => $customer_model,
		);		

		$this->load->view('master_data/list_part/edit', $get_data);
	}

	public function delete($id_part) {
		$selectpart =  $this->listpart_model->edit_part($id_part);
		$arraypart = array(
			'id_part' => $selectpart->id_part,
			'nama_part' => $selectpart->nama_part
		);
		$this->listpart_model->delete_part($arraypart['id_part']);
		$this->session->set_flashdata('hapus', 'PART '.$arraypart['nama_part'].' TELAH DIHAPUS!');
		redirect(base_url('masterdata/listpart'), 'refresh');
	}

}

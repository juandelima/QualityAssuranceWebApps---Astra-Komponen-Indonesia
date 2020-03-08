<?php

use SebastianBergmann\Environment\Console;

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller { 

	function __construct() {
		parent::__construct();
		$this->load->model('customer_model');
		$this->load->model('listpart_model');
	}

	public function index() {
		$session_role = $this->session->userdata['role'];
		if($session_role != 'Super Admin' and $session_role != 'Admin') {
			$this->session->set_flashdata('error', "CANNOT ACCESS THIS PAGE!!!");
			redirect(base_url(), 'refresh');
		}
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

	public function getCustomer($id_customer) {
		$getPart = $this->listpart_model->getDataPartByCustomer($id_customer);
		echo json_encode($getPart);
		// $no = 1;
		// foreach($getPart as $data) {
		// 	echo "<tr>";
		// 	echo "<td>$no</td>";
		// 	echo "<td>$data->nama_part</td>";
		// 	echo "<td>$data->type</td>";
		// 	echo "<td>$data->no_sap</td>";
		// 	echo "<td>$data->safety_grade</td>";
		// 	echo "<td>$data->proses</td>";
		// 	echo "<td>$data->nama_customer</td>";
		// 	echo "<td>";
		// 	echo "<center>";
		// 	echo "<button type='button' class='btn btn-green btn-icon btn_add'  data-id='$data->id_part' data-part='$data->nama_part' data-type='$data->type' data-no-part='$data->no_sap' data-safety='$data->safety_grade' data-proses='$data->proses' data-customer='$data->nama_customer' data-dismiss='modal'>";
		// 	echo "PILIH";
		// 	echo "<i class='entypo-check'></i>";
		// 	echo "</button>";
		// 	echo "</center>";
		// 	echo "</td>";
		// 	echo "</tr>";
		// 	$no++;
		// }
		// print_r($getPart);
	}

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Delivery extends CI_Controller {

    function __construct() {
		parent::__construct();
        $this->load->model('delivery_model');
        $this->load->model('aktivitas_model');
		$this->load->helper('date');
		$this->load->helper('url');
    }
    
    public function get_data() {
        $data = $this->delivery_model->listing_deliv();
        $count_data = count($data);

        $data_ = array(
            'data' => $data,
            'count_data' => $count_data
        );
        echo json_encode($data_);
    }

    public function update_data() {
        if($this->session->userdata['role'] == 'User') {
			$this->session->set_flashdata('error',"You can't do this surgery");
			redirect(base_url('claim/customerclaim'),'refresh');
		}
        $id_delivery = $this->input->post('id_delivery');
        $qty = $this->input->post('qty');
        $tgl = $this->input->post('tgl');
        $data = array(
           'id_delivery' => $id_delivery,
            'qty' => $qty
        );
        $id_user = $this->session->userdata('id_users');
		$data_aktivitas = array(
			"id_user" => $id_user,
			"aktivitas" => "telah mengubah delivery tanggal $tgl sebanyak $qty quantity",
			"tgl" => date("Y-m-d"),
			"jam" => date("H:i:s")
		);
		$this->aktivitas_model->save_aktivitas($data_aktivitas);
        $result = $this->delivery_model->update_delivery($data);
        echo json_encode($result);
    }

    public function delete_data() {
        if($this->session->userdata['role'] == 'User') {
			$this->session->set_flashdata('error',"You can't do this surgery");
			redirect(base_url('claim/customerclaim'),'refresh');
		}
        $id_delivery = $this->input->post('id_delivery');
        $tgl = $this->input->post('tgl');
        $id_user = $this->session->userdata('id_users');
		$data_aktivitas = array(
			"id_user" => $id_user,
			"aktivitas" => "telah menghapus delivery tanggal $tgl",
			"tgl" => date("Y-m-d"),
			"jam" => date("H:i:s")
		);
		$this->aktivitas_model->save_aktivitas($data_aktivitas);
        $result = $this->delivery_model->delete_delivery($id_delivery);
        echo json_encode($result);
    }
}
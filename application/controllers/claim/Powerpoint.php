<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Powerpoint extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('customer_model');
		$this->load->model('customerclaim_model');
		$this->load->model('listpart_model');
		$this->load->library('upload');
	}


	public function upload_ppt($id_customer_claim) {
		$select_claim = $this->customerclaim_model->select_claim($id_customer_claim);
		$get_tgl_input = strtotime($select_claim->tgl_input);
		$due_date = date("Y-m-d", strtotime("+3 day", $get_tgl_input));
		$dateNow = date("Y-m-d");
		if(!empty($_FILES['ppt_file']['name'])) {
			$filesCount = count($_FILES['ppt_file']['name']);
			for($i = 0; $i < $filesCount; $i++) {
				$_FILES['file']['name']     = "PICA ".$select_claim->nama_part." ".$_FILES['ppt_file']['name'][$i];
                $_FILES['file']['type']     = $_FILES['ppt_file']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['ppt_file']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['ppt_file']['error'][$i];
				$_FILES['file']['size']     = $_FILES['ppt_file']['size'][$i];
				
				 // File upload configuration
				 $uploadPath = './assets/claim_customer/pica/';
				 $config['upload_path'] = $uploadPath;
				 $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|ppt|pptx|xls|xlsx|doc|docx';

				 // Load and initialize upload library
				 $this->load->library('upload', $config);
				 $this->upload->initialize($config);

				 // Upload file to server
				 if($this->upload->do_upload('file')){
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
					$uploadData[$i]['uploaded_on'] = date("Y-m-d");
					$data = array(
						'id_pica' => $id_customer_claim,
						'tgl_upload' => $uploadData[$i]['uploaded_on'],
						'nama_file' => $uploadData[$i]['file_name']
					);
					$this->customerclaim_model->save_pica_file($data);
                }
			}
			$this->customerclaim_model->update_id_pica($id_customer_claim);
			$select_claim_last_update = $this->customerclaim_model->select_claim($id_customer_claim);
			$output = array(
				'select_claim' => $select_claim_last_update,
				'due_date' => $due_date,
				'dateNow' => $dateNow
			);
			echo json_encode($output);
		}
	}


	public function upload_ofp($id_customer_claim) {
		$select_claim = $this->customerclaim_model->select_claim($id_customer_claim);
		if(!empty($_FILES['nama_file_ofp']['name'])) {
			$filesCount = count($_FILES['nama_file_ofp']['name']);
			for($i = 0; $i < $filesCount; $i++) {
				$_FILES['file']['name']     = "OFP ".$select_claim->nama_part." ".$_FILES['nama_file_ofp']['name'][$i];
                $_FILES['file']['type']     = $_FILES['nama_file_ofp']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['nama_file_ofp']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['nama_file_ofp']['error'][$i];
				$_FILES['file']['size']     = $_FILES['nama_file_ofp']['size'][$i];
				
				 // File upload configuration
				 $uploadPath = './assets/claim_customer/ofp/';
				 $config['upload_path'] = $uploadPath;
				 $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|ppt|pptx|xls|xlsx|doc|docx';

				 // Load and initialize upload library
				 $this->load->library('upload', $config);
				 $this->upload->initialize($config);

				 // Upload file to server
				 if($this->upload->do_upload('file')){
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
					$uploadData[$i]['uploaded_on'] = date("Y-m-d");
					$data = array(
						'id_ofp' => $id_customer_claim,
						'tgl_upload' => $uploadData[$i]['uploaded_on'],
						'nama_file' => $uploadData[$i]['file_name']
					);
					$this->customerclaim_model->save_ofp_file($data);
                }
			}
			$this->customerclaim_model->update_id_ofp($id_customer_claim);
			$select_claim_last_update = $this->customerclaim_model->select_claim($id_customer_claim);
			$output = array(
				'select_claim' => $select_claim_last_update,
			);
			echo json_encode($output);
		}

	}

	public function upload_pfmea($id_customer_claim) {
		$select_claim = $this->customerclaim_model->select_claim($id_customer_claim);
		if(!empty($_FILES['file_pfmea']['name'])) {
			$filesCount = count($_FILES['file_pfmea']['name']);
			for($i = 0; $i < $filesCount; $i++) {
				$_FILES['file']['name']     = "PFMEA ".$select_claim->nama_part." ".$_FILES['file_pfmea']['name'][$i];
                $_FILES['file']['type']     = $_FILES['file_pfmea']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['file_pfmea']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['file_pfmea']['error'][$i];
				$_FILES['file']['size']     = $_FILES['file_pfmea']['size'][$i];
				
				 // File upload configuration
				 $uploadPath = './assets/claim_customer/pfmea/';
				 $config['upload_path'] = $uploadPath;
				 $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|ppt|pptx|xls|xlsx|doc|docx';

				 // Load and initialize upload library
				 $this->load->library('upload', $config);
				 $this->upload->initialize($config);

				 // Upload file to server
				 if($this->upload->do_upload('file')){
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
					$uploadData[$i]['uploaded_on'] = date("Y-m-d");
					$data = array(
						'id_pfmea' => $id_customer_claim,
						'tgl_upload' => $uploadData[$i]['uploaded_on'],
						'nama_file' => $uploadData[$i]['file_name']
					);
					$this->customerclaim_model->save_pfmea_file($data);
                }
			}
			$this->customerclaim_model->update_id_pfmea($id_customer_claim);
			$select_claim_last_update = $this->customerclaim_model->select_claim($id_customer_claim);
			$output = array(
				'select_claim' => $select_claim_last_update,
			);
			echo json_encode($output);
		}
	}
}

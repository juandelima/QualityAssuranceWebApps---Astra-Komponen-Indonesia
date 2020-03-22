<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\Writer\PowerPoint2007;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Bullet;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Border;
use PhpOffice\PhpPresentation\Style\Fill;
use PhpOffice\PhpPresentation\Slide\Background\Color as BackgroundColor;

class Powerpoint extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('customer_model');
		$this->load->model('customerclaim_model');
		$this->load->model('listpart_model');
		$this->load->library('upload');
	}

	public function download($id_customer_claim) {
		$select_claim = $this->customerclaim_model->select_claim($id_customer_claim);
		$phpPresentation = new PhpPresentation();
		$oBkgColor = new BackgroundColor();
		$currentSlide = $phpPresentation->getActiveSlide();
		$oBkgColor->setColor(new Color('0f4c75'));
		$currentSlide->setBackground($oBkgColor);
		$shape = $currentSlide->createDrawingShape();
		$shape->setPath('C:\xampp\htdocs\eq-aski\application\controllers\claim\logo-aski.png')
			 ->setHeight(125)
			 ->setWidth(125)
			 ->setOffsetX(15)
			 ->setOffsetY(35);
		$shape->getShadow()->setVisible(true)
						  ->setDirection(25)
						  ->setDistance(5);
		$shape = $currentSlide->createRichTextShape()
			->setHeight(100)
			->setWidth(700)
			->setOffsetX(160)
			->setOffsetY(57);
		$shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$textRun = $shape->createTextRun($select_claim->NAMA_PART);
		$textRun->getFont()->setBold(true)
			->setSize(25);
		
		$shape = $currentSlide->createTableShape(6);
		$shape->setHeight(200)
			  ->setWidth(800)
			  ->setOffsetX(10)
			  ->setOffsetY(120);
 
		// add row
		$row = $shape->createRow();
		$row->getFill()->setFillType(Fill::FILL_SOLID)
					   ->setStartColor(new Color(Color::COLOR_BLACK))
					   ->setEndColor(new Color(Color::COLOR_BLACK));
		$oCell = $row->nextCell();
		$oCell->getBorders()->getBottom()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getLeft()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getRight()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getTop()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->setWidth(200);
		$oCell->createTextRun('Problem')->getFont()->setBold(true)->setSize(12)->setColor(new Color('FFFFFFFF'));
		$oCell->getActiveParagraph()->getAlignment()
			  ->setMarginBottom(10)
			  ->setMarginTop(25)
			  ->setMarginRight(30)
			  ->setMarginLeft(35);
		
		$oCell = $row->nextCell();
		$oCell->getBorders()->getBottom()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getLeft()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getRight()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getTop()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->createTextRun('Why 1')->getFont()->setBold(true)->setSize(12)->setColor(new Color('FFFFFFFF'));
		$oCell->getActiveParagraph()->getAlignment()
			  ->setMarginBottom(10)
			  ->setMarginTop(25)
			  ->setMarginRight(20)
			  ->setMarginLeft(23);
		
		$oCell = $row->nextCell();
		$oCell->getBorders()->getBottom()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getLeft()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getRight()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getTop()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->createTextRun('Why 2')->getFont()->setBold(true)->setSize(12)->setColor(new Color('FFFFFFFF'));
		$oCell->getActiveParagraph()->getAlignment()
			  ->setMarginBottom(10)
			  ->setMarginTop(25)
			  ->setMarginRight(20)
			  ->setMarginLeft(23);
		
		$oCell = $row->nextCell();
		$oCell->getBorders()->getBottom()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getLeft()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getRight()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getTop()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->createTextRun('Why 3')->getFont()->setBold(true)->setSize(12)->setColor(new Color('FFFFFFFF'));
		$oCell->getActiveParagraph()->getAlignment()
			  ->setMarginBottom(10)
			  ->setMarginTop(25)
			  ->setMarginRight(20)
			  ->setMarginLeft(23);
		
		$oCell = $row->nextCell();
		$oCell->getBorders()->getBottom()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getLeft()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getRight()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getTop()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->createTextRun('Why 4')->getFont()->setBold(true)->setSize(12)->setColor(new Color('FFFFFFFF'));
		$oCell->getActiveParagraph()->getAlignment()
			  ->setMarginBottom(10)
			  ->setMarginTop(25)
			  ->setMarginRight(20)
			  ->setMarginLeft(23);

		$oCell = $row->nextCell();
		$oCell->setWidth(210);
		$oCell->getBorders()->getBottom()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getLeft()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getRight()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->getBorders()->getTop()->setColor(new Color(Color::COLOR_WHITE));
		$oCell->createTextRun('Countermeasure')->getFont()->setBold(true)->setSize(12)->setColor(new Color('FFFFFFFF'));
		$oCell->getActiveParagraph()->getAlignment()
			  ->setMarginBottom(10)
			  ->setMarginTop(25)
			  ->setMarginRight(20)
			  ->setMarginLeft(23);
		
		$writer = new PowerPoint2007($phpPresentation);
		
		$filename = 'PART - '.$select_claim->nama_part;
		
		header('Content-Type: application/vnd.ms-powerpoint');
		header('Content-Disposition: attachment;filename="'. $filename .'.pptx"'); 
		header('Cache-Control: max-age=0');
        
		$writer->save("php://output");
	}

	public function upload_ppt($id_customer_claim) {
		$select_claim = $this->customerclaim_model->select_claim($id_customer_claim);
		$get_tgl_input = strtotime($select_claim->tgl_input);
		$due_date = date("Y-m-d", strtotime("+3 day", $get_tgl_input));
		$dateNow = date("Y-m-d");
		$config = array(
			'upload_path' => './assets/claim_customer/ppt/',
			'allowed_types' => 'gif|jpg|png|jpeg|pdf|ppt|pptx|xls|xlsx|doc|docx',
			'file_name'	=> 'Part '.$select_claim->nama_part,
			'overwrite' => true,
			'max_size ' => 1280000
		);
		$this->upload->initialize($config);

		if($this->upload->do_upload('ppt_file')) {
			$upload_file = array('upload_file' => $this->upload->data());
			$file_name = $upload_file['upload_file']['file_name'];
			$data = array(
				'id_customer_claim' => $id_customer_claim,
				'ppt_file' => $file_name
			);
			$this->customerclaim_model->upload_ppt($data);
			$select_claim_last = $this->customerclaim_model->select_claim($id_customer_claim);
			$output = array(
				'file_name' => $file_name,
				'select_claim' => $select_claim_last,
				'due_date' => $due_date,
				'dateNow' => $dateNow
			);
			echo json_encode($output);
		} 
	}


	public function upload_ofp($id_customer_claim) {
		$select_claim = $this->customerclaim_model->select_claim($id_customer_claim);
		$get_tgl_input = strtotime($select_claim->tgl_input);
		$due_date = date("Y-m-d", strtotime("+3 day", $get_tgl_input));
		$dateNow = date("Y-m-d");
		$config = array(
			'upload_path' => './assets/claim_customer/ofp/',
			'allowed_types' => 'gif|jpg|png|jpeg|pdf|ppt|pptx|xls|xlsx|doc|docx',
			'file_name'	=> 'OFP '.$select_claim->nama_part,
			'overwrite' => true,
			'max_size ' => 1280000
		);
		$this->upload->initialize($config);
		if($this->upload->do_upload('nama_file_ofp')) {
			$upload_file = array('upload_file' => $this->upload->data());
			$file_name = $upload_file['upload_file']['file_name'];
			$data = array(
				'id_customer_claim' => $id_customer_claim,
				'ofp' => $file_name
			);
			$this->customerclaim_model->upload_ofp($data);
			$select_claim_last = $this->customerclaim_model->select_claim($id_customer_claim);
			$output = array(
				'file_name' => $file_name,
				'select_claim' => $select_claim_last,
				'due_date' => $due_date,
				'dateNow' => $dateNow
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

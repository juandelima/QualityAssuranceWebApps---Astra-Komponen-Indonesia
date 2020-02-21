<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Customerclaim extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('customer_model');
		$this->load->model('customerclaim_model');
		$this->load->model('listpart_model');
		$this->load->model('delivery_model');
		$this->load->helper('date');
		$this->load->helper('url');
	}


	public function ahm() {
		$slug = $this->uri->segment(3);
		$get_customer = $this->customerclaim_model->get_customer();
		$get_customer_claim = $this->customerclaim_model->get_customer_claim();
		$get_customer_claim_distinct = $this->customerclaim_model->get_customer_claim_distinct();
		$get_customer_claim_sort_by_date = $this->customerclaim_model->get_customer_claim_sort_by_date();
		$count_customer_claim = count($get_customer_claim);
		if(!empty($get_customer_claim_sort_by_date)) {
			$getStart = $get_customer_claim_sort_by_date[0]->tgl_input;
			$getEnd = $get_customer_claim_sort_by_date[count($get_customer_claim_sort_by_date) - 1]->tgl_input;
			$start = date('Y-m-d', strtotime($getStart));
			$end = date('Y-m-d', strtotime($getEnd));
		} else {
			$start = null;
			$end = null;
		}
		
		
	
 		$data = array(
			'customer' => $get_customer,
			'customer_claim' => $get_customer_claim,
			'customer_claim_dist' => $get_customer_claim_distinct,
			'count_customer_claim' => $count_customer_claim,
			'start' => $start,
			'end' => $end,
			'slug' => $slug
		);
		$this->load->view('customer_claim/index', $data);
	} 
	
	public function ahm_delivery() {
		
		$tgl = $_POST['tgl_deliv'];
		$qty = $_POST['qty'];
		$strTgl_toTime = date('Y-m-d', strtotime($tgl));
		$result = $this->delivery_model->save_delivery($strTgl_toTime, $qty);
		echo json_encode($result);

	}

 	public function create_ahm() {
		$session_role = $this->session->userdata['role'];
		if($session_role != 'Super Admin' and $session_role != 'Admin') {
			$this->session->set_flashdata('error', "CANNOT ACCESS THIS PAGE!!!");
			redirect(base_url(), 'refresh');
		}
		$slug = $this->uri->segment(3);
		$get_field_visual = $this->customerclaim_model->list_field_visual();
		$get_field_non_visual = $this->customerclaim_model->list_field_non_visual();
		
		$merge_field = array_merge($get_field_visual, $get_field_non_visual);
		$merge_field_filter = [];
		$count_merge_field = count($merge_field);
		for($i = 0; $i < $count_merge_field; $i++) {
			if($merge_field[$i] == "id_customer_claim") {
				continue;
			}
			$merge_field_filter[] = $merge_field[$i];
		}
		// print_r($merge_field_filter);
 		$listpart_model = $this->listpart_model->get_data_part();
 		$data = array(
			'listpart' => $listpart_model,
			'non_visual_field' => $merge_field_filter,
			'slug' => $slug
		);
		$this->load->view('customer_claim/tambah', $data);
	}

	public function filter_chart() {
		
		$get_customer_claim = $this->customerclaim_model->get_customer_claim();
		$count_customer_claim = count($get_customer_claim);
		$get_field_visual = $this->customerclaim_model->list_field_visual();
		$get_field_non_visual = $this->customerclaim_model->list_field_non_visual();
		$key_visual = [];
		$key_non_visual = [];
		$value_visual = ['Kotor', 'Lecet', 'Tipis', 'Meler', 'Nyerep', 'O Peel', 'Buram', 'Over Cut',
					'Burry', 'Belang', 'Ngeflek', 'Minyak', 'Dustray', 'Cat Kelupas', 'Bintik Air', 
					'Finishing Ng', 'Serat', 'Demotograph', 'Lifting', 'Kusam', 'Flow Mark', 'Legok',
					'Salah Type', 'Getting', 'Part Campur', 'Sinmark', 'Gores', 'Gloss', 'Patah Depan',
					'Patah Belakang', 'Patah Kanan', 'Patah Kiri', 'Silver', 'Burn Mark', 'Weld Line',
					'Bubble', 'Black Dot', 'White Dot', 'Isi Tidak Set', 'Gompal', 'Salah label', 'Sobek terkena cutter',
					'Terbentur (Sobek handling)', 'Kereta (Sobek handling)', 'Terjatuh (Sobek handling)', 'Terkena Gun (Sobek handling)',
					'Sobek Handling', 'Sobek Staples', 'Staples Lepas', 'Keriput', 'Seaming Ng', 'Nonjol', 'Seal Lepas', 'Cover Ng',
					'Belum Finishing', 'Foam Ng'];
		$value_non_visual = ['Deformasi', 'Patah / Crack', 'Part Tidak Lengkap', 'Elector Mark', 'Short Shot', 'Material Asing',
					'Pecah', 'Stay Lepas', 'Salah Ulir', 'Visual T/A', 'Ulir Ng', 'Rubber TA', 'Hole Ng'];
		for($i = 1; $i < count($get_field_visual); $i++) {
			$key_visual[] = json_encode($get_field_visual[$i]);
		}
		$label_visual = array_combine($key_visual, $value_visual);
		for($i = 1; $i < count($get_field_non_visual); $i++) {
			$key_non_visual[] = json_encode($get_field_non_visual[$i]);
		}
		$label_non_visual = array_combine($key_non_visual, $value_non_visual);
		$mergeField = array_merge($get_field_visual, $get_field_non_visual);
		$merge_field_except = [];
		for($i = 0; $i < count($mergeField); $i++) {
			if($mergeField[$i] == "id_customer_claim") {
				continue;
			}
			$merge_field_except[] = $mergeField[$i];
		}
		$mergeLabel = array_merge($label_visual, $label_non_visual);
		$status_claim = $_GET['status_claim'];
		$getPart = $_GET['part'];
		$getYear = $_GET['year'];
		$getMonth = $_GET['month'];
		$getStart = $_GET['start'];
		$getEnd = $_GET['end'];

		if($status_claim != null) {
			$status = $status_claim;
		} else {
			$status = null;
		}

		if($getPart != null) {
			$part = $getPart;
		} else {
			$part = null;
		}

		if($getYear != null) {
			$year = $getYear;
		} else {
			$year = null;
		}

		if($getMonth != null) {
			$month = date("m", strtotime($getMonth));
		} else {
			$month = null;
		}

		if($getStart != null && $getEnd != null) {
			$start = date('Y-m-d', strtotime($getStart));
			$end = date('Y-m-d', strtotime($getEnd));
		} else {
			$start = null;
			$end = null;
		}
		
		$chart_rejection_claim = $this->customerclaim_model->chart_rejection_claim($start, $end, $part, $year, $month, $status);
		// print_r($chart_rejection_claim);
		$chart_rejection_claim2 = array();
		$count_merge_field_except = count($merge_field_except);
		if(!empty($chart_rejection_claim)) {
			$count_chart_rejection_claim = count($chart_rejection_claim);
			for($i = 0; $i < $count_merge_field_except; $i++) {
				$sum = 0;
				$filter_field = $merge_field_except[$i];
				for($j = 0; $j < $count_chart_rejection_claim; $j++) {
					$sum += $chart_rejection_claim[$j]->$filter_field;
				}
				$chart_rejection_claim2[$mergeLabel[json_encode($filter_field)]] = $sum;
			}
		}
		arsort($chart_rejection_claim2);
		$result = $chart_rejection_claim2;
		$data = array(
			'result' => $result,
			'count_customer_claim' => json_encode($count_customer_claim)
		);

		echo json_encode($data);
	}

	public function chart_per_part() {
		$get_customer_claim = $this->customerclaim_model->get_customer_claim();
		$count_customer_claim = count($get_customer_claim);
		$get_field_visual = $this->customerclaim_model->list_field_visual();
		$get_field_non_visual = $this->customerclaim_model->list_field_non_visual();
		$status_claim = $_GET['status_claim'];
		$getYearPart = $_GET['year'];
		$getMonth = $_GET['month'];
		$getStart = $_GET['start'];
		$getEnd = $_GET['end'];
		$mergeField = array_merge($get_field_visual, $get_field_non_visual);
		$merge_field_except = [];
		for($i = 0; $i < count($mergeField); $i++) {
			if($mergeField[$i] == "id_customer_claim") {
				continue;
			}
			$merge_field_except[] = $mergeField[$i];
		}

		if($status_claim != null) {
			$status = $status_claim;
		} else {
			$status = null;
		}

		if($getYearPart != null) {
			$year = $getYearPart;
		} else {
			$year = null;
		}

		if($getMonth != null) {
			$month = date("m", strtotime($getMonth));
		} else {
			$month = null;
		}

		if($getStart != null && $getEnd != null) {
			$start = date('Y-m-d', strtotime($getStart));
			$end = date('Y-m-d', strtotime($getEnd));
		} else {
			$start = null;
			$end = null;
		}
		// echo json_encode($_GET);
		
		$result_chart_part = array();
		$chart_part_claim = $this->customerclaim_model->chart_part_claim($start, $end, $year, $month, $status);
		// print_r($chart_part_claim);
		if(!empty($chart_part_claim)) {
			$count_chart_part_claim = count($chart_part_claim);
			for($i = 0; $i < $count_chart_part_claim; $i++) {
				// echo $i."<br/>";
				$nama_part = $chart_part_claim[$i]->nama_part;
				$filter_part = $this->customerclaim_model->filter_part($nama_part, $start, $end, $year, $month, $status);
				$count_filter_part = count($filter_part);
				$count_merge_field_except = count($merge_field_except);
				$sum = 0;
				for($k = 0; $k < $count_filter_part; $k++) {
					for($j = 0; $j < $count_merge_field_except; $j++) {
						$field = $merge_field_except[$j];
						if($filter_part[$k]->$field > 0) {
							$sum = $sum + $filter_part[$k]->$field;
						}
					}
				}
				$result_chart_part[$nama_part] = $sum;
			}
		}
		arsort($result_chart_part);
		$result = $result_chart_part;
		$data = array(
			'result' => $result,
			'count_customer_claim' => json_encode($count_customer_claim)
		);

		echo json_encode($data);
		
	}
	
	public function get_previous_data_part() {
		$tgl_input = $_GET['tgl'];
		$year = date('Y', strtotime($tgl_input));
		$month = date('m', strtotime($tgl_input));
		$nama_part = $_GET['nama_part'][0];
		$filter_claim = $this->customerclaim_model->filter_claim($year, $month, $nama_part);
		echo json_encode($filter_claim);
	}

	public function save() {
		
		// $get_field_visual = $this->customerclaim_model->list_field_visual();
		// $get_field_non_visual = $this->customerclaim_model->list_field_non_visual();
		$get_customer_claim = $this->customerclaim_model->get_customer_claim();
		$valid = $this->form_validation;
		$valid->set_rules('id_part[]', 'Id Part', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('tgl', 'Tanggal', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('no_surat_claim', 'No Surat Claim', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('tgl_surat_claim', 'Tanggal Surat Claim', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('no_lkk_qro[]', 'No Lkk Qro', 'required', 
		array('required' => '%s harus di isi'));
		$valid->set_rules('status_claim[]', 'Claim/Tukar Guling', 'required', 
		array('required' => '%s harus di isi'));
		if($valid->run()) {
			date_default_timezone_set("Asia/Jakarta");
			$tanggal = $this->input->post('tgl');
			$tanggal_surat_claim = $this->input->post('tgl_surat_claim');
			$data = array(
				'tgl_input' => date('Y-m-d', strtotime($tanggal)),
				'no_surat_claim' => $this->input->post('no_surat_claim'),
				'tgl_surat_claim' => date('Y-m-d', strtotime($tanggal_surat_claim)),
				'no_lkk_qro' => $this->input->post('no_lkk_qro'),
				'status_claim' => $this->input->post('status_claim'),
				'id_part' => $this->input->post('id_part'),
				'total_claim_actual' => $this->input->post('total_claim'),
				'total_claim_surat' => $this->input->post('total_claim_surat'),
				'status_part_claim' => $this->input->post('status_part'),
				'qty_point' => $this->input->post('qty_point'),
				'jml_qty_visual' => $this->input->post('jumlah_qty_visual'),
				'rank_point_visual' => $this->input->post('rank_point_visual'),
				'jml_qty_nonvisual' => $this->input->post('jumlah_qty_non'),
				'rank_point_nonvisual' => $this->input->post('rank_point_non'),
				'gqi_point' => $this->input->post('gqi_point'),
				'card' => $this->input->post('card')
			);

			$year = date('Y', strtotime($data['tgl_input']));
			$month = date('m', strtotime($data['tgl_input']));
			$id_part = $data['id_part'];

			for($j = 0; $j < count($id_part); $j++) {
				$gqi_point = $data['gqi_point'][$j];
				$get_customer_claim_by_tb = $this->customerclaim_model->get_customer_claim_by_tb($year, $month, $data['id_part'][$j]);
				if(!empty($get_customer_claim_by_tb)) {
					$gqi_point += $get_customer_claim_by_tb[0]->gqi_point;
				}
				// for($i = 0; $i < count($get_customer_claim); $i++) {
				// 	$get_year = date('Y', strtotime($get_customer_claim[$i]->tgl_input));
				// 	$get_month = date('m', strtotime($get_customer_claim[$i]->tgl_input));
				// 	$get_nama_part = $get_customer_claim[$i]->nama_part;
				// 	if($year === $get_year && $month === $get_month && $nama_part === $get_nama_part) {
				// 		$gqi_point += $get_customer_claim[$i]->gqi_point;
				// 	}
				// }
				$data['gqi_point'][$j] = $gqi_point;
				if($gqi_point > 114) {
					$data['card'][$j] = 'Red Card';
				} elseif ($gqi_point > 100) {
					$data['card'][$j] = 'Yellow Card';
				} elseif ($gqi_point > 0) {
					$data['card'][$j] = 'Green Card';
				} else {
					$data['card'][$j] = '#N/A';	
				}
				$data_multiple = array(
					'tgl_input' => $data['tgl_input'],
					'no_surat_claim' => $data['no_surat_claim'],
					'tgl_surat_claim' => $data['tgl_surat_claim'],
					'no_lkk_qro' => $data['no_lkk_qro'][$j],
					'status_claim' => $data['status_claim'][$j],
					'id_part' => $data['id_part'][$j],
					'total_claim_actual' => $data['total_claim_actual'][$j],
					'total_claim_surat' => $data['total_claim_surat'][$j],
					'status_part_claim' => $data['status_part_claim'][$j],
					'qty_point' => $data['qty_point'][$j],
					'jml_qty_visual' => $data['jml_qty_visual'][$j],
					'rank_point_visual' => $data['rank_point_visual'][$j],
					'jml_qty_nonvisual' => $data['jml_qty_nonvisual'][$j],
					'rank_point_nonvisual' => $data['rank_point_nonvisual'][$j],
					'gqi_point' => $data['gqi_point'][$j],
					'card' => $data['card'][$j]
				);

				$this->customerclaim_model->save_claim_customer($data_multiple);
				$next_id_customer_claim = $this->customerclaim_model->max_id();
				$get_customer_claim = $this->customerclaim_model->get_customer_claim();
				$select_record_part = $this->customerclaim_model->select_id_part($data_multiple['id_part']);
				$sum = 0;
				for($i = 0; $i < count($get_customer_claim); $i++) {
					if($select_record_part->id_customer === $get_customer_claim[$i]->customer) {
						$sum += $get_customer_claim[$i]->jml_qty_visual + $get_customer_claim[$i]->jml_qty_nonvisual;
					}
				}
				$this->customer_model->update_visual_nonvisual($select_record_part->id_customer, $sum);
				$data_visual = array(
					'id_customer_claim' => $next_id_customer_claim,
					'Kotor' => $this->input->post('kotor_visual'),
					'Lecet' => $this->input->post('lecet_visual'),
					'Tipis' => $this->input->post('tipis_visual'),
					'Meler' => $this->input->post('meler_visual'),
					'Nyerep' => $this->input->post('nyerep_visual'),
					'O_Peel' => $this->input->post('opeel_visual'),
					'Buram' => $this->input->post('buram_visual'),
					'Over_Cut' => $this->input->post('overcut_visual'),
					'Burry' => $this->input->post('burry_visual'),
					'Belang' => $this->input->post('belang_visual'),
					'Ngeflek' => $this->input->post('ngeflek_visual'),
					'Minyak' => $this->input->post('minyak_visual'),
					'Dustray' => $this->input->post('dustray_visual'),
					'Cat_Kelupas' => $this->input->post('cat_kelupas_visual'),
					'Bintik_Air' => $this->input->post('b_air_visual'),
					'Finishing_Ng' => $this->input->post('f_ng_visual'),
					'Serat' => $this->input->post('serat_visual'),
					'Demotograph' => $this->input->post('d_graph_visual'),
					'Lifting' => $this->input->post('lifting_visual'),
					'Kusam' => $this->input->post('kusam_visual'),
					'Flow_Mark' => $this->input->post('f_mark_visual'),
					'Legok' => $this->input->post('legok_visual'),
					'Salah_Type' => $this->input->post('s_type_visual'),
					'Getting' => $this->input->post('getting_visual'),
					'Part_Campur' => $this->input->post('part_campur_visual'),
					'Sinmark' => $this->input->post('sinmark_visual'),
					'Gores' => $this->input->post('gores_visual'),
					'Gloss' => $this->input->post('gloss_visual'),
					'Patah_Depan' => $this->input->post('p_depan_visual'),
					'Patah_Belakang' => $this->input->post('p_belakang_visual'),
					'Patah_Kanan' => $this->input->post('p_kanan_visual'),
					'Patah_Kiri' => $this->input->post('p_kiri_visual'),
					'Silver' => $this->input->post('silver_visual'),
					'Burn_Mark' => $this->input->post('b_mark_visual'),
					'Weld_Line' => $this->input->post('w_line_visual'),
					'Bubble' => $this->input->post('bubble_visual'),
					'Black_Dot' => $this->input->post('b_dot_visual'),
					'White_Dot' => $this->input->post('w_dot_visual'),
					'Isi_Tidak_Set' => $this->input->post('isi_tidak_set_visual'),
					'Gompal' => $this->input->post('gompal_visual'),
					'Salah_label' => $this->input->post('s_label_visual'),
					'Sobek_terkena_cutter' => $this->input->post('t_cutter_visual'),
					'Terbentur' => $this->input->post('terbentur_visual'),
					'Kereta' => $this->input->post('kereta_visual'),
					'Terjatuh' => $this->input->post('terjatuh_visual'),
					'Terkena_Gun' => $this->input->post('terkena_gun_visual'),
					'Sobek_Handling' => $this->input->post('s_handling_visual'),
					'Sobek_Staples' => $this->input->post('s_steples_visual'),
					'Staples_Lepas' => $this->input->post('s_lepas_visual'),
					'Keriput' => $this->input->post('keriput_visual'),
					'Seaming_Ng' => $this->input->post('seaming_ng_visual'),
					'Nonjol' => $this->input->post('nonjol_visual'),
					'Seal_Lepas' => $this->input->post('seal_lepas_visual'),
					'Cover_Ng' => $this->input->post('cover_ng_visual'),
					'Belum_Finishing' => $this->input->post('b_finishing_visual'),
					'Foam_Ng' => $this->input->post('foam_ng_visual')
				);

				$data_visual_multiple = array(
					'id_customer_claim' => $data_visual['id_customer_claim'],
					'Kotor' => $data_visual['Kotor'][$j],
					'Lecet' => $data_visual['Lecet'][$j], 
					'Tipis' => $data_visual['Tipis'][$j], 
					'Meler' => $data_visual['Meler'][$j], 
					'Nyerep' => $data_visual['Nyerep'][$j], 
					'O_Peel' => $data_visual['O_Peel'][$j], 
					'Buram' => $data_visual['Buram'][$j], 
					'Over_Cut' => $data_visual['Over_Cut'][$j], 
					'Burry' => $data_visual['Burry'][$j], 
					'Belang' => $data_visual['Belang'][$j], 
					'Ngeflek' => $data_visual['Ngeflek'][$j], 
					'Minyak' => $data_visual['Minyak'][$j], 
					'Dustray' => $data_visual['Dustray'][$j], 
					'Cat_Kelupas' => $data_visual['Cat_Kelupas'][$j], 
					'Bintik_Air' => $data_visual['Bintik_Air'][$j], 
					'Finishing_Ng' => $data_visual['Finishing_Ng'][$j],
					'Serat' => $data_visual['Serat'][$j], 
					'Demotograph' => $data_visual['Demotograph'][$j],
					'Lifting' => $data_visual['Lifting'][$j], 
					'Kusam' => $data_visual['Kusam'][$j], 
					'Flow_Mark' => $data_visual['Flow_Mark'][$j], 
					'Legok' => $data_visual['Legok'][$j], 
					'Salah_Type' => $data_visual['Salah_Type'][$j], 
					'Getting' => $data_visual['Getting'][$j], 
					'Part_Campur' => $data_visual['Part_Campur'][$j], 
					'Sinmark' => $data_visual['Sinmark'][$j], 
					'Gores' => $data_visual['Gores'][$j], 
					'Gloss' => $data_visual['Gloss'][$j], 
					'Patah_Depan' => $data_visual['Patah_Depan'][$j], 
					'Patah_Belakang' => $data_visual['Patah_Belakang'][$j], 
					'Patah_Kanan' => $data_visual['Patah_Kanan'][$j], 
					'Patah_Kiri' => $data_visual['Patah_Kiri'][$j], 
					'Silver' => $data_visual['Silver'][$j], 
					'Burn_Mark' => $data_visual['Burn_Mark'][$j], 
					'Weld_Line' => $data_visual['Weld_Line'][$j], 
					'Bubble' => $data_visual['Bubble'][$j], 
					'Black_Dot' => $data_visual['Black_Dot'][$j], 
					'White_Dot' => $data_visual['White_Dot'][$j], 
					'Isi_Tidak_Set' => $data_visual['Isi_Tidak_Set'][$j],
					'Gompal' => $data_visual['Gompal'][$j], 
					'Salah_label' => $data_visual['Salah_label'][$j],
					'Sobek_terkena_cutter' => $data_visual['Sobek_terkena_cutter'][$j],
					'Terbentur' => $data_visual['Terbentur'][$j],
					'Kereta' => $data_visual['Kereta'][$j], 
					'Terjatuh' => $data_visual['Terjatuh'][$j],
					'Terkena_Gun' => $data_visual['Terkena_Gun'][$j], 
					'Sobek_Handling' => $data_visual['Sobek_Handling'][$j], 
					'Sobek_Staples' => $data_visual['Sobek_Staples'][$j], 
					'Staples_Lepas' => $data_visual['Staples_Lepas'][$j],
					'Keriput' => $data_visual['Keriput'][$j],
					'Seaming_Ng' => $data_visual['Seaming_Ng'][$j], 
					'Nonjol' => $data_visual['Nonjol'][$j], 
					'Seal_Lepas' => $data_visual['Seal_Lepas'][$j], 
					'Cover_Ng' => $data_visual['Cover_Ng'][$j],
					'Belum_Finishing' => $data_visual['Belum_Finishing'][$j], 
					'Foam_Ng' => $data_visual['Foam_Ng'][$j],
				);
				
				$this->customerclaim_model->save_visual($data_visual_multiple);

				$data_non_visual = array(
					'id_customer_claim' => $next_id_customer_claim,
					'Deformasi' => $this->input->post('deformasi_non'),
					'Patah' => $this->input->post('patah_non'),
					'Part_Tidak_Lengkap' => $this->input->post('incomplete_part_non'),
					'Elector_Mark' => $this->input->post('e_mark_non'),
					'Short_Shot' => $this->input->post('short_shot_non'),
					'Material_Asing' => $this->input->post('material_asing_non'),
					'Pecah' => $this->input->post('pecah_non'),
					'Stay_Lepas' => $this->input->post('stay_lepas_non'),
					'Salah_Ulir' => $this->input->post('salah_ulir_non'),
					'Visual_TA' => $this->input->post('visual_ta_non'),
					'Ulir_Ng' => $this->input->post('ulir_ng_non'),
					'Rubber_TA' => $this->input->post('rubber_ta_non'),
					'Hole_Ng' => $this->input->post('hole_ng_non')
				);

				
				$data_non_multiple = array(
					'id_customer_claim' => $data_non_visual['id_customer_claim'],
					'Deformasi' => $data_non_visual['Deformasi'][$j],
					'Patah' => $data_non_visual['Patah'][$j],
					'Part_Tidak_Lengkap' => $data_non_visual['Part_Tidak_Lengkap'][$j],
					'Elector_Mark' => $data_non_visual['Elector_Mark'][$j], 
					'Short_Shot' => $data_non_visual['Short_Shot'][$j], 
					'Material_Asing' => $data_non_visual['Material_Asing'][$j],
					'Pecah' => $data_non_visual['Pecah'][$j], 
					'Stay_Lepas' => $data_non_visual['Stay_Lepas'][$j], 
					'Salah_Ulir' => $data_non_visual['Salah_Ulir'][$j], 
					'Visual_TA' => $data_non_visual['Visual_TA'][$j], 
					'Ulir_Ng' => $data_non_visual['Ulir_Ng'][$j], 
					'Rubber_TA' => $data_non_visual['Rubber_TA'][$j], 
					'Hole_Ng' => $data_non_visual['Hole_Ng'][$j], 
				);

				$this->customerclaim_model->save_non_visual($data_non_multiple);
			}

			$this->session->set_flashdata('sukses', 'CUSTOMER CLAIM TELAH DI SIMPAN!');
			redirect(base_url('claim/customerclaim/ahm'), 'refresh');
		}
	}
	
	public function testing_input() {
		echo $this->customerclaim_model->testing();
	}
}

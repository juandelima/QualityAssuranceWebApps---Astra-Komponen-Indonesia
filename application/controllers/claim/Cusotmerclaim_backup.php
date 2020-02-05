<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Customerclaim extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('customer_model');
		$this->load->model('customerclaim_model');
		$this->load->model('listpart_model');
		$this->load->helper('date');
	}

	public function ahm() {
		$get_customer = $this->customerclaim_model->get_customer();
		$get_customer_claim = $this->customerclaim_model->get_customer_claim();
		$get_customer_claim_distinct = $this->customerclaim_model->get_customer_claim_distinct();
		$get_customer_claim_sort_by_date = $this->customerclaim_model->get_customer_claim_sort_by_date();
		$get_visual = $this->customerclaim_model->listing_visual();	
		$get_field_visual = $this->customerclaim_model->list_field_visual();
		$get_non_visual = $this->customerclaim_model->listing_non_visual();
		$get_field_non_visual = $this->customerclaim_model->list_field_non_visual();
		// $rejections = [];
		$visual = [];
		$key_visual = [];
		$non_visual = [];
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
		$merge_mark_visual_non = array_merge($value_visual, $value_non_visual);
		// ALGORITMA UNTUK MEMFILTER JUMLAH VISUAL DAN NON VISUAL YANG LEBIH DARI 0 DAN MEMBACA FIELD VISUAL DAN NON VISUAL
		for($i = 1; $i < count($get_field_visual); $i++) {
			$key_visual[] = json_encode($get_field_visual[$i]);
		}
		$label_visual = array_combine($key_visual, $value_visual);
		for($i = 0; $i < count($get_customer_claim); $i++) {
			$temp = [];
			if($get_customer_claim[$i]->id_customer_claim === $get_visual[$i]->id_customer_claim) {
				$id = $get_visual[$i]->id_customer_claim;
				for($j = 1; $j < count($get_field_visual); $j++) {
					$field = $get_field_visual[$j];
					if($get_visual[$i]->$field > 0) {
						$temp[] = $label_visual[json_encode($field)];
						$temp[] = $get_visual[$i]->$field;
					}
				}
				$junk = array(
					$id => $temp,
				);
			}
			$visual[] = $junk;
		}
		for($i = 1; $i < count($get_field_non_visual); $i++) {
			$key_non_visual[] = json_encode($get_field_non_visual[$i]);
		}
		$label_non_visual = array_combine($key_non_visual, $value_non_visual);
		for($i = 0; $i < count($get_customer_claim); $i++) {
			$temp = [];
			if($get_customer_claim[$i]->id_customer_claim === $get_non_visual[$i]->id_customer_claim) {
				$id = $get_non_visual[$i]->id_customer_claim;
				for($j = 1; $j < count($get_field_non_visual); $j++) {
					$field = $get_field_non_visual[$j];
					if($get_non_visual[$i]->$field > 0) {
						$temp[] = $label_non_visual[json_encode($field)];
						$temp[] = $get_non_visual[$i]->$field;
					}
				}
				$junk = array(
					$id => $temp,
				);
			}
			$non_visual[] = $junk;
		}
		$mergeField = array_merge($get_field_visual, $get_field_non_visual);
		$merge_field_except = [];
		for($i = 0; $i < count($mergeField); $i++) {
			if($mergeField[$i] == "id_customer_claim") {
				continue;
			}
			$merge_field_except[] = $mergeField[$i];
		}
		$mergeLabel = array_merge($label_visual, $label_non_visual);
		$getStart = $get_customer_claim_sort_by_date[0]->tgl_input;
		$getEnd = $get_customer_claim_sort_by_date[count($get_customer_claim_sort_by_date) - 1]->tgl_input;
		$start = date('Y-m-d', strtotime($getStart));
		$end = date('Y-m-d', strtotime($getEnd));
		$day_chart_claim = $this->customerclaim_model->day_chart_claim($start, $end);
		$day_chart_claim2 = array();
		for($i = 0; $i < count($merge_field_except); $i++) {
			$filter_field = $merge_field_except[$i];
			$day_chart_claim2[$mergeLabel[json_encode($filter_field)]] = $day_chart_claim->$filter_field;
		}
		$result = json_encode($day_chart_claim2);
		$decode = json_decode($result, true);
		arsort($decode);
		$result2 = json_encode($decode);
		$rejection_by_id = array();
		$rejection_by_part = array();
		$index = 0;
		foreach($get_customer_claim as $data) {
			$id = $data->id_customer_claim;
			$limit_visual = count($visual[$index][$id]) / 2;
			$limit_non_visual = count($non_visual[$index][$id]) / 2;
			$read_visual = 0;
			$read_non_visual = 0;
			for($i = 0; $i < $limit_visual; $i++) {
				$rejection_by_part[$visual[$index][$id][$read_visual]] = $visual[$index][$id][$read_visual + 1];
				$read_visual += 2;
			}

			for($i = 0; $i < $limit_non_visual; $i++) {
				$rejection_by_part[$non_visual[$index][$id][$read_non_visual]] = $non_visual[$index][$id][$read_non_visual + 1];
				$read_non_visual += 2;
			}
			$rejection_by_id[$id] = $rejection_by_part;
			$rejection_by_part = array(); 
			$index++;
		}

		foreach($get_customer_claim as $data) {
			$id = $data->id_customer_claim;
			arsort($rejection_by_id[$id]);
		}
 		$data = array(
			'customer' => $get_customer,
			'customer_claim' => $get_customer_claim,
			'customer_claim_dist' => $get_customer_claim_distinct,
			'show_visual' => $visual,
			'show_non_visual' => $non_visual,
			'dataChart' => $result2,
			'start' => $start,
			'end' => $end,
			'chartByPart' => $rejection_by_id,
		);
		$this->load->view('customer_claim/index', $data);
	} 
 
 	public function create_ahm() {
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
		);
		$this->load->view('customer_claim/tambah', $data);
	}

	public function filter_chart() {
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
		$getPart = $_POST['part'];
		$getYear = $_POST['year'];
		$getMonth = $_POST['month'];
		$getStart = $_POST['start'];
		$getEnd = $_POST['end'];
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
		
		$day_chart_claim = $this->customerclaim_model->day_chart_claim($start, $end, $part, $year, $month);
		$day_chart_claim2 = array();
		for($i = 0; $i < count($merge_field_except); $i++) {
			$filter_field = $merge_field_except[$i];
			$day_chart_claim2[$mergeLabel[json_encode($filter_field)]] = $day_chart_claim->$filter_field;
		}
		$encode = json_encode($day_chart_claim2);
		$decode = json_decode($encode, true);
		arsort($decode);
		$result = json_encode($decode);
		echo $result;
	}
	
	public function get_previous_data_part() {
		$tgl_input = $_POST['tgl'];
		$year = date('Y', strtotime($tgl_input));
		$month = date('m', strtotime($tgl_input));
		$nama_part = $_POST['nama_part'][0];
		$filter_claim = $this->customerclaim_model->filter_claim($year, $month, $nama_part);
		echo json_encode($filter_claim);
	}

	public function save() {
		$get_field_visual = $this->customerclaim_model->list_field_visual();
		$get_field_non_visual = $this->customerclaim_model->list_field_non_visual();
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
		if($valid->run()) {
			date_default_timezone_set("Asia/Jakarta");
			$tanggal = $this->input->post('tgl');
			$tanggal_surat_claim = $this->input->post('tgl_surat_claim');
			$data = array(
				'tgl_input' => date('Y-m-d', strtotime($tanggal)),
				'no_surat_claim' => $this->input->post('no_surat_claim'),
				'tgl_surat_claim' => date('Y-m-d', strtotime($tanggal_surat_claim)),
				'no_lkk_qro' => $this->input->post('no_lkk_qro'),
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
				$get_part = $this->customerclaim_model->select_id_part($id_part[$j]);
				$nama_part = $get_part->NAMA_PART;
				$qty_point = $data['qty_point'][$j];
				$jml_rejection_visual = $data['jml_qty_visual'][$j];
				$rank_point_visual = $data['rank_point_visual'][$j];
				$jml_rejection_nonvisual = $data['jml_qty_nonvisual'][$j];
				$rank_point_nonvisual = $data['rank_point_nonvisual'][$j];
				$gqi_point = $data['gqi_point'][$j];
				for($i = 0; $i < count($get_customer_claim); $i++) {
					$get_year = date('Y', strtotime($get_customer_claim[$i]->tgl_input));
					$get_month = date('m', strtotime($get_customer_claim[$i]->tgl_input));
					$get_nama_part = $get_customer_claim[$i]->NAMA_PART;
					if($year === $get_year && $month === $get_month && $nama_part === $get_nama_part) {
						$qty_point += $get_customer_claim[$i]->qty_point;
						$jml_rejection_visual += $get_customer_claim[$i]->jml_qty_visual;
						$rank_point_visual += $get_customer_claim[$i]->rank_point_visual;
						$jml_rejection_nonvisual += $get_customer_claim[$i]->jml_qty_nonvisual;
						$rank_point_nonvisual += $get_customer_claim[$i]->rank_point_nonvisual;
						$gqi_point += $get_customer_claim[$i]->gqi_point;
					}
				}
				$data['qty_point'][$j] = $qty_point;
				$data['jml_qty_visual'][$j] = $jml_rejection_visual;
				$data['rank_point_visual'][$j] = $rank_point_visual;
				$data['jml_qty_nonvisual'][$j] = $jml_rejection_nonvisual;
				$data['rank_point_nonvisual'][$j] = $rank_point_nonvisual;
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
					if($select_record_part->id_customer === $get_customer_claim[$i]->CUSTOMER) {
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
				// print_r($data_visual_multiple."<br/>");
				// print_r($data_visual_multiple["id_customer_claim"]."<br/>");
				$select_claim = $this->customerclaim_model->select_claim($data_visual_multiple["id_customer_claim"]);
				$detail_claim = $this->customerclaim_model->detail_customer_claim();
				$year = date('Y', strtotime($select_claim->tgl_input));
				$month = date('m', strtotime($select_claim->tgl_input));
				$nama_part = $select_claim->NAMA_PART;
				for($i = 0; $i < count($detail_claim); $i++) {
					$get_year = date('Y', strtotime($detail_claim[$i]->tgl_input));
					$get_month = date('m', strtotime($detail_claim[$i]->tgl_input));
					$get_nama_part = $detail_claim[$i]->NAMA_PART;
					if($year == $get_year && $month == $get_month && $nama_part == $get_nama_part) {
						for($x = 1; $x < count($get_field_visual); $x++) {
							$field = $get_field_visual[$x];
							if($data_visual_multiple[$field] > 0 || $detail_claim[$i]->$field > 0) {
								$data_visual_multiple[$field] += $detail_claim[$i]->$field;
							}
						}
					}
				}

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

				$select_claim = $this->customerclaim_model->select_claim($data_non_multiple["id_customer_claim"]);
				$detail_claim = $this->customerclaim_model->detail_customer_claim();
				$year = date('Y', strtotime($select_claim->tgl_input));
				$month = date('m', strtotime($select_claim->tgl_input));
				$nama_part = $select_claim->NAMA_PART;
				for($i = 0; $i < count($detail_claim); $i++) {
					$get_year = date('Y', strtotime($detail_claim[$i]->tgl_input));
					$get_month = date('m', strtotime($detail_claim[$i]->tgl_input));
					$get_nama_part = $detail_claim[$i]->NAMA_PART;
					if($year == $get_year && $month == $get_month && $nama_part == $get_nama_part) {
						for($x = 1; $x < count($get_field_non_visual); $x++) {
							$field = $get_field_non_visual[$x];
							if($data_non_multiple[$field] > 0 || $detail_claim[$i]->$field > 0) {
								$data_non_multiple[$field] += $detail_claim[$i]->$field;
							}
						}
					}
				}

				$this->customerclaim_model->save_non_visual($data_non_multiple);
			}

			$this->session->set_flashdata('sukses', 'CUSTOMER CLAIM TELAH DI SIMPAN!');
			redirect(base_url('claim/customerclaim'), 'refresh');
		}
	}

	public function edit($id_customer_claim) {

	}

	public function delete($id_customer_claim) {

	}
	
}

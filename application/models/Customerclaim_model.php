<?php
class Customerclaim_model extends CI_Model {

	private $table = 'claim_customer';


	public function testing() {
		$start_date = strtotime("02-08-2018");
		$list_field_visual = $this->list_field_visual();
		$list_field_non_visual = $this->list_field_non_visual();
		$count_list_visual = count($list_field_visual);
		$count_list_nonvisual = count($list_field_non_visual);
		$get_customer_claim = $this->get_customer_claim();
		$index = 278;
		for($i = 0; $i < 110; $i++) {
			$getPart = $this->getRandomPart();
			$intvl = $i + 5;
			$tgl_input = date("Y-m-d", strtotime("+10 day", $start_date));
			$tgl_claim = date("Y-m-d", strtotime("+8 day", $start_date));
			$tgl_delive = date("Y-m-d", strtotime("+6 day", $start_date));
			$year = date("Y", strtotime($tgl_input));
			$data = array(
				'tgl_input' => $tgl_input,
				'no_surat_claim' => "AHM/0{$i}/11000{$i}/{$i}/{$year}",
				'tgl_surat_claim' => $tgl_claim,
				'no_lkk_qro' => "EKT/{$i}/QA/ASKI/{$intvl}/{$year}",
				'id_part' => $getPart->ID_PART,
				'total_claim_actual' => 0,
				'total_claim_surat' => 0,
				'status_part_claim' => 'RECEIVED',
				'qty_point' => 0,
				'jml_qty_visual' => 0,
				'rank_point_visual' => 0,
				'jml_qty_nonvisual' => 0,
				'rank_point_nonvisual' => 'FALSE',
				'gqi_point' => 0,
				'card' => NULL,
				'status_claim' => NULL,
				'ppt_file' => NULL,
			);

			if($i % 2 == 0) {
				$data['status_claim'] = 'Claim';
			} else {
				$data['status_claim'] = 'Tukar Guling';
			}

			$sum_visual = 0;
			$sum_non_visual = 0;
			
			$data_visual = array();
			for($j = 0; $j < $count_list_visual; $j++) {
				$field = $list_field_visual[$j];
				if($field == "id_customer_claim") {
					$data_visual[$field] = $index;
					continue;
				}
				$data_visual[$field] = rand(0, 30);
				$sum_visual += $data_visual[$field];
			}

			$data['jml_qty_visual'] = $sum_visual;

			$data_non_visual = array();
			for($j = 0; $j < $count_list_nonvisual; $j++) {
				$field = $list_field_non_visual[$j];
				if($field == "id_customer_claim") {
					$data_non_visual[$field] = $index;
					continue;
				}
				$data_non_visual[$field] = rand(0, 30);
				$sum_non_visual += $data_non_visual[$field];
			}

			$data['jml_qty_nonvisual'] = $sum_non_visual;

			$sum_all_visual_non = $sum_visual + $sum_non_visual;

			if(!empty($get_customer_claim)) {
				$year = date('Y', strtotime($tgl_input));
				$month = date('m', strtotime($tgl_input));
				$gqi_point = 0;
				$select_id_part = $this->select_id_part($getPart->ID_PART);
				$nama_part = $select_id_part->NAMA_PART;
				for($k = 0; $k < count($get_customer_claim); $k++) {
					$get_year = date('Y', strtotime($get_customer_claim[$k]->tgl_input));
					$get_month = date('m', strtotime($get_customer_claim[$k]->tgl_input));
					$get_nama_part = $get_customer_claim[$k]->NAMA_PART;
					if($year === $get_year && $month === $get_month && $nama_part === $get_nama_part) {
						$gqi_point += $get_customer_claim[$k]->gqi_point;
					}
				}
				$data['gqi_point'] = $gqi_point;
			}

			$data['total_claim_actual'] = $sum_all_visual_non;
			$data['total_claim_surat'] = $sum_all_visual_non;

			if($data['total_claim_surat'] > 499) {
				$data['qty_point'] = 115;
			} elseif($data['total_claim_surat'] > 299) {
				$data['qty_point'] = 70;
			} elseif($data['total_claim_surat'] > 199) {
				$data['qty_point'] = 50;
			} elseif($data['total_claim_surat'] > 1) { 
				$data['qty_point'] = 10;
			} elseif($data['total_claim_surat'] > 0) {
				$data['qty_point'] = 2;
			} else {
				$data['qty_point'] = 0;
			}


			if($data['jml_qty_visual'] > 0) {
				$data['rank_point_visual'] = 4;
			} else {
				$data['rank_point_visual'] = 0;
			}

			if($getPart->PROSES == 'NON') {
				$data['rank_point_nonvisual'] = 'FALSE';
			} elseif($getPart->PROSES == '#N/A') {
				$data['rank_point_nonvisual'] = '#N/A';
			} elseif($getPart->PROSES == 'HS') {
				if($data['jml_qty_nonvisual'] > 0) {
					$data['rank_point_nonvisual'] = 100;
				}
			} elseif($getPart->PROSES == 'HA') {
				if($data['jml_qty_nonvisual'] > 0) {
					$data['rank_point_nonvisual'] = 100;
				}
			} elseif($getPart->PROSES == 'HB') {
				if($data['jml_qty_nonvisual'] > 0) {
					$data['rank_point_nonvisual'] = 20;
				}
			} elseif($getPart->PROSES == 'NON') {
				if($data['jml_qty_nonvisual'] > 0) {
					$data['rank_point_nonvisual'] = 4;
				}
			} else {
				if($data['jml_qty_nonvisual'] <= 0) {
					$data['rank_point_nonvisual'] = 0;
				}
			}

			$qty_point = $data['qty_point'];
			$rank_point_visual = $data['rank_point_visual'];
			$rank_point_nonvisual = $data['rank_point_nonvisual'];
			if($rank_point_nonvisual == 'FALSE') {
				$calculate = $qty_point + $rank_point_visual;
				$data['gqi_point'] += $calculate;
			} elseif($rank_point_nonvisual == '#N/A') {
				$data['gqi_point'] = '#N/A';
			} else {
				$calc = $qty_point + $rank_point_visual + $rank_point_nonvisual;
				$data['gqi_point'] += $calc; 
			}

			$gqi_point = $data['gqi_point'];
			if($gqi_point > 114) {
				$data['card'] = 'Red Card';
			} elseif($gqi_point > 100) {
				$data['card'] = 'Yellow Card';
			} elseif($gqi_point > 0) {
				$data['card'] = 'Green Card';
			} else {
				$data['card'] = '#N/A';
			}

			$data_delivery = array(
				'tgl_delivery' => $tgl_delive,
				'qty' => rand(10, 200)
			);
			$this->save_claim_customer($data);
			$this->save_visual($data_visual);
			$this->save_non_visual($data_non_visual);
			$this->save_delivery($data_delivery);
			// echo json_encode($data)."<br/>";
			// echo json_encode($data_visual)."<br/>";
			// echo json_encode($data_non_visual);
			// echo "<br/>";
			// echo "<br/>";
			$start_date = strtotime($tgl_input); 
			$index += 1;
		}
		
	}

	public function save_delivery($data) {
		$this->db->insert('delivery', $data);
	}
	public function getRandomPart() {
		$this->db->select("*");
		$this->db->from('data_parts');
		$this->db->where('CUSTOMER', 1);
		$this->db->order_by('ID_PART', 'RANDOM');
		$query = $this->db->get();
		return $query->row();
	}

	public function listing_visual() {
		$this->db->select("*");
		$this->db->from("visual");
		$query = $this->db->get();
		return $query->result();
	}

	public function listing_non_visual() {
		$this->db->select("*");
		$this->db->from("non_visual");
		$query = $this->db->get();
		return $query->result();
	}
	
	public function list_field_visual() {
		$this->db->select("*");
		$this->db->from('visual');
		$query = $this->db->get();
		return $query->list_fields();
	}

	public function list_field_non_visual() {
		$this->db->select("*");
		$this->db->from('non_visual');
		$query = $this->db->get();
		return $query->list_fields();
	}

	public function detail_customer_claim() {
		$array_select = array(
			'claim_customer.*',
			'data_parts.*',
			'visual.*',
			'non_visual.*'
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->join('data_parts', 'data_parts.id_part = claim_customer.id_part', 'INNER');
		$this->db->join('visual', 'claim_customer.id_customer_claim = visual.id_customer_claim', 'INNER');
		$this->db->join('non_visual', 'claim_customer.id_customer_claim = non_visual.id_customer_claim', 'INNER');
		$query = $this->db->get();
		return $query->result();
	}

	public function select_claim($id_customer_claim) {
		$array_select = array(
			'claim_customer.*',
			'data_parts.*'
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->join('data_parts', 'data_parts.id_part = claim_customer.id_part', 'INNER');
		$this->db->where('id_customer_claim', $id_customer_claim);
		$query = $this->db->get();
		return $query->row();
	}

	public function select_id_part($id_part) {
		$array_select = array(
			'data_parts.*',
			'customer.*'
		);
		$this->db->select($array_select);
		$this->db->from('data_parts');
		$this->db->join('customer', 'customer.id_customer = data_parts.CUSTOMER', 'INNER');
		$this->db->where('id_part', $id_part);
		$query = $this->db->get();
		return $query->row();
	}

	public function get_data_parts() {
		$array_select = array(
			'data_parts.*',
			'claim_customer.*'
		);
		$this->db->select($array_select);
		$this->db->from("data_parts");
		$this->db->join("claim_customer", "data_parts.id_part = claim_customer.id_part", "INNER");
		$this->db->join("customer", "customer.id_customer = data_parts.CUSTOMER", "INNER");
		$this->db->order_by("claim_customer.id_customer_claim", "DESC");
		$query = $this->db->get();
		return $query->result();
	}

	public function get_customer_claim() {
		$array_select = array(
			'claim_customer.*',
			'data_parts.*',
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->join("data_parts", "data_parts.id_part = claim_customer.id_part", "INNER");
		$this->db->order_by("claim_customer.id_customer_claim", "ASC");
		$query = $this->db->get();
		return $query->result();
	}

	public function get_customer_claim_distinct() {
		$array_select = array(
			'claim_customer.*',
			'data_parts.*',
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->join("data_parts", "data_parts.id_part = claim_customer.id_part", "INNER");
		$this->db->group_by('data_parts.NAMA_PART');
		$this->db->order_by("claim_customer.id_customer_claim", "ASC");
		$query = $this->db->get();
		return $query->result();
	}

	public function get_customer_claim_sort_by_date() {
		$array_select = array(
			'claim_customer.*',
			'data_parts.*',
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->join("data_parts", "data_parts.id_part = claim_customer.id_part", "INNER");
		$this->db->order_by("claim_customer.tgl_input", "ASC");
		$query = $this->db->get();
		return $query->result();
	}

	public function get_customer() {
		$array_select = array(
			'customer.*',
		);
		$this->db->distinct();
		$this->db->select($array_select);
		$this->db->from('customer');
		$this->db->join("data_parts", "customer.id_customer = data_parts.CUSTOMER", "INNER");
		$this->db->order_by("customer.total_visual_and_nonvisual", "ASC");
		$query = $this->db->get();
		return $query->result();
	}
	public function save_claim_customer($data) {
		$this->db->insert($this->table, $data);
	}

	public function save_visual($data) {
		$this->db->insert('visual', $data);
	}

	public function save_non_visual($data) {
		$this->db->insert('non_visual', $data);
	}

	public function upload_ppt($data) {
		$this->db->set('ppt_file', $data['ppt_file']);
		$this->db->where('id_customer_claim', $data['id_customer_claim']);
		$result = $this->db->update('claim_customer');
		return $result;
	}

	public function max_id() {
		$this->db->select_max('id_customer_claim');
		$this->db->from($this->table);
		$query = $this->db->get();
		$max = $query->row()->id_customer_claim;
		return $max;
	}


	public function filter_claim($year, $month, $nama_part) { // Buat get datapart sebelumnya utk kalkulasi card
		$array_select = array(
			'claim_customer.*',
			'data_parts.*',
			'visual.*',
			'non_visual.*'
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->join('data_parts', 'data_parts.id_part = claim_customer.id_part', 'INNER');
		$this->db->join('visual', 'claim_customer.id_customer_claim = visual.id_customer_claim', 'INNER');
		$this->db->join('non_visual', 'claim_customer.id_customer_claim = non_visual.id_customer_claim', 'INNER');
		$this->db->where("MONTH(claim_customer.tgl_input)", $month);
		$this->db->where("YEAR(claim_customer.tgl_input)", $year);
		$this->db->where("data_parts.NAMA_PART", $nama_part);
		$this->db->order_by("claim_customer.id_customer_claim", "DESC");
		$query = $this->db->get();
		return $query->row();
	}

	public function chart_claim() {
		$array_select = array(
			'*',
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->group_by("tgl_input");
		$this->db->order_by("tgl_input", "ASC");
		$query = $this->db->get();
		return $query->result();
	}

	public function chart_rejection_claim($start = null, $end = null, $part = null, $year = null, $month = null, $status_claim = null) {
		$get_customer_claim_sort_by_date = $this->get_customer_claim_sort_by_date();
		if(!empty($get_customer_claim_sort_by_date)) {
			$start_all_part = $get_customer_claim_sort_by_date[0]->tgl_input;
			$end_all_part = $get_customer_claim_sort_by_date[count($get_customer_claim_sort_by_date)  - 1]->tgl_input;
			$start_by_all_part = date('Y-m-d', strtotime($start_all_part));
			$end_by_all_part = date('Y-m-d', strtotime($end_all_part));
		}
		$array_select = array(
			"SUM(visual.Kotor) as Kotor",
			"SUM(visual.Lecet) as Lecet",
			"SUM(visual.Tipis) as Tipis",
			"SUM(visual.Meler) as Meler",
			"SUM(visual.Nyerep) as Nyerep",
			"SUM(visual.O_Peel) as O_Peel",
			"SUM(visual.Buram) as Buram",
			"SUM(visual.Over_Cut) as Over_Cut",

			"SUM(visual.Burry) as Burry",
			"SUM(visual.Belang) as Belang",
			"SUM(visual.Ngeflek) as Ngeflek",
			"SUM(visual.Minyak) as Minyak",
			"SUM(visual.Dustray) as Dustray",
			"SUM(visual.Cat_Kelupas) as Cat_Kelupas",
			"SUM(visual.Bintik_Air) as Bintik_Air",
			"SUM(visual.Finishing_Ng) as Finishing_Ng",
			
			"SUM(visual.Serat) as Serat",
			"SUM(visual.Demotograph) as Demotograph",
			"SUM(visual.Lifting) as Lifting",
			"SUM(visual.Kusam) as Kusam",
			"SUM(visual.Flow_Mark) as Flow_Mark",
			"SUM(visual.Legok) as Legok",
			"SUM(visual.Salah_Type) as Salah_Type",
			"SUM(visual.Getting) as Getting",

			"SUM(visual.Part_Campur) as Part_Campur",
			"SUM(visual.Sinmark) as Sinmark",
			"SUM(visual.Gores) as Gores",
			"SUM(visual.Gloss) as Gloss",
			"SUM(visual.Patah_Depan) as Patah_Depan",
			"SUM(visual.Patah_Belakang) as Patah_Belakang",
			"SUM(visual.Patah_Kanan) as Patah_Kanan",
			"SUM(visual.Patah_Kiri) as Patah_Kiri",

			"SUM(visual.Silver) as Silver",
			"SUM(visual.Burn_Mark) as Burn_Mark",
			"SUM(visual.Gores) as Gores",
			"SUM(visual.Weld_Line) as Weld_Line",
			"SUM(visual.Bubble) as Bubble",
			"SUM(visual.Black_Dot) as Black_Dot",
			"SUM(visual.White_Dot) as White_Dot",
			"SUM(visual.Isi_Tidak_Set) as Isi_Tidak_Set",

			"SUM(visual.Gompal) as Gompal",
			"SUM(visual.Salah_label) as Salah_label",
			"SUM(visual.Sobek_terkena_cutter) as Sobek_terkena_cutter",
			"SUM(visual.Terbentur) as Terbentur",
			"SUM(visual.Kereta) as Kereta",
			"SUM(visual.Terjatuh) as Terjatuh",
			"SUM(visual.Terkena_Gun) as Terkena_Gun",
			"SUM(visual.Sobek_Handling) as Sobek_Handling",

			"SUM(visual.Sobek_Staples) as Sobek_Staples",
			"SUM(visual.Staples_Lepas) as Staples_Lepas",
			"SUM(visual.Keriput) as Keriput",
			"SUM(visual.Seaming_Ng) as Seaming_Ng",
			"SUM(visual.Nonjol) as Nonjol",
			"SUM(visual.Seal_Lepas) as Seal_Lepas",
			"SUM(visual.Cover_Ng) as Cover_Ng",
			"SUM(visual.Belum_Finishing) as Belum_Finishing",
			"SUM(visual.Foam_Ng) as Foam_Ng",

			"SUM(non_visual.Deformasi) as Deformasi",
			"SUM(non_visual.Patah) as Patah",
			"SUM(non_visual.Part_Tidak_Lengkap) as Part_Tidak_Lengkap",
			"SUM(non_visual.Elector_Mark) as Elector_Mark",
			"SUM(non_visual.Short_Shot) as Short_Shot",
			"SUM(non_visual.Material_Asing) as Material_Asing",
			"SUM(non_visual.Pecah) as Pecah",
			"SUM(non_visual.Stay_Lepas) as Stay_Lepas",
			"SUM(non_visual.Salah_Ulir) as Salah_Ulir",
			
			"SUM(non_visual.Visual_TA) as Visual_TA",
			"SUM(non_visual.Ulir_Ng) as Ulir_Ng",
			"SUM(non_visual.Rubber_TA) as Rubber_TA",
			"SUM(non_visual.Hole_Ng) as Hole_Ng",
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->join('data_parts', 'claim_customer.id_part = data_parts.id_part', 'INNER');
		$this->db->join('visual', 'claim_customer.id_customer_claim = visual.id_customer_claim', 'INNER');
		$this->db->join('non_visual', 'claim_customer.id_customer_claim = non_visual.id_customer_claim', 'INNER');
		$this->db->where('data_parts.CUSTOMER', 1);
		$this->db->order_by("claim_customer.tgl_input", "ASC");

		if($status_claim != null) {
			$this->db->where('claim_customer.status_claim', $status_claim);
		}

		if($part != null && $start != null && $end != null) {
			$this->db->where("data_parts.NAMA_PART", $part);
			$this->db->where("claim_customer.tgl_input >= ", $start);
			$this->db->where("claim_customer.tgl_input <= ", $end);
			$query = $this->db->get();
			return $query->row();
		} 
		
		if($start != null && $end != null) {
			$this->db->where("claim_customer.tgl_input >= ", $start);
			$this->db->where("claim_customer.tgl_input <= ", $end);
			$query = $this->db->get();
			return $query->row();
		}

		if($part != null) {
			if($year != null && $month != null) {
				$this->db->where("data_parts.NAMA_PART", $part);
				$this->db->where("YEAR(claim_customer.tgl_input)", $year);
				$this->db->where("MONTH(claim_customer.tgl_input)", $month);
				$query = $this->db->get();
				return $query->row();
			} elseif ($year != null) {
				$this->db->where("data_parts.NAMA_PART", $part);
				$this->db->where('YEAR(claim_customer.tgl_input)', $year);
				$query = $this->db->get();
				return $query->row();
			} elseif($month != null) {
				$this->db->where("data_parts.NAMA_PART", $part);
				$this->db->where("MONTH(claim_customer.tgl_input)", $month);
				$query = $this->db->get();
				return $query->row();
			} else {
				$this->db->where("data_parts.NAMA_PART", $part);
				$this->db->where("claim_customer.tgl_input >= ", $start_by_all_part);
				$this->db->where("claim_customer.tgl_input <= ", $end_by_all_part);
				$query = $this->db->get();
				return $query->row();
			}
		} else {
			if($year != null && $month != null) {
				$this->db->where('YEAR(claim_customer.tgl_input)', $year);
				$this->db->where('MONTH(claim_customer.tgl_input)', $month);
				$query = $this->db->get();
				return $query->row();
			} elseif ($year != null) {
				$this->db->where('YEAR(claim_customer.tgl_input)', $year);
				$query = $this->db->get();
				return $query->row();
			} elseif ($month != null) {
				$this->db->where('MONTH(claim_customer.tgl_input)', $month);
				$query = $this->db->get();
				return $query->row();
			} else {
				if(!empty($get_customer_claim_sort_by_date)) {
					$this->db->where("claim_customer.tgl_input >= ", $start_by_all_part);
					$this->db->where("claim_customer.tgl_input <= ", $end_by_all_part);
					$query = $this->db->get();
					return $query->row();	
				}
			}

		}
		
	}

	public function chart_part_claim($start = null, $end = null, $year = null, $month = null, $status_claim = null) {
		$get_customer_claim_sort_by_date = $this->get_customer_claim_sort_by_date();
		if(!empty($get_customer_claim_sort_by_date)) {
			$start_all_part = $get_customer_claim_sort_by_date[0]->tgl_input;
			$end_all_part = $get_customer_claim_sort_by_date[count($get_customer_claim_sort_by_date)  - 1]->tgl_input;
			$start_by_all_part = date('Y-m-d', strtotime($start_all_part));
			$end_by_all_part = date('Y-m-d', strtotime($end_all_part));
		}
		$array_select = array(
			"data_parts.NAMA_PART",
			"SUM(visual.Kotor) as Kotor",
			"SUM(visual.Lecet) as Lecet",
			"SUM(visual.Tipis) as Tipis",
			"SUM(visual.Meler) as Meler",
			"SUM(visual.Nyerep) as Nyerep",
			"SUM(visual.O_Peel) as O_Peel",
			"SUM(visual.Buram) as Buram",
			"SUM(visual.Over_Cut) as Over_Cut",

			"SUM(visual.Burry) as Burry",
			"SUM(visual.Belang) as Belang",
			"SUM(visual.Ngeflek) as Ngeflek",
			"SUM(visual.Minyak) as Minyak",
			"SUM(visual.Dustray) as Dustray",
			"SUM(visual.Cat_Kelupas) as Cat_Kelupas",
			"SUM(visual.Bintik_Air) as Bintik_Air",
			"SUM(visual.Finishing_Ng) as Finishing_Ng",
			
			"SUM(visual.Serat) as Serat",
			"SUM(visual.Demotograph) as Demotograph",
			"SUM(visual.Lifting) as Lifting",
			"SUM(visual.Kusam) as Kusam",
			"SUM(visual.Flow_Mark) as Flow_Mark",
			"SUM(visual.Legok) as Legok",
			"SUM(visual.Salah_Type) as Salah_Type",
			"SUM(visual.Getting) as Getting",

			"SUM(visual.Part_Campur) as Part_Campur",
			"SUM(visual.Sinmark) as Sinmark",
			"SUM(visual.Gores) as Gores",
			"SUM(visual.Gloss) as Gloss",
			"SUM(visual.Patah_Depan) as Patah_Depan",
			"SUM(visual.Patah_Belakang) as Patah_Belakang",
			"SUM(visual.Patah_Kanan) as Patah_Kanan",
			"SUM(visual.Patah_Kiri) as Patah_Kiri",

			"SUM(visual.Silver) as Silver",
			"SUM(visual.Burn_Mark) as Burn_Mark",
			"SUM(visual.Gores) as Gores",
			"SUM(visual.Weld_Line) as Weld_Line",
			"SUM(visual.Bubble) as Bubble",
			"SUM(visual.Black_Dot) as Black_Dot",
			"SUM(visual.White_Dot) as White_Dot",
			"SUM(visual.Isi_Tidak_Set) as Isi_Tidak_Set",

			"SUM(visual.Gompal) as Gompal",
			"SUM(visual.Salah_label) as Salah_label",
			"SUM(visual.Sobek_terkena_cutter) as Sobek_terkena_cutter",
			"SUM(visual.Terbentur) as Terbentur",
			"SUM(visual.Kereta) as Kereta",
			"SUM(visual.Terjatuh) as Terjatuh",
			"SUM(visual.Terkena_Gun) as Terkena_Gun",
			"SUM(visual.Sobek_Handling) as Sobek_Handling",

			"SUM(visual.Sobek_Staples) as Sobek_Staples",
			"SUM(visual.Staples_Lepas) as Staples_Lepas",
			"SUM(visual.Keriput) as Keriput",
			"SUM(visual.Seaming_Ng) as Seaming_Ng",
			"SUM(visual.Nonjol) as Nonjol",
			"SUM(visual.Seal_Lepas) as Seal_Lepas",
			"SUM(visual.Cover_Ng) as Cover_Ng",
			"SUM(visual.Belum_Finishing) as Belum_Finishing",
			"SUM(visual.Foam_Ng) as Foam_Ng",

			"SUM(non_visual.Deformasi) as Deformasi",
			"SUM(non_visual.Patah) as Patah",
			"SUM(non_visual.Part_Tidak_Lengkap) as Part_Tidak_Lengkap",
			"SUM(non_visual.Elector_Mark) as Elector_Mark",
			"SUM(non_visual.Short_Shot) as Short_Shot",
			"SUM(non_visual.Material_Asing) as Material_Asing",
			"SUM(non_visual.Pecah) as Pecah",
			"SUM(non_visual.Stay_Lepas) as Stay_Lepas",
			"SUM(non_visual.Salah_Ulir) as Salah_Ulir",
			
			"SUM(non_visual.Visual_TA) as Visual_TA",
			"SUM(non_visual.Ulir_Ng) as Ulir_Ng",
			"SUM(non_visual.Rubber_TA) as Rubber_TA",
			"SUM(non_visual.Hole_Ng) as Hole_Ng",
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->join('data_parts', 'claim_customer.id_part = data_parts.id_part', 'INNER');
		$this->db->join('visual', 'claim_customer.id_customer_claim = visual.id_customer_claim', 'INNER');
		$this->db->join('non_visual', 'claim_customer.id_customer_claim = non_visual.id_customer_claim', 'INNER');
		$this->db->where('data_parts.CUSTOMER', 1);
		$this->db->group_by("data_parts.NAMA_PART");
		$this->db->order_by("claim_customer.tgl_input", "ASC");
		if($status_claim != null) {
			$this->db->where('claim_customer.status_claim', $status_claim);
		}
		if($start != null && $end != null) {
			$this->db->where("claim_customer.tgl_input >= ", $start);
			$this->db->where("claim_customer.tgl_input <= ", $end);
			$query = $this->db->get();
			return $query->result();
		}

		if($year != null && $month != null) {
			$this->db->where('YEAR(claim_customer.tgl_input)', $year);
			$this->db->where('MONTH(claim_customer.tgl_input)', $month);
			$query = $this->db->get();
			return $query->result();
		} elseif ($year != null) {
			$this->db->where('YEAR(claim_customer.tgl_input)', $year);
			$query = $this->db->get();
			return $query->result();
		} elseif ($month != null) {
			$this->db->where('MONTH(claim_customer.tgl_input)', $month);
			$query = $this->db->get();
			return $query->result();
		} else {
			if(!empty($get_customer_claim_sort_by_date)) {
				$this->db->where("claim_customer.tgl_input >= ", $start_by_all_part);
				$this->db->where("claim_customer.tgl_input <= ", $end_by_all_part);
				$query = $this->db->get();
				return $query->result();
			}
		}
	}

	public function rejection_per_year_month($year, $annual_status_claim, $customer) {
		$array_select = array(
			'claim_customer.*',
			'visual.*',
			'non_visual.*'
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->join('data_parts', 'claim_customer.id_part = data_parts.id_part', 'INNER');
		$this->db->join('visual', 'claim_customer.id_customer_claim = visual.id_customer_claim', 'INNER');
		$this->db->join('non_visual', 'claim_customer.id_customer_claim = non_visual.id_customer_claim', 'INNER');
		if($customer != null) {
			$this->db->where('data_parts.CUSTOMER', $customer);
		}
		if($annual_status_claim != null) {
			$this->db->where('claim_customer.status_claim', $annual_status_claim);
		}
		
		$this->db->where('YEAR(claim_customer.tgl_input)', $year);
		$query = $this->db->get();
		return $query->result();
	}

	public function montly_rejection($year, $month, $monthly_status_claim, $customer) {
		$array_select = array(
			'claim_customer.*',
			'visual.*',
			'non_visual.*'
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->join('data_parts', 'claim_customer.id_part = data_parts.id_part', 'INNER');
		$this->db->join('visual', 'claim_customer.id_customer_claim = visual.id_customer_claim', 'INNER');
		$this->db->join('non_visual', 'claim_customer.id_customer_claim = non_visual.id_customer_claim', 'INNER');
		if($customer != null) {
			$this->db->where('data_parts.CUSTOMER', $customer);
		}
		if($monthly_status_claim != null) {
			$this->db->where('claim_customer.status_claim', $monthly_status_claim);
		}
		$this->db->where('YEAR(claim_customer.tgl_input)', $year);
		$this->db->where('MONTH(claim_customer.tgl_input)', $month);
		$query = $this->db->get();
		return $query->result();
	}
}

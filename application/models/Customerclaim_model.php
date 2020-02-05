<?php
class Customerclaim_model extends CI_Model {

	private $table = 'claim_customer';

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
		$this->db->join('data_parts', 'data_parts.ID_PART = claim_customer.id_part', 'INNER');
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
		$this->db->join('data_parts', 'data_parts.ID_PART = claim_customer.id_part', 'INNER');
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
		$this->db->join("claim_customer", "data_parts.ID_PART = claim_customer.id_part", "INNER");
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
		$this->db->join('data_parts', 'data_parts.ID_PART = claim_customer.id_part', 'INNER');
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

	public function chart_rejection_claim($start = null, $end = null, $part = null, $year = null, $month = null) {
		$get_customer_claim_sort_by_date = $this->get_customer_claim_sort_by_date();
		$start_all_part = $get_customer_claim_sort_by_date[0]->tgl_input;
		$end_all_part = $get_customer_claim_sort_by_date[count($get_customer_claim_sort_by_date)  - 1]->tgl_input;
		$start_by_all_part = date('Y-m-d', strtotime($start_all_part));
		$end_by_all_part = date('Y-m-d', strtotime($end_all_part));
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
		$this->db->join('data_parts', 'claim_customer.id_part = data_parts.ID_PART', 'INNER');
		$this->db->join('visual', 'claim_customer.id_customer_claim = visual.id_customer_claim', 'INNER');
		$this->db->join('non_visual', 'claim_customer.id_customer_claim = non_visual.id_customer_claim', 'INNER');
		$this->db->where('data_parts.CUSTOMER', 1);
		$this->db->order_by("claim_customer.tgl_input", "ASC");

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
				$this->db->where("claim_customer.tgl_input >= ", $start_by_all_part);
				$this->db->where("claim_customer.tgl_input <= ", $end_by_all_part);
				$query = $this->db->get();
				return $query->row();
			}

		}
		
	}

	public function chart_part_claim($start = null, $end = null, $year = null, $month = null) {
		$get_customer_claim_sort_by_date = $this->get_customer_claim_sort_by_date();
		$start_all_part = $get_customer_claim_sort_by_date[0]->tgl_input;
		$end_all_part = $get_customer_claim_sort_by_date[count($get_customer_claim_sort_by_date)  - 1]->tgl_input;
		$start_by_all_part = date('Y-m-d', strtotime($start_all_part));
		$end_by_all_part = date('Y-m-d', strtotime($end_all_part));
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
		$this->db->join('data_parts', 'claim_customer.id_part = data_parts.ID_PART', 'INNER');
		$this->db->join('visual', 'claim_customer.id_customer_claim = visual.id_customer_claim', 'INNER');
		$this->db->join('non_visual', 'claim_customer.id_customer_claim = non_visual.id_customer_claim', 'INNER');
		$this->db->where('data_parts.CUSTOMER', 1);
		$this->db->group_by("data_parts.NAMA_PART");
		$this->db->order_by("claim_customer.tgl_input", "ASC");
		
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
			$this->db->where("claim_customer.tgl_input >= ", $start_by_all_part);
			$this->db->where("claim_customer.tgl_input <= ", $end_by_all_part);
			$query = $this->db->get();
			return $query->result();
		}
	}

	public function rejection_per_year_month($year) {
		$array_select = array(
			'claim_customer.*',
			'visual.*',
			'non_visual.*'
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->join('data_parts', 'claim_customer.id_part = data_parts.ID_PART', 'INNER');
		$this->db->join('visual', 'claim_customer.id_customer_claim = visual.id_customer_claim', 'INNER');
		$this->db->join('non_visual', 'claim_customer.id_customer_claim = non_visual.id_customer_claim', 'INNER');
		$this->db->where('data_parts.CUSTOMER', 1);
		$this->db->where('YEAR(claim_customer.tgl_input)', $year);
		$query = $this->db->get();
		return $query->result();
	}

	public function montly_rejection($year, $month) {
		$array_select = array(
			'claim_customer.*',
			'visual.*',
			'non_visual.*'
		);
		$this->db->select($array_select);
		$this->db->from($this->table);
		$this->db->join('data_parts', 'claim_customer.id_part = data_parts.ID_PART', 'INNER');
		$this->db->join('visual', 'claim_customer.id_customer_claim = visual.id_customer_claim', 'INNER');
		$this->db->join('non_visual', 'claim_customer.id_customer_claim = non_visual.id_customer_claim', 'INNER');
		$this->db->where('data_parts.CUSTOMER', 1);
		$this->db->where('YEAR(claim_customer.tgl_input)', $year);
		$this->db->where('MONTH(claim_customer.tgl_input)', $month);
		$query = $this->db->get();
		return $query->result();
	}
}

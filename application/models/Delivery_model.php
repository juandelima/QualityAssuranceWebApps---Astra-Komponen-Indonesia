<?php
class Delivery_model extends CI_Model {

	private $table = 'delivery';

	public function save_delivery($tgl, $qty) {
		$data = array(
			'tgl_delivery' => $tgl,
			'qty' => $qty
		);
		$result = $this->db->insert($this->table, $data);
		return $result;
	}

	public function listing_deliv() {
		$this->db->select('*');
		$this->db->from($this->table);
		$query = $this->db->get();
		return $query->result();
	}

	public function monthly_ppm($tahun, $bulan) {
		// $array_select = array(
		// 	'SUM(qty) as total_qty',
		// );
		// $this->db->select($array_select);
		// $this->db->from($this->table);
		// $this->db->where('YEAR(tgl_delivery)', $tahun);
		// $this->db->where('MONTH(tgl_delivery)', $bulan);
		// $query = $this->db->get();
		// return $query->row();
		$query = $this->db->query("select sum(qty) as total_qty from $this->table where extract(YEAR from tgl_delivery
		) = $tahun and extract(MONTH from tgl_delivery) = $bulan");
		return $query->row();
	}

	public function annual_ppm($tahun) {
		// $array_select = array(
		// 	'SUM(qty) as total_qty',
		// );
		// $this->db->select($array_select);
		// $this->db->from($this->table);
		// $this->db->where('YEAR(tgl_delivery)', $tahun);
		// $query = $this->db->get();
		// return $query->row();
		$query = $this->db->query("select sum(qty) as total_qty from $this->table where extract(YEAR from tgl_delivery
		) = $tahun");
		return $query->row();
	}

}

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


	public function update_delivery($data) {
		$this->db->set('qty', $data['qty']);
		$this->db->where('id_delivery', $data['id_delivery']);
		$result = $this->db->update($this->table);
		return $result;
	}

	public function delete_delivery($id_delivery) {
		$this->db->where('id_delivery', $id_delivery);
		$result = $this->db->delete($this->table);
		return $result;
	}

	public function listing_deliv() {
		$this->db->select('*');
		$this->db->from($this->table);
		$query = $this->db->get();
		return $query->result();
	}

	public function monthly_ppm($tahun, $bulan) {
		$query = $this->db->query("select sum(qty) as total_qty from $this->table where extract(YEAR from tgl_delivery
		) = $tahun and extract(MONTH from tgl_delivery) = $bulan");
		return $query->row();
	}

	public function annual_ppm($tahun) {
		$query = $this->db->query("select sum(qty) as total_qty from $this->table where extract(YEAR from tgl_delivery
		) = $tahun");
		return $query->row();
	}

	public function daily_ppm($tanggal) {
		$year = date('Y', strtotime($tanggal));
		$month = date('m', strtotime($tanggal));
		$day = date('d', strtotime($tanggal));
		$query = $this->db->query("select sum(qty) as total_qty from $this->table where extract(YEAR from tgl_delivery
		) = $year AND extract(MONTH from tgl_delivery) = $month AND extract(DAY from tgl_delivery) = $day
		ORDER BY STR_TO_DATE(tgl_delivery,'%d-%m-%Y') ASC");
		return $query->row();
	}

}

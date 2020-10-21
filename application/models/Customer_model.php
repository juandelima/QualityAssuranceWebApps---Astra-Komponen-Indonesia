<?php
class Customer_model extends CI_Model {

	private $table = 'customer';

	public function __construct() {
        parent::__construct();
        $this->load->database();
	}
	
	public function testing() {
		for($i = 0; $i < 100; $i++) {
			$data = array(
				'nama_customer' => "AHM {$i}",
			);
			$this->db->insert($this->table, $data);
		}
	}

	
	public function customer_list() {
		$data = $this->db->get('customer');
		return $data->result();
	}

	public function save_customer($nama_customer) {
		$data = array(
			'nama_customer' => $nama_customer,
		);
		$result = $this->db->insert($this->table, $data);
		return $result;
	}

	public function search_customer($nama_customer) {
		$this->db->like('nama_customer', $nama_customer, 'both');
		$this->db->order_by('nama_customer', 'ASC');
		$this->db->limit(10);
		$query = $this->db->get($this->table);
		return $query->result();
	}

	public function check_exist_customer($nama_customer) {
		$this->db->where('nama_customer', $nama_customer);
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function update_customer() {
		$data = array(
			'id_customer' => $this->input->post('id_customer'),
			'nama_customer' => $this->input->post('nama_customer'),
		);
		$this->db->set('nama_customer', $data['nama_customer']);
		$this->db->where('id_customer', $data['id_customer']);
		$result = $this->db->update($this->table);
		return $result;
	}

	public function delete_customer() {
		$data = array(
			'id_customer' => $this->input->post('id_customer')
		);

		$this->db->where('id_customer', $data['id_customer']);
		$result = $this->db->delete($this->table);
		return $result;
	}

	public function update_visual_nonvisual($id_customer, $total) {
		$this->db->set('total_visual_and_nonvisual', $total);
		$this->db->where('id_customer', $id_customer);
		$this->db->update($this->table);
	}

	public function getCustomer($id_customer) {{
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('id_customer', $id_customer);
		$result = $this->db->get();
		return $result->row();
	}}
}

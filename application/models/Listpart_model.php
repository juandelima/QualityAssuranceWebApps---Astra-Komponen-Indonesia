<?php
class Listpart_model extends CI_Model {

	private $table = 'list_part';

	public function __construct() {
		parent::__construct();
		
        $this->load->database();
	}

	public function get_data_part() {
		$query_array = array(
			'data_parts.*',
			'customer.nama_customer as nama_customer'
		);

		$this->db->select($query_array);
		$this->db->from('data_parts');
		$this->db->join('customer', 'customer.id_customer = data_parts.CUSTOMER', 'inner');
		$this->db->order_by('id_part', 'desc');
		$data = $this->db->get();
		return $data->result();
	}

	public function list_part() {
		$query_array = array(
			'list_part.*',
			'customer.nama_customer as customer_name'
		);

		$this->db->select($query_array);
		$this->db->from($this->table);
		$this->db->join('customer', 'customer.id_customer = list_part.id_customer', 'inner');
		$this->db->order_by('id_part', 'desc');
		$data = $this->db->get();
		return $data->result();
	}

	public function search_no_sap($no_sap){
        $this->db->like('NO_SAP', $no_sap , 'both');
        $this->db->order_by('NO_SAP', 'ASC');
        $this->db->limit(10);
        return $this->db->get('data_parts')->result();
	}
	
	public function search_dataPart_by_noSap($no_sap) {
		$this->db->select("*");
		$this->db->from('data_parts');
		$this->db->where('NO_SAP', $no_sap);
		$query = $this->db->get();
		return $query->result();
	}

	public function save_part($data) {
		$this->db->insert($this->table, $data);
	}

	public function save_new_part($data) {
		$this->db->insert('data_parts', $data);
	}

	public function edit_part($id_part) {
		$this->db->select("*");
		$this->db->from("list_part");
		$this->db->where('id_part', $id_part);
		$query = $this->db->get();
		return $query->row();
	}

	public function update_part($data) {
		$this->db->where('id_part', $data['id_part']);
		$this->db->update('list_part', $data);
	}

	public function delete_part($id_part) {
		$this->db->where('id_part', $id_part);
		$this->db->delete('list_part');
	}
}

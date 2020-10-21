<?php
class Aktivitas_model extends CI_Model {
	private $table = 'aktivitas_user';

	public function __construct() {
        parent::__construct();
		$this->load->database();
    }

    public function listing_aktivitas() {
        $array_select = array(
            'aktivitas_user.*',
            'users.*'
        );
        $this->db->select($array_select);
        $this->db->from($this->table);
        $this->db->join("users", "users.id_users = aktivitas_user.id_user", "inner");
        $this->db->order_by("id_aktivitas", "DESC");
        $data = $this->db->get();
        return $data->result();
    }

    public function last_record() {
        $array_select = array(
            'aktivitas_user.*',
            'users.*'
        );
        $this->db->select($array_select);
        $this->db->from($this->table);
        $this->db->join("users", "users.id_users = aktivitas_user.id_user", "inner");
        $this->db->order_by('id_aktivitas','desc');
        $data = $this->db->get();
        return $data->row();
    }

    public function save_aktivitas($data) {
        $this->db->insert($this->table, $data);
    }
}
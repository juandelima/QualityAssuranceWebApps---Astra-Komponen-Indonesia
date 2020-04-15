<?php
class Chat_model extends CI_Model {

	private $table = 'chat';

	public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function save_message($data) {
        $query = $this->db->insert($this->table, $data);
        return $query;
    }

    public function get_last_record() {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->order_by("id_chat", "DESC");
        $query = $this->db->get();
        return $query->row();
    }
    
    public function history_message($id_receiver, $id_from) {
        $query = $this->db->query("select * from $this->table
        where (id_receiver = $id_receiver and id_from = $id_from) 
        or (id_receiver = $id_from and id_from = $id_receiver) order by id_chat asc");
        return $query->result();
    }

    public function update_unread($data) {
        $this->db->set('unread', 0);
        $this->db->where('id_receiver', $data['id_receiver']);
        $this->db->where('id_from', $data['id_from']);
        $query = $this->db->update($this->table);
        return $query;
    }

    public function all_messages($id_receiver) {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where('id_receiver', $id_receiver);
        $this->db->order_by('id_chat', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
}
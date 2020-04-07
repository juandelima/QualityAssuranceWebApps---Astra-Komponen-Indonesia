<?php
class User_model extends CI_Model {
	private $table = 'users';

	public function __construct() {
        parent::__construct();
		$this->load->database();
	}

	public function list_user() {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->order_by('id_users','desc');
		$data = $this->db->get();
		return $data->result();
	}
	
	public function data_dummy() {
		date_default_timezone_set("Asia/Jakarta");
		$data = array(
			'photo' => 'member-1.jpg',
			'full_name' => 'Juan Valerian Delima',
			'username' => 'juanvaleriand',
			'role' => 'Super Admin',
			'password' => password_hash('admin123', PASSWORD_DEFAULT),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);
		$result = $this->db->insert($this->table, $data);
		return $result;
	}	

	
	public function cek_username($username) {
		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('username',$username);
        $this->db->order_by('id_users','desc');
        $query = $this->db->get();
        return $query->row();
	}

	public function update($data) {
		$this->db->set('updated_at', $data['updated_at']);
		$this->db->where('id_users', $data['id_users']);
		$this->db->update($this->table);
	}

	public function update_status_online($data) {
		$this->db->set('online', $data['online']);
		$this->db->where('id_users', $data['id_users']);
		$this->db->update($this->table);
	}

	public function get_username($username) {
		$this->db->where('username', $username);  
        $query = $this->db->get($this->table);  
        if($query->num_rows() > 0) {  
        	return TRUE;  
        } else {  
            return FALSE;  
        }  
	}

	public function get_old_password($id_user) {
		$this->db->select("*");
		$this->db->from("reset_password");
		$this->db->where("id_user", $id_user);
		$query = $this->db->get();
		return $query->row();
	}

	public function reset_password_user($data) {
		$this->db->set('password', $data['password']);
		$this->db->where('id_users', $data['id_users']);
		$this->db->update($this->table);
	}


	public function save($data) {
		$this->db->insert('users', $data);
	}

	public function edit_user($id_user) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where("id_users", $id_user);
		$this->db->order_by("id_users", "DESC");
		$query = $this->db->get();
		return $query->row();
	}

	public function update_user($data) {
		$this->db->where("id_users", $data['id_users']);
		$this->db->update($this->table, $data);
	}

	public function reset_password($data) {
		$this->db->insert('reset_password', $data);
	}

	public function delete_user($id_user) {
		$this->db->where("id_users", $id_user);
		$this->db->delete($this->table);
	}
}

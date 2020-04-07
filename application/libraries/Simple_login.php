<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simple_login {
    protected $CI;

    public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->helper('text');
		$this->CI->load->model('user_model');
	}

	public function doLogin($username, $password) {
		$user = $this->CI->user_model->cek_username($username);
		if(!empty($user)) {
			$hashed = $user->password;
			if(password_verify($password,$hashed)) {
				$id_user = $user->id_users;
				$photo = $user->photo;
				$fullname = $user->full_name;
				$username = $user->username;
				$role = $user->role;
				$session_data = array(
					'id_users' => $id_user,
					'photo' => $photo,
					'full_name' => $fullname,
					'username' => $username,
					'role' => $role
				);

				$this->CI->session->set_userdata($session_data);
				date_default_timezone_set("Asia/Jakarta");
				$update_LastLogin = array(
					'id_users' => $user->id_users,
					'updated_at' => date('Y-m-d H:i:s')
				);

				$update_statusOnline = array(
					'id_users' => $user->id_users,
					"online" => "1",
				);

				$this->CI->user_model->update($update_LastLogin);
				$this->CI->user_model->update_status_online($update_statusOnline);
				$this->CI->session->set_flashdata('success','<b>Selamat Datang '.$user->full_name.' :)</b>');
				redirect(base_url('dashboard'), 'refresh');
			} else {
				$this->CI->session->set_flashdata('warning','Password Anda salah');
			}
		} else {
			$this->CI->session->set_flashdata('warning','Username Anda salah');
		}
	}

	public function loged() {
        if(!empty($this->CI->session->userdata('username'))){
            redirect(base_url('dashboard'),'refresh');
        }
	}
	
	public function cek_login() {
		if($this->CI->session->userdata('username') == ""){
            $this->CI->session->set_flashdata('warning', 'Harap Login Terlebih Dahulu');
            redirect(base_url('login'),'refresh');
        }
	}

	public function logout() {
		//membuang semua session yang telah di set pada saat login
		$id_user = $this->CI->session->userdata('id_users');
		$update_statusOnline = array(
			'id_users' => $id_user,
			"online" => "0",
		);
		$this->CI->user_model->update_status_online($update_statusOnline);
        $this->CI->session->unset_userdata('id_users');
        $this->CI->session->unset_userdata('username');
        $this->CI->session->unset_userdata('full_name');
		$this->CI->session->unset_userdata('photo');
		$this->CI->session->unset_userdata('password');
        //setelah session di buang, maka redirect ke login
        $this->CI->session->set_flashdata('success','Anda berhasil logout!');
        redirect(base_url('login'),'refresh');
	}
	
	public function logout_changePassword() {
        //membuang semua session yang telah di set pada saat login
        $this->CI->session->unset_userdata('id_users');
        $this->CI->session->unset_userdata('username');
        $this->CI->session->unset_userdata('full_name');
		$this->CI->session->unset_userdata('photo');
		$this->CI->session->unset_userdata('password');
        //setelah session di buang, maka redirect ke login
        $this->CI->session->set_flashdata('success','ANDA TELAH MENGUBAH PASSWORD. SILAHKAN LOGIN KEMBALI');
        redirect(base_url('login'),'refresh');
    }
}

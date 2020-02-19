<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url');
	}
	
	public function insert() {
		$this->user_model->data_dummy();
	}

	
	public function index() {
		$slug = $this->uri->segment(2);
		$data_user = $this->user_model->list_user();
		$data = array(
			'users' => $data_user,
			'slug' => $slug
		);
		$this->load->view('user/index', $data);
	}

	public function create() {
		$slug = $this->uri->segment(3);
		$data = array(
			'slug' => $slug
		);
		$this->load->view('user/create', $data);
	}

	public function get_username_availability() {
		if(isset($_POST['username'])) {
			$username = $_POST['username'];
			$result = $this->user_model->get_username($username);
			if($result === TRUE) {
				echo '<span style="color:red;">Username sudah digunakan!</span>';
			} else {
				echo ' ';
			}
		} else {
			echo '<span style="color:red;">Username tidak boleh kosong!.</span>';
		}
	}

	public function change_username_whenLoged($id_user) {
		if(isset($_POST['username'])) {
			$username = $_POST['username'];
			$get_user = $this->user_model->edit_user($id_user);
			$cek_username = $this->user_model->get_username($username);
			if($get_user->username === $username) {
				echo ' ';
			} else {
				if($cek_username === TRUE) {
					echo '<span style="color:red;">Username sudah digunakan!</span>';
				} else {
					echo ' ';
				}
			}
		} else {
			echo '<span style="color:red;">Username tidak boleh kosong!.</span>';
		}
	}

	public function cek_old_password($id_user) {
		if(isset($_POST['old_password'])) {
			$old_password = $_POST['old_password'];
			$get_user = $this->user_model->edit_user($id_user);
			$get_old_password = $get_user->password;
			if(!empty($get_user)) {
				if(password_verify($old_password, $get_old_password)) {
					echo '<span style="color:green;">OLD PASSWORD IS CORRECT!</span>';
				} else {
					echo '';
				}
			}
		}
	}

	public function tambah() {
		$valid = $this->form_validation;
		$valid->set_rules('full_name', 'FULL NAME', 'required',
		array('required' => '%s harus diisi'));
		$valid->set_rules('username', 'USERNAME', 'required',
		array('required' => '%s harus diisi'));
		$valid->set_rules('role', 'ROLE', 'required',
		array('required' => '%s harus diisi'));
		$valid->set_rules('password', 'PASSWORD', 'required',
		array('required' => '%s harus diisi'));

		if($valid->run()) {
			$this->load->library('upload');
			$config = array(
				'upload_path' => './assets/images/foto_profile/',
				'allowed_types' => 'gif|jpg|png|jpeg|pdf',
				'file_name'	=> 'Foto Profile - '.$this->input->post('full_name')
			); 
			$this->upload->initialize($config);
			if($this->upload->do_upload('photo')) {
				$upload_photo = array('upload_photo' => $this->upload->data());
				$configFoto = array(
					'source_image' => './assets/images/foto_profile/'.$upload_photo['upload_photo']['file_name'],
				);
				$this->load->library('image_lib', $configFoto);
				$photo = $upload_photo['upload_photo']['file_name'];
			} else {
				$photo = null;
			}

			$data = array(
				'photo' => $photo,
				'full_name' => $this->input->post('full_name'),
				'username' => $this->input->post('username'),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'role' => $this->input->post('role'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			);
			$this->user_model->save($data);
			// $get_user = $this->user_model->list_user();
			// $get_pass = $this->user_model->edit_user($get_user[0]->id_users);
			// $data_reset = array(
			// 	'password' => $get_pass->password,
			// 	'id_user' => $get_pass->id_users
			// );
			// $this->user_model->reset_password($data_reset);
			$this->session->set_flashdata('sukses', 'USER '.strtoupper($data['full_name']).' BERHASIL DITAMBAHKAN!');
			redirect(base_url('datauser/user'), 'refresh');
		}
	}

	public function edit_profile($id_user) {
		$slug = $this->uri->segment(2);
		$user = $this->user_model->edit_user($id_user);
		$valid = $this->form_validation;
		$valid->set_rules('username', 'USERNAME', 'required',
		array('required' => '%s harus diisi'));
		$valid->set_rules('full_name', 'FULL_NAME', 'required',
		array('required' => '%s harus diisi'));
		
		
		if($valid->run()) {
			
			date_default_timezone_set("Asia/Jakarta");
			$this->load->library('upload');
			$config = array(
				'upload_path' => './assets/images/foto_profile/',
				'allowed_types' => 'gif|jpg|png|jpeg|pdf',
				'file_name'	=> 'Foto Profile - '.$this->input->post('full_name')
			);
			$this->upload->initialize($config);
			if($this->upload->do_upload('photo')) {
				unlink('./assets/images/foto_profile/'.$user->photo);
				$upload_photo = array('upload_photo' => $this->upload->data());
				$configFoto = array(
					'source_image' => './assets/images/foto_profile/'.$upload_photo['upload_photo']['file_name'],
				);
				$this->load->library('image_lib', $configFoto);
				$photo = $upload_photo['upload_photo']['file_name'];
			} else {
				$photo = $user->photo;
			}
			// CEK USERNAME
			$username = $this->input->post('username');
			$check_username = $this->user_model->get_username($username);

			if($check_username === TRUE) {
				if($username != $user->username) {
					if($check_username === TRUE) {
						$this->session->set_flashdata('error', 'USERNAME SUDAH DIGUNAKAN!');
						redirect(base_url('datauser/user/edit_profile/'.$id_user), 'refresh');
					}
					
				}
				
			} 

			// CEK PASSWORD
			$old_password = $this->input->post('old_password');
			$confirm_pass = $this->input->post('password_confirmation');
			if($old_password != NULL) {
				if(password_verify($old_password, $user->password)) {
					 $new_password = $this->input->post('password');
					 if($new_password != $confirm_pass) {
						$this->session->set_flashdata('error', 'KONFIRMASI PASSWORD HARUS SAMA DENGAN PASSWORD BARU ATAU SEBALIKNYA!');
						redirect(base_url('datauser/user/edit_profile/'.$id_user), 'refresh');
					 }
				} else {
					$this->session->set_flashdata('error', 'PASSWORD LAMA SALAH!');
					redirect(base_url('datauser/user/edit_profile/'.$id_user), 'refresh');
				} 	
				$data = array(
					'id_users' => $id_user,
					'photo' => $photo,
					'full_name' => $this->input->post('full_name'),
					'username' => $this->input->post('username'),
					'password' => password_hash($new_password, PASSWORD_DEFAULT),
					'role' => $this->input->post('role'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				);
				$this->user_model->update_user($data);
				$this->simple_login->logout_changePassword();
			} else {
				$data = array(
					'id_users' => $id_user,
					'photo' => $photo,
					'full_name' => $this->input->post('full_name'),
					'username' => $this->input->post('username'),
					'role' => $this->input->post('role'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				);
				$session_data = array(
					'photo' => $data['photo'],
					'full_name' => $data['full_name'],
					'username' => $data['username'],
					'role' => $data['role']
				);

				if($this->session->userdata['id_users'] != $user->id_users) {
					$this->user_model->update_user($data);
				} else {
					$this->session->set_userdata($session_data);
					$this->user_model->update_user($data);
				}
				$this->session->set_flashdata('success', 'PROFILE ANDA TELAH DIUPDATE!');
				redirect(base_url(), 'refresh');
			}
		}

		$get_data = array(
			'user' => $user,
			'slug' => $slug
		);
		$this->load->view('user/edit_profile', $get_data);	
	}

	public function edit($id_user) {
		$slug = $this->uri->segment(2);
		$user = $this->user_model->edit_user($id_user);
		$valid = $this->form_validation;
		$valid->set_rules('full_name', 'FULL NAME', 'required',
		array('required' => '%s harus diisi'));
		$valid->set_rules('username', 'USERNAME', 'required',
		array('required' => '%s harus diisi'));
		$valid->set_rules('role', 'ROLE', 'required',
		array('required' => '%s harus diisi'));

		if($valid->run()) {
			date_default_timezone_set("Asia/Jakarta");
			$this->load->library('upload');
			$config = array(
				'upload_path' => './assets/images/foto_profile/',
				'allowed_types' => 'gif|jpg|png|jpeg|pdf',
				'file_name'	=> 'Foto Profile - '.$this->input->post('full_name')
			);
			$this->upload->initialize($config);
			if($this->upload->do_upload('photo')) {
				unlink('./assets/images/foto_profile/'.$user->photo);
				$upload_photo = array('upload_photo' => $this->upload->data());
				$configFoto = array(
					'source_image' => './assets/images/foto_profile/'.$upload_photo['upload_photo']['file_name'],
				);
				$this->load->library('image_lib', $configFoto);
				$photo = $upload_photo['upload_photo']['file_name'];
			} else {
				$photo = $user->photo;
			}
			
			// CEK USERNAME
			$username = $this->input->post('username');
			$check_username = $this->user_model->get_username($username);

			if($check_username === TRUE) {
				if($username != $user->username) {
					if($check_username === TRUE) {
						$this->session->set_flashdata('error', 'USERNAME SUDAH DIGUNAKAN!');
						redirect(base_url('datauser/user/edit_profile/'.$id_user), 'refresh');
					}
					
				}
				
			} 

			if($this->input->post('old_password') != NULL) {
				$data = array(
					'id_users' => $id_user,
					'photo' => $photo,
					'full_name' => $this->input->post('full_name'),
					'username' => $this->input->post('username'),
					'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
					'role' => $this->input->post('role'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				);
				$this->user_model->update_user($data);
				$this->simple_login->logout_changePassword();
			} else {
				$data = array(
					'id_users' => $id_user,
					'photo' => $photo,
					'full_name' => $this->input->post('full_name'),
					'username' => $this->input->post('username'),
					'role' => $this->input->post('role'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				);
				$session_data = array(
					'id_users' => $data['id_users'],
					'photo' => $data['photo'],
					'full_name' => $data['full_name'],
					'username' => $data['username'],
					'role' => $data['role']
				);

				if($this->session->userdata['id_users'] != $user->id_users) {
					$this->user_model->update_user($data);
				} else {
					$this->session->set_userdata($session_data);
					$this->user_model->update_user($data);
				}
				$this->session->set_flashdata('sukses', 'DATA USER '.strtoupper($data['full_name']).' BERHASIL DIUPDATE!');
				redirect(base_url('datauser/user'), 'refresh');
			}

		}

		$get_data = array(
			'user' => $user,
			'slug' => $slug
		);
		$this->load->view('user/edit', $get_data);		
	}

	public function reset_password($id_user) {
		$get_name = $this->user_model->edit_user($id_user);
		$get_old_pass = $this->user_model->get_old_password($id_user);
		$data = array(
			'id_users' => $get_old_pass->id_user,
			'full_name' => $get_name->full_name,
			'password' => $get_old_pass->password
		);
		$this->user_model->reset_password_user($data);
		$this->session->set_flashdata('sukses', 'PASSWORD USER '.strtoupper($data['full_name']).' BERHASIL DIRESET!');
		redirect(base_url('datauser/user'), 'refresh');
	}

	public function delete($id_user) {
		$user = $this->user_model->edit_user($id_user);
		$delete_session_user = array(
			'id_users' => $user->id_users,
			'username' => $user->username,
			'full_name' => $user->full_name,
			'photo' => $user->photo,
			'password' => $user->password
		);
		unlink('./assets/images/foto_profile/'.$user->photo);
		$this->session->unset_userdata($delete_session_user);
		$this->user_model->delete_user($id_user);
		$this->session->set_flashdata('hapus', 'DATA USER '.strtoupper($delete_session_user['full_name']).' TELAH DIHAPUS!');
		redirect(base_url('datauser/user'), 'refresh');		
	}
}

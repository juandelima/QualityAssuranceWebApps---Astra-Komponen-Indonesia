<?php

use SebastianBergmann\Environment\Console;

defined('BASEPATH') OR exit('No direct script access allowed');

class Comingsoon extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('aktivitas_model');
		$this->load->helper('url');
	}

	public function index() {
		$listing_user = $this->user_model->list_user();
		$count_user = count($listing_user) - 1;
		$slug = $this->uri->segment(1);
		$get_data_aktivitas = $this->aktivitas_model->listing_aktivitas();
		$count_aktivitas = count($get_data_aktivitas);
		$data = array(
			'slug' => $slug,
			'count_user' => $count_user,
			'count_aktivitas' => $count_aktivitas
		);
		$this->load->view('coming_soon', $data);
	}
}

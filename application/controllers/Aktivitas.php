<?php

use SebastianBergmann\Environment\Console;

defined('BASEPATH') OR exit('No direct script access allowed');

class Aktivitas extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('aktivitas_model');
		$this->load->helper('date');
		$this->load->helper('url');
    }

    public function index() {
        $slug = $this->uri->segment(1);
		$listing_user = $this->user_model->list_user();
		$get_data_aktivitas = $this->aktivitas_model->listing_aktivitas();
		$count_aktivitas = count($get_data_aktivitas);
        $count_user = count($listing_user) - 1;
        $data = array(
            "count_user" => $count_user,
			"slug" => $slug,
			"count_aktivitas" => $count_aktivitas
        );
        $this->load->view("aktivitas_user/index", $data);
    }

    public function get_data_aktivitas() {
		$get_data = $this->aktivitas_model->listing_aktivitas();
		$last_record = $this->aktivitas_model->last_record();
		$count_aktivitas = count($get_data);
		$data = array(
			'data_aktivitas' => $get_data,
			'count_aktivitas' => $count_aktivitas,
			'last_record' => $last_record,
		);
        echo json_encode($data);
    }
}
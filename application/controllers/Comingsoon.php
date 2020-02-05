<?php

use SebastianBergmann\Environment\Console;

defined('BASEPATH') OR exit('No direct script access allowed');

class Comingsoon extends CI_Controller {
	public function index() {
		$this->load->helper('url');
		$slug = $this->uri->segment(1);
		$data = array(
			'slug' => $slug,
		);
		$this->load->view('coming_soon', $data);
	}
}

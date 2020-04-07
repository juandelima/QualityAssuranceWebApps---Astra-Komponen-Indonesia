<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Chat extends CI_Controller {
  
    function __construct() {
      parent::__construct();
      $this->load->model('User_model');
      $this->load->helper('date');
      $this->load->helper('url');
    }
    
    public function get_users() {
      $get_user = $this->user_model->list_user();
      echo json_encode($get_user);
    }
}
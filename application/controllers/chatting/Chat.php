<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Chat extends CI_Controller {
  
    function __construct() {
      parent::__construct();
      $this->load->model('user_model');
      $this->load->model('chat_model');
      $this->load->helper('date');
      $this->load->helper('url');
    }
    
    public function get_users() {
      $get_user = $this->user_model->list_user();
      echo json_encode($get_user);
    }


    public function sender_message() {
        $receiver = $this->input->post('receiver');
        $message = $this->input->post('message');
        $from = $this->input->post('from');
        $time = $this->input->post('time');
        $fromOpponent = $this->input->post('fromOpponent');
        $unread = $this->input->post('unread');
        $data = array(
          "id_receiver" => $receiver,
          "message" => $message,
          "id_from" => $from,
          "time" => $time,
          "fromOpponent" => $fromOpponent,
          "unread" => $unread
        );

        $save_message = $this->chat_model->save_message($data);

        if($save_message) {
          $get_message = $this->chat_model->get_last_record();
          echo json_encode($get_message);
        }
    }

    public function receiver_message() {

    }

    public function history_message() {
      $id_receiver = $this->input->get('id_receiver');
      $id_from = $this->input->get('from');
      if($id_receiver != null) {
        $history_message = $this->chat_model->history_message($id_receiver, $id_from);
        $count_history_message = count($history_message);
        $list_user = $this->user_model->list_user();
        $data = array(
          'list_user' => $list_user,
          'history_message' => $history_message,
          'count_history_message' => $count_history_message
        );
        echo json_encode($data);
      } else {
        echo json_encode(false);
      }
    }

    public function update_unread() {
      $id_receiver = $this->input->post('id_receiver');
      $id_from = $this->input->post('id_from');
      $data = array(
        'id_receiver' => $id_receiver,
        'id_from' => $id_from
      );
      $update_unread = $this->chat_model->update_unread($data);
      echo json_encode($update_unread);
    }


    public function count_unread() {
      $id_receiver = $this->input->get('id_receiver');
      $all_messages = $this->chat_model->all_messages($id_receiver);
      echo json_encode($all_messages);
    }

}
<?php

require APPPATH.'libraries/REST_Controller.php';

class Login extends REST_Controller{
  
  public function __construct(){

    parent::__construct();
    $this->load->model('UsuarioModel');

  }

  public function login_post(){
    
    $mail = $this->post('email');
    $pass = $this->post('password');
    $this->response(
        array(
            "status" => 1,
            "message" => "One user",
            "data" => $this->UsuarioModel->getOne($mail,$pass)
        ), 
        REST_Controller::HTTP_OK
    );
  }

}

?>
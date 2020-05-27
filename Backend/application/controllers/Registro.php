<?php

require APPPATH.'libraries/REST_Controller.php';

class Registro extends REST_Controller{
  
  public function __construct(){

    parent::__construct();
    $this->load->model('UsuarioModel');
    $this->load->model('MailModel');


  }

  public function registro_post(){
    
    $status = NULL;
    $mail = $this->post('email');
    $pass = $this->post('password');

    $us = $this->UsuarioModel->getOne($mail,$pass);
    
    /*
        ESTATS
        -------
        1 - TOT OK (MAIL ENVIAT I USUARI REGISTRAT)
        2 - CORREU REENVIAT (USUARI EXISTENT PERO NO ACTIU)
        -1 - USUARI JA EXISTENT (JA ACTIVAT)
        -2 - CORREU NO ENVIAT
        -3 - USUARI NO REGISTRAT
    */


    if($us != NULL){
        if(!$us["activado"]){
            if($this->MailModel->enviarCorreoRegistro($mail)){
                $status = 2;
                $message = "CORREU REENVIAT (USUARI EXISTENT PERO NO ACTIU)";
            }
            else{
                $status = -2;
                $message = "CORREU NO ENVIAT";
            }
        }
        else{
            $status = -1;
            $message = "USUARI JA EXISTENT (JA ACTIVAT)";
        }
    }
    else{
        //registrar y enviar mail 1

        $reg = $this->UsuarioModel->registro($mail,$pass);
        if($reg){
            if($this->MailModel->enviarCorreoRegistro($mail)){
                $status = 1;
                $message = "TOT OK (MAIL ENVIAT I USUARI REGISTRAT)";
            }
            else{
                $status = -2;
                $message = "CORREU NO ENVIAT";
            }
        }
        else{
            $status = -3;
        }
    }

    $this->response(
        array(
            "status" => $status,
            "message" => $message
        ), 
        REST_Controller::HTTP_OK
    );
  }

  

}

?>
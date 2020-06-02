<?php

require APPPATH.'libraries/REST_Controller.php';

class Usuario extends REST_Controller{
  
    public function __construct(){

        parent::__construct();
        $this->load->model('SintomaModel');
        $this->load->model('HabitoModel');
    }

    /**
     * Obtenemos el usuario via post y devolvemos todos sus habitos con sus respuestas
     */
    public function obtenerHabitosPerfil_post()
    {
        $usuario = $this->post('usuario');
        $status = 0;
        $message = null;

        $status = $this->HabitoModel->obtenerHabitosUsuario($usuario);

        $this->response(
            array(
                "status" => $status,
                "message" => $status?'Se han modificado los habitos.':'No se han podido guardar los habitos.'
            ), 
            REST_Controller::HTTP_OK
        );
    }

}

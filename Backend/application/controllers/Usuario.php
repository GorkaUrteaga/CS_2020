<?php

require APPPATH.'libraries/REST_Controller.php';

class Usuario extends REST_Controller{
  
    public function __construct(){

        parent::__construct();
        $this->load->model('SintomaModel');
        $this->load->model('HabitoModel');
        $this->load->model('UsuarioModel');
    }

    /**
     * Obtenemos el usuario via post y devolvemos todos sus habitos con sus respuestas
     */
    public function obtenerHabitosPerfil_post()
    {
        $usuario = $this->post('usuario');
        $status = 0;
        $message = null;
        //$habitos = 'aaa';
        $habitos = $this->HabitoModel->obtenerHabitosUsuario($usuario);

        $status = $habitos == null? 0: 1;

        $this->response(
            array(
                "status" => $status,
                "message" => $status?'Habitos recogidos correctamente.':'No se han podido recoger los habitos.',
                "data" => $habitos
            ), 
            REST_Controller::HTTP_OK
        );
    }

    public function guardarHabitosPerfil_post()
    {
        $habitos = json_decode($this->post('habitos'));
        $respuestas = json_decode($this->post('respuestas'));
        $usuario = $this->post('usuario');
        $status = 0;
        $message = null;
        
        $habitos = $this->HabitoModel->guardarHabitosUsuario($usuario, $habitos, $respuestas);

        $status = $habitos == null? 0: 1;

        $this->response(
            array(
                "status" => $status,
                "message" => $status?'Se han modificado los habitos del usuario.':'No se han podido modificar los habitos del usuario.'
            ), 
            REST_Controller::HTTP_OK
        );
    }

    public function comprobarPerfilUsuario_post()
    {
        $usuario = $this->post('usuario');

        //$habitosSinResponder = false;

        $habitosSinResponder = $this->UsuarioModel->comprobarPerfil($usuario);

        $this->response(
            array(
                "status" => $habitosSinResponder,
                "message" => $habitosSinResponder?'Se tienen que responder los habitos del perfil.':'Todos los habitos se han respondido.'
            ), 
            REST_Controller::HTTP_OK
        );

    }

}

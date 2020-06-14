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

    public function guardarCalendario_post()
    {
        $intervalos = json_decode($this->post('intervalos'));
        $usuario = $this->post('usuario');
        $status = 0;
        $message = null;
        
        $status = $this->UsuarioModel->guardarIntervalosUsuario($usuario, $intervalos);
        
        $this->response(
            array(
                "status" => $status,
                "message" => $status?'Se ha podido modificar el calendario del usuario.':'No se ha podido modificar el calendario del usuario.'
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

    public function sintomas_get()
    {
        $status = 1;
        $message = null;

        $sintomas = $this->SintomaModel->getAll();
        
        if($sintomas == null)
        {
            $status = 0;
            $message = 'No se han encontrado sintomas.';
        }

        $this->response(
            array(
                "status" => $status,
                "message" => $message,
                "data" => $sintomas
            ), 
            REST_Controller::HTTP_OK
        );

    }

    public function obtenerRiesgo_post()
    {
        $status = 1;
        $message = null;
        $usuario = $this->post('usuario');

        $riesgo = $this->UsuarioModel->getRiesgo($usuario);

        $this->response(
            array(
                "status" => $status,
                "message" => "Riesgo del usuario.",
                "data" => $riesgo
            ), 
            REST_Controller::HTTP_OK
        );

    }

    public function obtenerIntervalosSintomas_post()
    {
        $status = 1;
        $message = null;
        $usuario = $this->post('usuario');

        $intervalos = $this->UsuarioModel->getIntervalos($usuario);

        $this->response(
            array(
                "status" => $status,
                "message" => "Intervalos del usuario.",
                "data" => $intervalos
            ), 
            REST_Controller::HTTP_OK
        );
    }

}

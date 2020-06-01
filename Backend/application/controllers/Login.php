<?php

require APPPATH . 'libraries/REST_Controller.php';

class Login extends REST_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('UsuarioModel');
        $this->load->model('MailModel');
    }

    public function login_post()
    {

        $mail = $this->post('email');
        $pass = $this->post('password');
        $status = 1;
        $message = null;

        $usuario = $this->UsuarioModel->getOne($mail, $pass);

        if ($usuario == null) {
            $status = 0;
            $message = "Correo o contraseña incorrectos.";
        }


        $this->response(
            array(
                "status" => $status,
                "message" => $message,
                "data" => $usuario
            ),
            REST_Controller::HTTP_OK
        );
    }

    public function recuperarContrasena_post()
    {
        $email = $this->post('email');

        $this->MailModel->enviarCorreoRecuperarContrasena($email,'AAAAA');

    }

}

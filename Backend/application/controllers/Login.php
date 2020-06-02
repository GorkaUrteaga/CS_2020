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
        $todoOk = false;
        $email = $this->post('email');
        $codigo = $this->UsuarioModel->generarCodigoRecuperacion($email);

        if($codigo != null)
        {
            $todoOk = $this->MailModel->enviarCorreoRecuperarContrasena($email, $codigo);
        }

        $this->response(
            array(
                "status" => $todoOk,
                "message" => $todoOk?'Se ha enviado el correo correctamente.':'No se ha podido enviar el correo.'
            ),
            REST_Controller::HTTP_OK
        );
    }

    public function verificarCodigoRecuperarContrasena_post()
    {
        $todoOk = false;
        $codigo = $this->post('codigo');

        $todoOk = $this->UsuarioModel->comprobarCodigoRecuperacion($codigo);

        $this->response(
            array(
                "status" => $todoOk,
                "message" => $todoOk?'Se procede a cambiar la contraseña.':'El código introducido no es válido.'
            ),
            REST_Controller::HTTP_OK
        );
    }

    public function cambiarContrasenaUsuario_post()
    {
        $todoOk = false;
        $correo = $this->post('email');
        $password = $this->post('password');

        $todoOk = $this->UsuarioModel->cambiarContrasena($correo, $password);

        $this->response(
            array(
                "status" => $todoOk,
                "message" => $todoOk?'Se ha cambiado correctamente la contraseña.':'No se ha podido cambiar la contraseña.'
            ),
            REST_Controller::HTTP_OK
        );

    }

}

<?php

require APPPATH . 'libraries/REST_Controller.php';

class Registro extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('UsuarioModel');
        $this->load->model('MailModel');
    }

    public function registro_post()
    {
        $status = NULL;
        $message = NULL;
        $mail = $this->post('email');
        $pass = $this->post('password');

        $us = $this->UsuarioModel->getUsuarioPorCorreo(sha1($mail));

        /*
        ESTATS
        -------
        1 - TOT OK (MAIL ENVIAT I USUARI REGISTRAT)
        2 - CORREU REENVIAT (USUARI EXISTENT PERO NO ACTIU)
        -1 - USUARI JA EXISTENT (JA ACTIVAT)
        -2 - CORREU NO ENVIAT
        -3 - USUARI NO REGISTRAT
        */

        if ($us != NULL) {
            if (!$us["activado"]) {
                if ($this->MailModel->enviarCorreoRegistro($mail)) {
                    $status = 2;
                    $message = "Correo reenviado (Usuario existente pero no verificado)!";
                } else {
                    $status = -2;
                    $message = "Usuario ya existente, no se ha podido enviar el correo!";
                }
            } else {
                $status = -1;
                $message = "Usuario ya existente!";
            }
        } else {
            //registrar y enviar mail 1

            $reg = $this->UsuarioModel->registro($mail, $pass);
            if ($reg) {
                if ($this->MailModel->enviarCorreoRegistro($mail)) {
                    $status = 1;
                    $message = "Usuario registrado correctamente!";
                } else {
                    $status = -2;
                    $message = "Revisa el correo, no se ha podido registrar!";
                }
            } else {
                $status = -3;
                $message = "El usuario no se ha podido registrar!";
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

    public function activacion_post()
    {
        $email = $this->post('email');
        //Si s'ha pogut activar la conta enviem un 1 sino un 0
        $status = $this->UsuarioModel->activacionCuenta($email);

        $message = "Se ha activado la cuenta correctamente.";

        if(!$status)
        {
            $message = "No se ha podido realizar la activación de la cuenta.";
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

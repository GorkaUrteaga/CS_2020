<?php

class ErrorConexion extends CI_Controller
{
    public function index()
    {
        $error = "Error al conectarse intenta acceder más tarde.";
        $this->load->view('login_view', array('error' => $error));
    }
}

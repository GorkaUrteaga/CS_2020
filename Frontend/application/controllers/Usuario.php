<?php

class Usuario extends CI_Controller
{
    function __construct() {
        parent::__construct();
        
        if (!$this->session->id_usuario || $this->session->es_admin) 
        {
            redirect('Login');
        }
    }

    public function index($mantenimiento)
    {
        //Comprovamos si ya ha llenado toda la información del perfil para mandarlo a la vista del perfil o no
        $this->load->view('admin_view');
    }
}

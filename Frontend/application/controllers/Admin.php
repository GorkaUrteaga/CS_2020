<?php

class Admin extends CI_Controller
{
    function __construct() {
        parent::__construct();
        
        if (!$this->session->id_usuario || !$this->session->es_admin) 
        {
            redirect('Login');
        }
    }

    public function index($mantenimiento)
    {
        $this->load->view('admin_view');
        switch ($mantenimiento) {
            case 'sintomas':
                $this->load->view('sintomas_view');
                break;
            case 'habitos':
                $this->load->view('habitos_view');
                break;
        }
    }
}

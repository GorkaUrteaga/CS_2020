<?php

class Usuario extends CI_Controller
{
    private $baseUrl = wsUrl . 'Usuario/';
    private $ch = null;

    function __construct() {
        parent::__construct();
        
        if (!isset($this->session->usuario) || $this->session->usuario->es_admin) 
        {
            redirect('Login');
        }

        $this->ch = curl_init();
    }

    public function index()
    {
        
        

        
        
        //Comprovamos si ya ha llenado toda la información del perfil para mandarlo a la vista del perfil o no
        $this->load->view('usuario_view');

    }

    public function perfilUsuario()
    {
        $action = 'obtenerHabitosPerfil';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $response = '';
        $request = '';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);
        $json = json_decode ($response);
        
        $items = $json->data;

        $data = ['habitos', $items];

        $this->load->view('perfil_usuario_view',$data);

    }
}

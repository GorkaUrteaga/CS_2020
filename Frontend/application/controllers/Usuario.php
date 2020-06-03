<?php

include APPPATH . 'third_party\config_ws.php';

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

        $this->perfilUsuario();

    }

    public function perfilUsuario()
    {
        $action = 'obtenerHabitosPerfil';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $response = '';
        $request = 'usuario=' . $this->session->usuario->id;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);
        $json = json_decode($response);

        $items = $json->data;

        $data = ['habitos' => $items];

        $this->load->view('perfil_usuario_view',$data);

    }

    public function guardarPerfil()
    {
        $habitos = $this->input->post('habitos[]');

        //var_dump($_POST);
        $respuestas = [];

        foreach($habitos as $habito)
        {
            //var_dump($habito);
            $respuesta = $this->input->post($habito.'[]');

            if($respuesta != null)
            {
                array_push($respuestas, intval(implode($respuesta)));
            }
        }

        if(count($habitos) != count($respuestas))
        {
            $error = "Se deben contestar todos los habitos!";
            $this->session->set_flashdata('error', $error);
            Redirect('Usuario');
        }

        //Si hemos llegado aquí es que todos los habitos tienen respuesta procedemos a guardar.
        $action = 'guardarHabitosPerfil';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $response = '';
        $request = 'usuario=' . $this->session->usuario->id . '&' . 'habitos=' . json_encode($habitos) . '&' . 'respuestas=' . json_encode($respuestas);
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);
        $json = json_decode($response);

        Redirect('Usuario');

    }
}

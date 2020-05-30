<?php

include APPPATH . 'third_party\config_ws.php';

class Registro extends CI_Controller
{
    private $baseUrl = wsUrl . 'Registro/';
    private $ch = null;

    function __construct()
    {
        parent::__construct();
        $this->ch = curl_init();
    }

	public function index()
	{
        $this->load->view('registro_view');
    }
    
    /**
     * Registrar
     * Capturem els parametres per post i ho enviem 
     * al ws per que ens retorni si l'usuari s'ha pogut registrar o no
     */
    public function registrar()
    {
        $errorMsg = null;
        $action = 'registro';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $email = $this->input->post('email');
        $password = sha1($this->input->post('password'));
        $response = "";

        $password = sha1($this->input->post('password'));
        $password_confirmacion = sha1($this->input->post('confirmacion_password'));

        if ($password != $password_confirmacion)
        {
            //Redirigimos a la pagina de login indicando el error
            Redirect('Registro');

        }

        $request = 'email=' . $email . '&' . 'password=' . $password;
        //Cridem a la funció WS que ens retorna si es hem pogut registrar o no al usuari i perque amb un codi
        // 2 - usuari ja creat, pero sense activar, es reenvia correu, 1 - s'ha registrat correctament i envia correu, -1 - ja registrat i activat
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);
        //Dependiendo de la respuesta mostramos un mensaje u otro, si todo es correcto redirigimos a login
        $json = json_decode ($response);

        if($json->status != 1)
        {
            $errorMsg = $json->message;
            $data = ['error' => $errorMsg];
            $this->load->view('registro_view',$data);
        }else{
            Redirect('Login');
        }
        
    }

    public function activacion($sha1Mail)
    {
        //enviamos el hash del correo al ws i el nos dirà si es correcto o no
        $response = "";
        $action = 'activacion';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;

        $request = 'email=' . $sha1Mail;
        //Cridem a la funció WS que ens retorna si es hem pogut registrar o no al usuari i perque amb un codi
        // 2 - usuari ja creat, pero sense activar, es reenvia correu, 1 - s'ha registrat correctament i envia correu, -1 - ja registrat i activat
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);
        //Dependiendo de la respuesta mostramos un mensaje u otro, si todo es correcto redirigimos a login
        $json = json_decode ($response);

        $data = ['message' => $json->message, 'status' => $json->status];
        
        $this->load->view('verificacion_view',$data);

    }

}

<?php

include APPPATH . 'third_party\config_ws.php';

class Registro extends CI_Controller
{
    private $baseUrl = wsUrl . '\Registro';
    private $ch = null;

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
        $action = 'registrar';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));

        $request = 'email=' . $email . '&' . 'password=' . $password;
        //Cridem a la funció WS que ens retorna si es hem pogut registrar o no al usuari i perque amb un codi
        // 2 - usuari ja creat, pero sense activar, es reenvia correu, 1 - s'ha registrat correctament i envia correu, -1 - ja registrat i activat
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        $response = curl_exec($ch);
        var_dump($response['data']);
        exit;
    }

    public function activacion($md5Mail)
    {
        //enviamos el hash del correo al ws i el nos dirà si es correcto o no
        
    }

}

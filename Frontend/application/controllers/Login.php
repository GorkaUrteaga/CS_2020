<?php

include APPPATH . 'third_party\config_ws.php';

class Login extends CI_Controller
{
    private $baseUrl = wsUrl . '\Login';
    private $ch = null;

    function __construct()
    {
        parent::__construct();
        $this->ch = curl_init();
    }


    public function index()
    {
        //echo password_hash("marc199908", PASSWORD_BCRYPT);
        //echo wsUrl;
        //exit;
        //$this->load->view('admin_view');
        $this->load->view('login_view');
    }

    /**
     * Logear
     * Capturem els parametres per post i ho enviem 
     * al ws per que ens retorni l'usuari si existeix
     * sino existeix ens retornem a la vista notificant els errors
     */
    public function logear()
    {
        $action = 'login';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $email = md5($this->input->post('email'));
        $password = md5($this->input->post('password'));

        $request = 'email=' . $email . '&' . 'password=' . $password;
        //Cridem a la funció WS que ens retorna si es correcte o no el login i si ho es el guardem en session i continuem depenent del rol cap a un lloc o un altre
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        $response = curl_exec($ch);
        var_dump($response['data']);
        exit;
        //Si la data es null l'usuari no existeix tornem a la vista amb errors

        

    }

    /**
     * Logout
     * Destruim la session i tornem a portar a la pantalla de login
     */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('Login');
    }
}

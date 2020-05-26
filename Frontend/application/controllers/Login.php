<?php

class Login extends CI_Controller
{
    //Variable Curl
    private $ch = null;
    private $request = '';
    private $baseUrl = 'http://127.0.0.1/Backend/index.php/Login/';

    function __construct()
    {
        parent::__construct();
        $this->ch = curl_init();
        $ch = curl_init();

        $action = "user";
        $url = $this->baseUrl . $action;
        $is_post = true;

        $response = curl_exec($ch);
    }


    public function index()
    {
        //echo password_hash("marc199908", PASSWORD_BCRYPT);
        $this->load->view('admin_view');
        //$this->load->view('login_view');
    }

    /**
     * Login
     * Capturem els parametres per post i ho enviem 
     * al ws per que ens retorni l'usuari si existeix
     * sino existeix ens retornem a la vista notificant els errors
     */
    public function login()
    {
        $action = 'login';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $email = md5($this->input->post('email'));
        $password = md5($this->input->post('password'));

        //$request = 'mail=' . $_POST['mail'] . '&' . 'name=' . $_POST['name'];  
        $request = 'email=' . $email . '&' . 'password=' . $password;
        //Cridem a la funció WS que ens retorna si es correcte o no el login i si ho es el guardem en session i continuem depenent del rol cap a un lloc o un altre
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        $response = curl_exec($ch);
        var_dump($response);
        exit;

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

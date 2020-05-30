<?php

include APPPATH . 'third_party\config_ws.php';

class Login extends CI_Controller
{
    private $baseUrl = wsUrl . 'Login/';
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
        $email = sha1($this->input->post('email'));
        $password = sha1($this->input->post('password'));
        $response = "";

        $request = 'email=' . $email . '&' . 'password=' . $password;
        //Cridem a la funció WS que ens retorna si es correcte o no el login i si ho es el guardem en session i continuem depenent del rol cap a un lloc o un altre
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0); //0 per evitar que el request doni la capsalera

        $response = curl_exec($ch);
        
        $json = json_decode ($response);
        
        $usuario = $json->data;
        
        if($usuario != null)
        {
            //Si el usuario existe redirigimos en base a su rol
            //Guardamos el usuario en session
            $this->session->set_userdata('usuario', $usuario);
            Redirect('Admin');
            
        }else{
            //Enviamos a login con mensaje de error correo o contrasseña incorrectos
            $message = $json->message;
            $data = ['error' => $message];
            $this->load->view('login_view',$data);
        }

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

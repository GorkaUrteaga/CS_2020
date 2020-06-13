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
        $this->session->sess_destroy();
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
        $todoOk = true;
        $action = 'login';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $email = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));
        $response = "";

        if($password == "" || $email == "")
        {
            $todoOk = false;
        }

        if($todoOk){
            
            $email = sha1($email);
            $password = sha1($password);
    
            $request = 'email=' . $email . '&' . 'password=' . $password;
            //Cridem a la funció WS que ens retorna si es correcte o no el login i si ho es el guardem en session i continuem depenent del rol cap a un lloc o un altre
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, 0); //0 per evitar que el request doni la capsalera
    
            $response = curl_exec($ch);
    
            $json = json_decode($response);
    
            if($json == null){
                Redirect('ErrorConexion');
            }

            $usuario = $json->data;

            if($usuario == null || !$usuario->activado)
            {
                $todoOk = false;
            }
    
            if ($todoOk) {
                //Si el usuario existe redirigimos en base a su rol
                //Guardamos el usuario en session
                $this->session->set_userdata('usuario', $usuario);
    
                if($usuario->es_admin)
                {
                    Redirect('Admin');
                }else{
                    Redirect('Usuario');
                }
                
            } else {
                //Enviamos a login con mensaje de error correo o contrasseña incorrectos
                $message = $json->message;
                
                $data = ['error' => $message];
                $this->load->view('login_view', $data);
            }

        }else{
            $data = ['error' => "El email y la contraseña no pueden estar vacios!"];
            $this->load->view('login_view', $data);
        }
        
    }

    public function recuperarContrasena()
    {
        $action = null;
        $ch = $this->ch;
        $data = [];
        $error = null;
        $correo = $this->input->post('email');
        $codigo = $this->input->post('codigo');
        $password = $this->input->post('password');
        $confirmarPassword = $this->input->post('confirmar_password');
        $response = "";
        
        if(($password != null && $confirmarPassword != null) && trim($password) != '' && $password == $confirmarPassword)
        {
            //En aquest cas enviem la solicitud al ws per canviar la password.
            $action = 'cambiarContrasenaUsuario';
            $url = $this->baseUrl . $action;
            $correo = $this->session->correoCambioPass;
            //Enviamos encriptados los 2
            $request = 'email=' . sha1($correo) . '&' . 'password=' . sha1($password);

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $response = curl_exec($ch);
            
            $json = json_decode($response);

            if ($json != null && !$json->status) {
                $error = $json->message;
                $data = ['error' => $error];
            } else {
                //Si tot bé fiquem en session la variable recuperarOn
                Redirect('Login');
            }

        }

        if ($codigo != null) {
            $action = 'verificarCodigoRecuperarContrasena';
            $url = $this->baseUrl . $action;
            

            $request = 'codigo=' . $codigo;
            //Cridem a la funció WS que ens retorna si es correcte o no el login i si ho es el guardem en session i continuem depenent del rol cap a un lloc o un altre
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, 0); //0 per evitar que el request doni la capsalera

            $response = curl_exec($ch);

            $json = json_decode($response);

            if($json == null){
                Redirect('ErrorConexion');
            }

            if ($json != null && !$json->status) {
                $error = $json->message;
                $data = ['error' => $error];
            } else {
                //Si tot bé fiquem en session la variable recuperarOn
                $this->session->set_userdata('recuperar', 2);
            }
        }

        if ($correo != null) {
            //El backend envia un mail al usuario si existe el correo con un codigo que se guarda en la tabla del usuario
            $action = 'recuperarContrasena';
            $url = $this->baseUrl . $action;

            $request = 'email=' . $correo;
            //Cridem a la funció WS que ens retorna si es correcte o no el login i si ho es el guardem en session i continuem depenent del rol cap a un lloc o un altre
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, 0); //0 per evitar que el request doni la capsalera

            $response = curl_exec($ch);
            
            $json = json_decode($response);

            if($json == null){
                Redirect('ErrorConexion');
            }

            if ($json != null && !$json->status) {
                $error = $json->message;
                $data = ['error' => $error];
            } else {
                //Si tot bé fiquem en session la variable recuperarOn
                $this->session->set_userdata('recuperar', 1);
                //Guardamos en session también el correo del usuario que posteriormente usaremos para cambiarle la contraseña
                $this->session->set_userdata('correoCambioPass', $correo);

            }
        }

        $this->load->view('recuperar_contrasena_view', $data);
    }

    /**
     * Logout
     * Destruim la session i tornem a portar a la pantalla de login
     */
    /*
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('Login');
    }
    */
}

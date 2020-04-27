<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Login extends Controller
{
    //Variable Curl
    private $ch = null;
    private $baseUrl = 'http://127.0.0.1/Backend/public/index.php/api/users/';

    function __construct() {
        //parent::__construct();
        $this->ch = curl_init();
        
    }

    public function index()
    {
        echo password_hash("marc199908", PASSWORD_BCRYPT);
        //return view('login_view');
    }

    public function login()
    {
        
        $ch = $this->ch;
        $email = $this->input->post('email');
        $password = $this->input->post('password');


    }
}

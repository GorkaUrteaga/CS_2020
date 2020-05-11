<?php namespace App\Controllers;

use CodeIgniter\Controller;
use REST_Controller;

class Helloworld extends REST_Controller
{
    public function index()
    {
        echo 'Hello World!';
    }
}
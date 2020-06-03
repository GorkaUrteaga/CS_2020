<?php

class RespuestaHabitoModel extends CI_Model
{
    public $id;
    public $respuesta;
    public $chequeada = false;

    function __construct()
    {
        $this->load->database();
    }

}

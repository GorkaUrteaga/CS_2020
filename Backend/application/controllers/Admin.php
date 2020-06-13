<?php

require APPPATH.'libraries/REST_Controller.php';

class Admin extends REST_Controller{
  
    public function __construct(){

        parent::__construct();
        $this->load->model('SintomaModel');
        $this->load->model('HabitoModel');
    }

    /**
     * sintomas_get devuelve todos los sintomas en la DB
     */
    public function sintomas_get()
    {
        $status = 1;
        $message = null;

        $sintomas = $this->SintomaModel->getAll();
        
        if($sintomas == null)
        {
            $status = 0;
            $message = 'No se han encontrado sintomas.';
        }
        
        $this->response(
            array(
                "status" => $status,
                "message" => $message,
                "data" => $sintomas
            ), 
            REST_Controller::HTTP_OK
        );

    }

    /**
     * habitos_get devuelve todos los habitos en la DB
     */
    public function habitos_get()
    {
        $status = 1;
        $message = null;

        $habitos = $this->HabitoModel->getAll();

        if($habitos == null)
        {
            $status = 0;
            $message = 'No se han encontrado habitos.';
        }

        $this->response(
            array(
                "status" => $status,
                "message" => $message,
                "data" => $habitos
            ), 
            REST_Controller::HTTP_OK
        );
    }

    public function guardarSintomas_post()
    {
        $items_json = $this->post('sintomas');
        $status = 0;
        $message = null;
        
        $items = json_decode($items_json);

        //Esta funcion se encarga de hacer todo, delete, insert i updates
        
        $status = $this->SintomaModel->guardarSintomas($items);

        $this->response(
            array(
                "status" => $status,
                "message" => $status?'Se han modificado los sintomas.':'No se han podido guardar los sintomas.'
            ), 
            REST_Controller::HTTP_OK
        );
    }

    public function guardarHabitos_post()
    {
        $items_json = $this->post('habitos');
        $status = 0;
        $message = null;
        
        $items = json_decode($items_json);

        //Esta funcion se encarga de hacer todo, delete, insert i updates

        $status = $this->HabitoModel->guardarHabitos($items);

        $this->response(
            array(
                "status" => $status,
                "message" => $status?'Se han modificado los habitos.':'No se han podido guardar los habitos.'
            ), 
            REST_Controller::HTTP_OK
        );
    }

}

<?php

include APPPATH . 'third_party\config_ws.php';

class Admin extends CI_Controller
{

    private $baseUrl = wsUrl . 'Admin/';
    private $ch = null;

    function __construct()
    {
        parent::__construct();

        if (!isset($this->session->usuario) || !$this->session->usuario->es_admin) {
            redirect('Login');
        }

        $this->ch = curl_init();
    }

    public function index($mantenimiento = null)
    {
        $this->session->unset_userdata('editar');
        $this->load->view('admin_view');

        if ($mantenimiento == null) {
            $mantenimiento = $this->session->vista;
            if ($mantenimiento == null) {
                $mantenimiento = 'sintomas';
            }
        }


        $action = $mantenimiento;
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $response = '';
        $request = '';

        //Cridem a la funció WS que ens retorna si es correcte o no el login i si ho es el guardem en session i continuem depenent del rol cap a un lloc o un altre
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HEADER, 0); //0 per evitar que el request doni la capsalera

        $response = curl_exec($ch);
        $json = json_decode($response);
        //var_dump($url);
        //var_dump($response);
        //exit;
        $items = $json->data;

        $maxId =  1;
        if ($items != null) {
            foreach ($items as $item) {
                if ($item->id > $maxId) {
                    $maxId = $item->id;
                }
            }
        }

        $this->session->set_userdata('items', $items);
        $this->session->set_userdata('maxId', $maxId);

        $data = ['items' => $items];

        $this->session->set_userdata('vista', $mantenimiento);

        $this->load->view($mantenimiento . "_view", $data);
    }

    public function cancelarEdicion()
    {
        Redirect('Admin/index/' . $this->session->vista);
    }

    private function cargarVistas()
    {
        $items = $this->session->items;
        $data = ['items' => $items];

        if ($this->session->errores) {
            $data['errores'] = $this->session->errores;
        }

        $this->load->view('admin_view');
        $this->load->view($this->session->vista . "_view", $data);
    }

    public function editarItems()
    {
        $this->session->set_userdata('editar', true);
        $items = $this->session->items;
        $data = ['items' => $items];

        $this->cargarVistas();
    }

    public function eliminarItem($idItem)
    {
        $items = $this->session->items;
        $i = 0;

        while($i < count($items) && !($items[$i]->id == $idItem))
        {
            $i++;
        }

        if($i<count($items)){
            unset($items[$i]);
            $items = array_merge($items); 
        }

        

        $this->session->set_userdata('items', $items);
        $this->cargarVistas();
    }

    public function addItem()
    {
        $items = $this->session->items;
        $maxId = $this->session->maxId + 1;
        $nombre = trim($this->input->post('nombre'));

        //Miramos si ya existe
        $item = array_filter(
            $items,
            function ($e) use ($nombre) {
                return strtolower($e->nombre) == strtolower($nombre);
            }
        );

        if (empty($item)) {
            if ($this->session->vista == 'sintomas') {
                $item = (object) ['id' => $maxId, 'nombre' => $nombre, 'porcentaje' => 0];
            } else {
                $item = (object) ['id' => $maxId, 'nombre' => $nombre, 'si' => 0, 'no' => 0, 'a_veces' => 0];
            }

            array_push($items, $item);
            $this->session->set_userdata('maxId', $maxId);
            $this->session->set_userdata('items', $items);
        }

        $this->cargarVistas();
    }

    public function guardarSintomas()
    {
        //$arrayErrores = [];
        $action = 'guardarSintomas';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $response = '';
        $request = '';
        $suma = 0;
        $todoOk = true;
        $pos = -1;

        $porcentajes = $this->input->post('porcentajes[]');
        $items = $this->session->items;

        if (!empty($porcentajes)) {
            $suma = array_sum($porcentajes);
            $pos = array_search(0, $porcentajes);
        }

        if (empty($items) || ($pos != null && $pos >= 0) || $suma != 100) {
            //array_push($arrayErrores, 'La suma de todos los porcentajes debe ser 100.');
            //array_push($arrayErrores, 'Todos los sintomas deben tener un porcentaje mayor a 0.');
            $todoOk = false;
        }

        if (!$todoOk) {
            //$this->session->set_flashdata('errores', $arrayErrores);
            $this->cargarVistas();
        } else {
            //Ningun error guardamos
            //Primero, eliminamos aquellos que ya no estan.
            //Insertamos y modificamos.

            $i = 0;
            foreach ($items as $item) {
                $item->porcentaje = $porcentajes[$i];
                $i++;
            }
            //var_dump($items);
            //exit;

            $request = 'sintomas=' . json_encode($items);

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $response = curl_exec($ch);
            $json = json_decode($response);

            Redirect('Admin');
        }
    }

    public function guardarHabito()
    {
        $action = 'guardarHabitos';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $response = '';
        $request = '';
        $suma = 0;
        $todoOk = true;
        $pos = -1;

        $porcSi = $this->input->post('porcentajes_si[]');
        $porcNo = $this->input->post('porcentajes_no[]');
        $porcAveces = $this->input->post('porcentajes_a_veces[]');
        $items = $this->session->items;

        if (empty($items) || empty($porcNo) || empty($porcAveces)) {
            $todoOk = false;
        }

        if (!$todoOk) {
            $this->cargarVistas();
        } else {
            //Guardamos
            $i = 0;
            foreach ($items as $item) {
                $item->si = $porcSi[$i];
                $item->no = $porcNo[$i];
                $item->a_veces = $porcAveces[$i];
                $i++;
            }

            $request = 'habitos=' . json_encode($items);

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $response = curl_exec($ch);
            $json = json_decode($response);
            var_dump($json);
            //exit;
            Redirect('Admin');
        }
    }
}

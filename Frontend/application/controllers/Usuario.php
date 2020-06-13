<?php

include APPPATH . 'third_party\config_ws.php';

class Usuario extends CI_Controller
{
    private $baseUrl = wsUrl . 'Usuario/';
    private $ch = null;

    function __construct()
    {
        parent::__construct();

        if (!isset($this->session->usuario) || $this->session->usuario->es_admin) {
            redirect('Login');
        }

        $this->ch = curl_init();
    }

    public function index()
    {
        //Comprovamos si ya ha llenado toda la información del perfil para mandarlo a la vista del perfil o no
        $perfilIncompleto = $this->comprobarPerfilUsuario();
        $this->session->set_userdata('perfilIncompleto', $perfilIncompleto);

        if ($perfilIncompleto) {
            $this->perfilUsuario();
        } else {
            $this->calendarioUsuario();
        }
    }

    public function calendarioUsuario()
    {
        //Cargamos fechas hasta el dia de hoy
        $this->load->view('usuario_view');
        $fechados = date('d-m-Y');
        $fechauno = date('d-m-Y', strtotime($fechados . ' - 2 months'));
        $fechas = [];
        $sintomasMarcados = [];

        $fecha = $fechauno;

        while (strtotime($fecha) <= strtotime($fechados)) {
            array_push($fechas, $fecha);
            $fecha = date("d-m-Y", strtotime($fecha . " + 1 day"));
        }

        $intervalos = $this->obtenerIntervalosUsuarioActual();

        //Tenemos que pasarle a los inputs si ya estaban marcados o no
        //HAY UN PROBLEMA ESTAMOS SOBREESCRIBIENDO el $i
        if ($intervalos != null) {
            for ($i = 0; $i < count($fechas); $i++) {
                foreach ($intervalos as $intervalo) {

                    $fecha_inicio = date('d-m-Y', strtotime($intervalo->fecha_inicio));
                    $fecha_fin = date('d-m-Y', strtotime($intervalo->fecha_fin));
                    $sintoma = $intervalo->id_sintoma;

                    $incluido = strtotime($fechas[$i]) >= strtotime($fecha_inicio) && strtotime($fechas[$i]) <= strtotime($fecha_fin);

                    $sintomasMarcados[$i][$sintoma] = $incluido;

                    //var_dump($sintomasMarcados[$i]);
                    //array_push($sintomasMarcados[$i], [$sintoma => $incluido]);

                    //$sintomasMarcados[$i] = [$sintoma => $incluido];
                    /*
                    echo $i;
                    echo "<br>";
                    echo "Fecha: " . $fechas[$i];
                    echo "<br>";
                    echo $fecha_inicio;
                    echo " - $fecha_fin";
                    echo "<br>";
                    var_dump($sintomasMarcados[$i]);
                    echo "<br>";
                    echo $incluido?'INCLUIDO':'NO';
                    echo "<br>";
                    echo "<br>";
                    */
                }
            }
            //var_dump($sintomasMarcados);
            //exit;
        }

        $action = 'sintomas';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $response = '';
        $request = '';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);
        $json = json_decode($response);

        if ($json == null) {
            Redirect('ErrorConexion');
        }

        $sintomas = $json->data;
        $data = ['fechas' => $fechas, 'sintomas' => $sintomas, 'sintomasMarcados' => $sintomasMarcados];
        $this->load->view('calendario_usuario_view', $data);
    }

    public function obtenerIntervalosUsuarioActual()
    {
        $action = 'obtenerIntervalosSintomas';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $response = '';
        $request = 'usuario=' . $this->session->usuario->id;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);
        $json = json_decode($response);

        if ($json == null) {
            Redirect('ErrorConexion');
        }

        $intervalos = $json->data;

        return $intervalos;
    }

    public function comprobarPerfilUsuario()
    {
        $action = 'comprobarPerfilUsuario';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $response = '';
        $request = 'usuario=' . $this->session->usuario->id;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);
        $json = json_decode($response);

        if ($json == null) {
            Redirect('ErrorConexion');
        }

        $habitosSinResponder = $json->status;

        return $habitosSinResponder;
    }

    public function perfilUsuario()
    {
        $this->load->view('usuario_view');
        $action = 'obtenerHabitosPerfil';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $response = '';
        $request = 'usuario=' . $this->session->usuario->id;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);
        $json = json_decode($response);

        if ($json == null) {
            Redirect('ErrorConexion');
        }

        $riesgo = $this->obtenerRiesgoUsuarioActual();
        $items = $json->data;

        $data = ['habitos' => $items, 'riesgo' => $riesgo];

        $this->load->view('perfil_usuario_view', $data);
    }

    public function obtenerRiesgoUsuarioActual()
    {
        $action = 'obtenerRiesgo';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $response = '';
        $request = 'usuario=' . $this->session->usuario->id;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);
        $json = json_decode($response);

        if ($json == null) {
            Redirect('ErrorConexion');
        }

        $riesgo = $json->data;

        return $riesgo;
    }

    public function guardarPerfil()
    {
        $habitos = $this->input->post('habitos[]');

        //var_dump($_POST);
        $respuestas = [];

        foreach ($habitos as $habito) {
            //var_dump($habito);
            $respuesta = $this->input->post($habito . '[]');

            if ($respuesta != null) {
                array_push($respuestas, intval(implode($respuesta)));
            }
        }

        if (count($habitos) != count($respuestas)) {
            $error = "Se deben contestar todos los habitos!";
            $this->session->set_flashdata('error', $error);
            Redirect('Usuario');
        }

        //Si hemos llegado aquí es que todos los habitos tienen respuesta procedemos a guardar.
        $action = 'guardarHabitosPerfil';
        $url = $this->baseUrl . $action;
        $ch = $this->ch;
        $response = '';
        $request = 'usuario=' . $this->session->usuario->id . '&' . 'habitos=' . json_encode($habitos) . '&' . 'respuestas=' . json_encode($respuestas);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);
        $json = json_decode($response);

        if ($json == null) {
            Redirect('ErrorConexion');
        }

        Redirect('Usuario');
    }

    public function guardarCalendario()
    {
        //Recibiremos por post (01-01-2020$id_sintoma)
        $intervalo_sintomas = $this->input->post('intervalo_sintomas[]');


        var_dump($intervalo_sintomas);
        exit;
    }
}

<?php

class HabitoModel extends CI_Model
{
    public $id;
    public $nombre;
    public $respuestas;

    function __construct()
    {
        $this->load->database();
        $this->load->model('RespuestaHabitoModel');
    }

    public function getAll()
    {
        $this->db->from('vw_habito_respuestas');
        $q = $this->db->get();
        if (count($q->result_array()) == 0) {
            return null;
        }

        return $q->result_array();
    }

    public function obtenerHabitosUsuario($idUsuario)
    {
        $this->db->from('habito');
        $q = $this->db->get();

        if (count($q->result_array()) == 0) {
            return null;
        }

        $habitos = $q->result_array();

        //return $habitos;

        $arrHab = [];

        foreach ($habitos as $habito) {

            $h = new HabitoModel();
            $h->id = $habito['id'];

            $h->nombre = $habito['nombre'];

            $this->db->from('respuesta_habito');
            $this->db->where('id_habito', $habito['id']);
            $q = $this->db->get();

            if (count($q->result_array()) == 0) {
                return null;
            }

            $respuestas = $q->result_array();

            $arrRes = [];

            //return $respuestas;

            foreach ($respuestas as $respuesta) {

                $r = new RespuestaHabitoModel();

                $r->id = $respuesta['id'];
                $r->respuesta = $respuesta['respuesta'];



                $this->db->from('respuesta_habito_usuario');
                $this->db->where('id_usuario', $idUsuario);
                $this->db->where('id_habito', $habito['id']);
                $this->db->where('id_respuesta', $respuesta['id']);
                $q = $this->db->get();
                $r->chequeada = count($q->result_array()) == 0 ? false : true;

                //return $r;

                array_push($arrRes, $r);
            }

            //Le assignamos la array de respuestas al habito
            $h->respuestas = $arrRes;

            //Metemos en la array los habitos
            array_push($arrHab, $h);
        }

        //Aquí tendremos una array de objetos habitos que dentro tendra una array con objetos respuesta

        return $arrHab;
    }

    public function guardarHabitos($items)
    {
        $respuestas = ['Si' => 'si', 'No' => 'no', 'A veces' => 'a_veces'];
        $ids = [];

        try {
            $this->db->trans_begin();

            foreach ($items as $item) {
                $query = $this->db->get_where('habito', array('id' => $item->id));

                if ($query->num_rows() == 0) {
                    //Insert
                    $data = array(
                        'nombre' => $item->nombre
                    );
                    $this->db->insert('habito', $data);
                    $habitoId = $this->db->insert_id();

                    array_push($ids, $habitoId);

                    //Hacemos el insert de sus respuestas tambien
                    foreach ($respuestas as $key => $res) {
                        $data = array(
                            'id_habito' => $habitoId,
                            'respuesta' => $key,
                            'porcentaje' => $item->$res
                        );
                        $this->db->insert('respuesta_habito', $data);
                    }
                } else {
                    //Update

                    array_push($ids, $item->id);

                    foreach ($respuestas as $key => $res) {
                        $data = array(
                            'porcentaje' => $item->$res
                        );
                        $this->db->where('id_habito', $item->id);
                        $this->db->where('respuesta', $key);
                        $this->db->update('respuesta_habito', $data);
                    }
                }
            }

            //Borramos las respuestas y luego los sintomas
            $this->db->where_not_in('id_habito', $ids);
            $this->db->delete('respuesta_habito_usuario');

            $this->db->where_not_in('id_habito', $ids);
            $this->db->delete('respuesta_habito');

            $this->db->where_not_in('id', $ids);
            $this->db->delete('habito');

            $this->db->trans_commit();
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            return false;
        }
        return true;
    }

    public function guardarHabitosUsuario($usuario, $habitos, $respuestas)
    {
        $i = 0;
        try {
            //$this->db->trans_begin();

            for ($i = 0; $i < count($habitos); $i++) {

                $respuesta = $respuestas[$i];
                $habito = $habitos[$i];

                $query = $this->db->get_where('respuesta_habito_usuario', array('id_usuario' => $usuario, 'id_habito' => $habito));
                
                if ($query->num_rows() == 0) {
                    //Insert
     
                    $data = array(
                        'id_habito' => $habito,
                        'id_usuario' => $usuario,
                        'id_respuesta' => $respuesta
                    );
                    $this->db->insert('respuesta_habito_usuario', $data);
                    
                } else {
                    //Update
                    
                    $data = array(
                        'id_respuesta' => $respuesta
                    );

                    $this->db->where('id_habito', $habito);
                    $this->db->where('id_usuario', $usuario);
                    $this->db->update('respuesta_habito_usuario', $data);
                }
            }
            $this->db->trans_commit();
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            return false;
        }

        return true;
    }
}

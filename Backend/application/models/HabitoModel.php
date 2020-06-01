<?php

class HabitoModel extends CI_Model
{

    function __construct()
    {
        $this->load->database();
    }

    public function getAll()
    {
        $this->db->from('vw_habito_respuestas');
        $q = $this->db->get();
        if (count($q->result_array()) == 0)
        {
            return null;
        }

        return $q->result_array();
    }

    public function guardarHabitos($items)
    {
        $respuestas = ['Si' => 'si' , 'No' => 'no', 'A veces' => 'a_veces'];
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
                    foreach($respuestas as $key => $res)
                    {
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

                    foreach($respuestas as $key => $res)
                    {
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

}

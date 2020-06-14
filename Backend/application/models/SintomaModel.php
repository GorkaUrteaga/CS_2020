<?php

class SintomaModel extends CI_Model
{

    function __construct()
    {
        $this->load->database();
    }

    public function getAll()
    {
        $this->db->from('SINTOMA');
        $this->db->order_by('id');
        $q = $this->db->get();

        if (count($q->result_array()) == 0) {
            return null;
        }

        return $q->result_array();
    }

    /**
     * Esta funcion hara inserts de los sintomas nuevos,
     * Delete de los que ya no esten
     * Update modificando el valor del porcentaje
     */
    public function guardarSintomas($items)
    {
        $ids = [];

        try {
            $this->db->trans_begin();
            //Per cada item insertarem o modificarem en base a si existeix o no
            foreach ($items as $item) {

                $query = $this->db->get_where('SINTOMA', array('LOWER(nombre)' => strtolower(trim($item->nombre))));

                

                if ($query->num_rows() == 0) {
                    //Insert
                    
                    $data = array(
                        'nombre' => trim($item->nombre),
                        'porcentaje' => $item->porcentaje
                    );

                    $this->db->insert('SINTOMA', $data);

                    $sintomaId = $this->db->insert_id();

                    array_push($ids, $sintomaId);
                    
                } else {
                    //Update
                    
                    $idUpdate = $query->result_array()[0]['id'];
                    
                    array_push($ids, $idUpdate);

                    $data = array(
                        'porcentaje' => $item->porcentaje
                    );

                    $this->db->where('id', $idUpdate);
                    $this->db->update('SINTOMA', $data);
                    
                }
            }

            $this->db->where_not_in('id_sintoma', $ids);
            $this->db->delete('INTERVALO_SINTOMA');

            $this->db->where_not_in('id', $ids);
            $this->db->delete('SINTOMA');

            $this->db->trans_commit();
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            return false;
        }
        
        return true;
    }
}

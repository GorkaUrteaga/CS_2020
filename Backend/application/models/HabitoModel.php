<?php

class HabitoModel extends CI_Model
{

    function __construct()
    {
        $this->load->database();
    }

    public function getAll()
    {
        $this->db->from('habito');
        $q = $this->db->get();
        if (count($q->result_array()) == 0)
        {
            return null;
        }

        return $q->result_array();
    }

}

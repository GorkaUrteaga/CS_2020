<?php

class UsuarioModel extends CI_Model
{

    function __construct()
    {
        $this->load->database();
    }

    /**
     * Returns one user
     */
    public function getOne($mail, $pass)
    {
        $array = array('email' => $mail, 'password' => $pass);
        $this->db->from('usuario');
        $this->db->where($array);
        $q = $this->db->get();
        if (count($q->result_array()) == 0)
            return null;

        return $q->result_array()[0];
    }

    public function getUsuarioPorCorreo($mail)
    {
        $array = array('email' => $mail);
        $this->db->from('usuario');
        $this->db->where($array);
        $q = $this->db->get();
        if (count($q->result_array()) == 0)
            return null;

        return $q->result_array()[0];
    }

    public function registro($mail, $pass)
    {
        $ok = false;
        try {
            $this->db->insert('usuario', array(
                'email'  => sha1($mail),
                'password'    => $pass
            ));
            $ok = ($this->db->affected_rows() != 1) ? false : true;
        } catch (Exception $e) {
            $ok = false;
        }

        return $ok;
    }

    public function activacionCuenta($email)
    {
        $ok = false;
        try {
            $data = array(
                'activado' => true
            );            
            $this->db->where('email', $email);
            $this->db->update('usuario', $data);

            $ok = ($this->db->affected_rows() != 1) ? false : true;
        } catch (Exception $e) {
            $ok = false;
        }

        return $ok;
    }
}

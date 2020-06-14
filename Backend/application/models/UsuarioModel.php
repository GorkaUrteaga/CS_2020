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
        if (count($q->result_array()) == 0) {
            return null;
        }

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

    public function generarCodigoRecuperacion($email)
    {
        $ok = true;
        $permitted_chars = '0123456789ABCDEFGIJKLMNOPQRSTUVWXYZ';
        $codigo = 'TEST1';

        $time = time();
        $timeOut = 0;
        try {

            do {
                $codigo = substr(str_shuffle($permitted_chars), 0, 5);
                $this->db->where('codigo_recuperacion', $codigo);
                $q = $this->db->get('usuario');
                $numRows = $q->num_rows();
                $timeOut = time();
            } while ($numRows > 0 && ($timeOut - $time < 10));

            if ($time - $timeOut > 10) {
                $ok = false;
            }

            if ($ok) {
                $data = array(
                    'codigo_recuperacion' => $codigo
                );
                $this->db->where('email', sha1($email));
                $this->db->update('usuario', $data);

                $ok = ($this->db->affected_rows() != 1) ? false : true;
            }
        } catch (Exception $e) {
            $ok = false;
        }

        return $ok ? $codigo : null;
    }

    public function comprobarCodigoRecuperacion($codigo)
    {
        $array = array('codigo_recuperacion' => $codigo);
        $this->db->from('usuario');
        $this->db->where($array);
        $q = $this->db->get();
        if (count($q->result_array()) != 0) {
            return true;
        }

        return false;
    }

    public function cambiarContrasena($email, $password)
    {
        $ok = false;
        try {
            $data = array(
                'password' => $password,
                'codigo_recuperacion' => null
            );
            $this->db->where('email', $email);
            $this->db->update('usuario', $data);

            $ok = ($this->db->affected_rows() != 1) ? false : true;
        } catch (Exception $ex) {
            $ok = false;
        }

        return $ok;
    }

    /**
     * Funcion que devuelve false si ha respondido toda las preguntas y true si tiene alguna por contestar
     */
    public function comprobarPerfil($usuario)
    {
        //return false;
        $habitosSinResponder = false;

        try {
            $this->db->select('count(*) as qHabitos');
            $this->db->from('habito');
            $q = $this->db->get();

            if (count($q->result_array()) == 0) {
                return false;
            }

            $qHabitos = $q->result_array()[0]['qHabitos'];

            if ($qHabitos == null) {
                return false;
            }

            $this->db->select('count(*) as qRespuestas');
            $this->db->where('id_usuario', $usuario);
            $this->db->from('respuesta_habito_usuario');
            $q = $this->db->get();

            if (count($q->result_array()) == 0) {
                return true;
            }

            $qRespuestas = $q->result_array()[0]['qRespuestas'];

            if ($qRespuestas != $qHabitos) {
                $habitosSinResponder = true;
            }
        } catch (Exception $ex) {
            $habitosSinResponder = false;
        }

        return $habitosSinResponder;
    }

    public function getRiesgo($idUsuario)
    {
        $this->db->select('ifnull(riesgo,0) as riesgo');
        $this->db->where('id', $idUsuario);
        $this->db->from('usuario');
        $q = $this->db->get();
        return $q->result_array()[0]['riesgo'];
    }

    public function getIntervalos($idUsuario)
    {
        $this->db->from('intervalo_sintoma');
        $this->db->order_by('id');
        $this->db->where('id_usuario', $idUsuario);
        $q = $this->db->get();

        if (count($q->result_array()) == 0) {
            return null;
        }

        return $q->result_array();
    }

    public function guardarIntervalosUsuario($usuario, $intervalos)
    {
        try {
            $this->db->trans_begin();

            $this->db->where('id_usuario', $usuario);
            $this->db->delete('intervalo_sintoma');
            
            //$this->db->trans_commit();

            //return true;

            foreach ($intervalos as $intervalo) {
                $this->db->insert('intervalo_sintoma', array(
                    'fecha_inicio'  => date('Y-m-d', strtotime($intervalo->fecha_inicio)),
                    'fecha_fin'     => date('Y-m-d', strtotime($intervalo->fecha_fin)),
                    'id_usuario'    => $usuario,
                    'id_sintoma'    => $intervalo->id_sintoma
                ));
            }
            
            $this->db->trans_commit();

        } catch (Exception $ex) {
            $this->db->trans_rollback();
            return false;
        }

        return true;
    }
}

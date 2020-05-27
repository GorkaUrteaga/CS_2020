<?php

class UsuarioModel extends CI_Model {
	
	function __construct()
	{   
		$this->load->database();
	}

	/**
	 * Returns one user
	 */
	public function getOne($mail,$pass) {
		$array = array('email' => $mail,'password' => $pass);
		$this->db->from('usuario');
		$this->db->where($array);
		$q = $this->db->get();
		if (count($q->result_array()) == 0) 
			return null;
		
		return $q->result_array()[0];	
	}

	public function registro($mail,$pass){
		$ok = false;
		try {
			$this->db->insert('usuario', array (
				'email'  => md5($mail),
				'password'	=> $pass
			));
			$ok = ($this->db->affected_rows() != 1) ? false : true;
		} catch (Exception $e) {
			$ok = false;
		}
		
		return $ok;
	}
}
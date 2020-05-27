<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$userModel = model('App\Models\UsuarioModel');
		$users = $userModel->findAll();
		var_dump($users);
		exit;
		return view('welcome_message');
	}

	//--------------------------------------------------------------------

}

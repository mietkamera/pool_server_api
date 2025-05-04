<?php

class Logout extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index($st)
	{
		$sh = new Session;
		if (isset($_SESSION['session_' . $st])) {
			unset($_SESSION['session_' . $st]);
			session_destroy();
			$sh::unsetTempAllowedIP();
			$data = ['returncode' => 200, 'message' => 'session_'.$st.' removed'];
		} else
			$data = ['returncode' => 500, 'message' => 'session var not found'];
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data);
	}

	public function help()
	{
		require('controllers/help.php');
		$this->view->help = new Help();
		$this->view->render('header');
		$this->view->render('logout/help');
		$this->view->render('footer');
	}

}
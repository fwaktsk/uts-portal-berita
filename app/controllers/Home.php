<?php

class Home extends Controller
{
	public function index()
	{
		if (!isset($_SESSION['is_logged_in'])) {
			header('location: ' . BASE_URL . '/login');
			exit;
		}

		$data = [
			'title' => 'Home',
			'navbar' => [
				'Masuk' => [
					'active' => false,
					'href' => BASE_URL . '/login'
				],
				'Daftar' => [
					'active' => false,
					'href' => BASE_URL . '/register'
				]
			]
		];

		$this->view('templates/header', $data);
		$this->view('home/index');
		$this->view('templates/footer');
	}

	public function logout()
	{
		session_destroy();

		header('location: ' . BASE_URL);
		exit;
	}
}

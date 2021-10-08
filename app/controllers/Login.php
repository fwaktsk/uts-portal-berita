<?php

class Login extends Controller
{
	public function index()
	{
		if (isset($_SESSION['is_logged_in'])) {
			header('location: ' . BASE_URL);
			exit;
		}

		$data = [
			'title' => 'Login',
			'navbar' => [
				'Masuk' => [
					'active' => true,
					'href' => '#'
				],
				'Daftar' => [
					'active' => false,
					'href' => BASE_URL . '/register'
				]
			]
		];

		$this->view('templates/header', $data);
		$this->view('account/login/index');
		$this->view('templates/footer');
	}
}

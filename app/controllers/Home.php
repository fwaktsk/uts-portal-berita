<?php

	class Home extends Controller {
		public function index() {
			if(!isset($_SESSION['is_logged_in'])) {
				header('location: ' . BASE_URL . '/login');
				exit;
			}

			$data['title'] = 'Home';

			$this->view('templates/header', $data);
			$this->view('home/index');
			$this->view('templates/footer');
		}

		public function logout() {
			session_destroy();

			header('location: ' . BASE_URL);
			exit;
		}
	}

?>
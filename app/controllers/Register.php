<?php

	class Register extends Controller {
		public function index() {
			if(isset($_SESSION['is_logged_in'])) {
				header('location: ' . BASE_URL);
				exit;
			}

			$data['title'] = 'Register';

			$this->view('templates/header', $data);
			$this->view('account/register/index');
			$this->view('templates/footer');
		}

		public function register() {
			if(($_SESSION['register_error_message'] = $this->model('Register_Model')->_register($_POST)) == '') {
				unset($_SESSION['register_error_message']);
				header('location: ' . BASE_URL);
				exit;
			}
			else {
				// If i remove these two lines below, i would be okay entering "controllers/Register/index"
				header('location: ' . BASE_URL . '/register');
				exit;
			}
		}
	}

?>
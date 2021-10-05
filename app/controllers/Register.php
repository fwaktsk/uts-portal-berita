<?php

	class Register extends Controller {
		public function index() {
			if(isset($_SESSION['is_logged_in'])) {
				header('location: ' . BASE_URL);
				exit;
			}

			$data = [
				'title' => 'Register'
			];

			$this->view('templates/header', $data);

			if($_SERVER['REQUEST_METHOD'] === 'POST') {
				$register_error_msg = $this->model('Register_Model')->_register($_POST);

				if($register_error_msg == '') {
					header('location: ' . BASE_URL);
					exit;
				}
				else {
					$data = [
						'register_error_msg' => $register_error_msg,
						'user_cred' => $_POST
					];

					$this->view('account/register/index', $data);
				}
			}
			else {
				$this->view('account/register/index');
			}

			$this->view('templates/footer');
		}

		public function submit() {
			
		}
	}

?>
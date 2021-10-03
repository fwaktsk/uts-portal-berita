<?php

	class Controller {
		public function view($path, $data = []) {
			require_once '../app/views/' . $path . '.php';
		}

		public function model($path) {
			require_once '../app/models/' . $path . '.php';
			return new $path;
		}
	}

?>
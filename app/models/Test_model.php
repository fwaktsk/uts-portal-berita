<?php

	class Test_model {
		private $name = 'Filbert Mangiri';
		private $db;

		public function __construct() {
			$this->db = new Database;
		}

		public function getName() {
			return $this->name;
		}
	}

?>
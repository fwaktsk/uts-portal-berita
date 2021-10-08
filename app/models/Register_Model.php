<?php

class Register_model
{
	private $dbh;

	public function __construct()
	{
		$this->dbh = new Database;
	}

	public function __destruct()
	{
		unset($this->dbh);
	}

	public function _register($data)
	{
		$register_error_msg = '';

		if (isset($data['g-recaptcha-response']) && !empty($data['g-recaptcha-response'])) {
			$response = (array) json_decode(file_get_contents(
				'https://www.google.com/recaptcha/api/siteverify?secret=' . RECAPTCHA_SECRET .
					'&response=' . $data['g-recaptcha-response'] .
					'&remoteip=' . $_SERVER['REMOTE_ADDR']
			));

			if ($response['success'] === true) {
				try {
					$this->dbh->beginTransaction();

					$this->dbh->prepare(
						'INSERT INTO `accounts` 
							(`email`, `username`, `password`, `first_name`, `last_name`, `birth_date`, `gender`) VALUES 
							(:email, :username, :password, :first_name, :last_name, :birth_date, :gender)'
					);

					$this->dbh->bindValue(':email', $data['email']);
					$this->dbh->bindValue(':username', $data['username']);
					$this->dbh->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT));
					$this->dbh->bindValue(':first_name', $data['first_name']);
					$this->dbh->bindValue(':last_name', $data['last_name']);
					$this->dbh->bindValue(':birth_date', $data['birth_date']);
					$this->dbh->bindValue(':gender', $data['gender']);

					$this->dbh->execute();
					$this->dbh->commit();

					$_SESSION['is_logged_in'] = true;

					$_SESSION['email'] = $data['email'];
					$_SESSION['id'] = $this->dbh->lastInsertId();
					$_SESSION['username'] = $data['username'];
					$_SESSION['first_name'] = $data['first_name'];
					$_SESSION['last_name'] = $data['last_name'];
				} catch (PDOException $e) {
					$this->dbh->rollBack();

					$register_error_msg = 'Gagal mendaftar. Silakan coba beberapa saat lagi';

					if ($e->getCode() == 23000) {
						$register_error_msg = 'Email atau username telah digunakan';
					} else {
						throw $e;
					}
				}
			} else
				$register_error_msg = 'Verifikasi RECAPTCHA gagal';
		} else
			$register_error_msg = 'Silakan isi verifikasi RECAPTCHA';

		return $register_error_msg;
	}

	public function _emailCheck($email)
	{
		try {
			$this->dbh->prepare('SELECT `id` FROM `accounts` WHERE `email` = :email');
			$this->dbh->bindValue(':email', $email);

			$this->dbh->execute();

			if ($this->dbh->rowCount()) {
				return 'false';
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		return 'true';
	}

	public function _usernameCheck($username)
	{
		try {
			$this->dbh->prepare('SELECT `id` FROM `accounts` WHERE `username` = :username');
			$this->dbh->bindValue(':username', $username);

			$this->dbh->execute();

			if ($this->dbh->rowCount()) {
				return 'false';
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		return 'true';
	}
}

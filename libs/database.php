<?php

class Database
{

	private $pdo;

	public function __construct()
	{

		$this->pdo = new PDO("mysql:host="._DB_HOST_.";dbname="._DB_NAME_, _DB_USER_, _DB_PASS_);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}

	public function is_valid_ip($url)
	{

		$result = false;
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		try {
			$stmt = $this->pdo->prepare('SELECT path FROM valid_ips WHERE ip=:ip');
			$stmt->execute(array(':ip' => $ip));
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($rows as $record) {
				if (strpos($url, $record['path']) !== false) {
					$result = true;
					break;
				}
			}
		} catch (PDOException $e) {
			$error = $e->getMessage();
			die('error in database operation: ' . $error);
		}

		return $result;
	}

	public function is_valid_admin_login($email, $password)
	{

		$result = false;

		try {
			$stmt = $this->pdo->prepare('SELECT * FROM users WHERE user_email=:email');
			$stmt->execute(array(':email' => $email));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($row['user_password'] == md5($password)) {
				$result = true;
			}
		} catch (PDOException $e) {
			$error = $e->getMessage();
			die('error in database operation: ' . $error);
		}

		return $result;
	}
}

?>
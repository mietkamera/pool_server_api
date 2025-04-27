<?php

class Database
{

	private $pdo;

	public function __construct()
	{
		$this->pdo = new PDO("mysql:host=" . _DB_HOST_ . ";dbname=" . _DB_NAME_, _DB_USER_, _DB_PASS_);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function usageAllowedFromIP($ip)
	{
		$result = false;
		try {
			$stmt = $this->pdo->prepare('SELECT * FROM allow_usage_from WHERE ip=:ip');
			$stmt->execute(array(':ip' => $ip));
			if ($stmt->rowCount() > 0)
				$result = true;
		} catch (PDOException $e) {
			$error = $e->getMessage();
			die('error in database operation: ' . $error);
		}

		return $result;
	}

	public function noLoginRequiredFromIP($ip, $url)
	{
		$result = false;
		try {
			$stmt = $this->pdo->prepare('SELECT path FROM no_login_required_from WHERE ip=:ip');
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
}
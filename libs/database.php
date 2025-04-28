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
			$stmt->execute([':ip' => $ip]);
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
			$stmt->execute([':ip' => $ip]);
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

	public function setTempAllowedIP($ip) {
		try {
			$stmt = $this->pdo->prepare('INSERT INTO allow_usage_from (ip,description) VALUES(:ip,"from login script")');
			$stmt->execute([':ip' => $ip]);
			if (_DEBUG_LOG_)
			error_log('set temporary allowed ip: '.$ip);
		} catch (PDOException $e) {
			$error = $e->getMessage();
			die('error in database operation: ' . $error);
		}
	}

	public function unsetTempAllowedIP($ip) {
		try {
			$stmt = $this->pdo->prepare('DELETE FROM allow_usage_from WHERE ip=:ip AND tmp=TRUE');
			$stmt->execute([':ip' => $ip]);
			if (_DEBUG_LOG_)
			error_log('unset temporary allowed ip: '.$ip);
		} catch (PDOException $e) {
			$error = $e->getMessage();
			die('error in database operation: ' . $error);
		}
	}
}
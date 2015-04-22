<?php
class DB {
	public static function get() {
		$conn = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
		if ($conn->connect_errno) {
			throw new Exception('無法連線至資料庫');
		}
		if (!$conn->set_charset("utf8")) {
			throw new Exception('無法正確連線');
		}
		return $conn;
	}
}


<?php namespace Models;
class Resources {
	public static function all($conn) {
		if (!($stmt = $conn->prepare("SELECT `host`, `cpu_cores`, `memory`, `load1`, `load5`, `load15`, `used_memory`, `last_updated` FROM `resources` ORDER BY `ordering`"))) {
			throw new Exception("stmt error");
		}
		$stmt->execute();
		$stmt->bind_result($host, $cpu_cores, $memory, $load1, $load5, $load15, $used_memory, $last_updated);
		$data = array();
		while ($stmt->fetch()) {
			$data[] = array(
				'host'=> $host,
				'cpu_cores'=> $cpu_cores,
				'memory' => (int)$memory,
				'load1'=> (double)$load1,
				'load5'=> (double)$load5,
				'load15'=> (double)$load15,
				'used_memory' => (int)$used_memory,
				'last_updated'=> \DateTime::createFromFormat('Y-m-d H:i:s', $last_updated)->format(\DateTime::ISO8601)
			);
		}
		$stmt->close();
		return $data;
	}
	public static function update($conn, $host, $load1, $load5, $load15, $used_memory) {
		if (!($stmt = $conn->prepare("UPDATE `resources` SET `load1` = ?, `load5` = ?, `load15` = ?, `used_memory` = ?, `last_updated` = NOW() WHERE `host` = ?"))) {
			throw new Exception("stmt error");
		}
		$stmt->bind_param("dddis", $load1, $load5, $load15, $used_memory, $host);
		if (!($stmt->execute())) {
			throw new Exception("execute error");
		}
	}
}

<?php namespace Models;
class Resources {
	public static function all($conn) {
		if (!($stmt = $conn->prepare("SELECT `host`, `cpu_cores`, `memory`, `load1`, `load5`, `load15`, `used_memory`, `last_updated` FROM `resources` WHERE `group`='mslab' ORDER BY `order`"))) {
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
				'last_updated'=> date_create_from_format('Y-m-d H:i:s', $last_updated)->format('c')
			);
		}
		$stmt->close();
		return $data;
	}
}

<?php
require_once('config.php');
require_once('libs/json.php');
function my_autoloader($class) {
    include('libs/' . $class . '.class.php');
}
spl_autoload_register('my_autoloader');

if ($_SERVER['REQUEST_URI'] == '/status/repo/update') {
	exec('git pull origin master', $output);
	foreach($output as $line) {
		echo $line . "\n";
	}
} else if ($_SERVER['REQUEST_URI'] == '/status/get') {
	try {
		$conn  = DB::get();
		$stmt = $conn->prepare("SELECT `host`, `cpu_cores`, `memory`, `load1`, `load5`, `load15`, `used_memory`, `last_updated` FROM `resources` WHERE `group`='mslab' ORDER BY `order`");
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
				'last_updated'=> $last_updated
			);
		}
		$stmt->close();
		json($data, true);
	} catch (Exception $e) {
		http_response_code(500);
	}
}

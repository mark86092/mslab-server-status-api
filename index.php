<?php
require_once('config.php');
function my_autoloader($class) {
    include('libs/' . $class . '.class.php');
}
spl_autoload_register('my_autoloader');

$route = new Route();

$route->get('#^/repo/update#', function() {
	header("Content-Type: text/plain");
	exec('git pull origin master', $output);
	foreach($output as $line) {
		echo $line . "\n";
	}
});

$route->get('#^/$#', function() {
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
		
		header("Access-Control-Allow-Orgin: *");
		header("Access-Control-Allow-Methods: *");
		header("Content-Type: application/json");

		echo json_encode($data);
	} catch (Exception $e) {
		http_response_code(500);
	}

});

$route->parse();

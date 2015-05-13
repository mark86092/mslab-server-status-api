<?php
require_once('config.php');
function my_autoloader($class) {
    include 'libs/' . str_replace('\\', '/', $class) . '.php';
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
		$data = \Models\Resources::all($conn);
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: *");
		header("Content-Type: application/json");
		echo json_encode($data);
	} catch (Exception $e) {
		http_response_code(500);
	}

});

$route->get('#^/terminal$#', function() {
	require('terminal.php');
	$conn  = DB::get();
	$data = \Models\Resources::all($conn);
	print_in_terminal($data);
});

$route->parse();

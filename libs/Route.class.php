<?php
class Route {
	protected $method;
	protected $query = '/';
	protected $paths = array();
	public function Route() {
		$this->parseQuery();
		$this->parseMethod();
	}
	private function parseQuery() {
		$a = strrpos($_SERVER['SCRIPT_NAME'], '/index.php');
		$b = substr($_SERVER['SCRIPT_NAME'], 0, $a);
		$this->query = substr($_SERVER['REQUEST_URI'], strlen($b));
	}
	/*
	 * Detect only GET, POST method
	 * HTTP_METHOD --> $this->method (small case)
	 */
	private function parseMethod() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->method = 'post';
		} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->method = 'get';
		}
	}
	public function register($pattern, $method, $callback) {
		$this->paths[] = array('pattern' => $pattern, 'method' => $method, 'callback' => $callback);
	}
	public function get($pattern, $callback) {
		$this->register($pattern, 'get', $callback);
	}
	public function post($pattern, $callback) {
		$this->register($pattern, 'post', $callback);
	}

	public function parse() {
		foreach ($this->paths as $path) {
			if ($path['method'] != $this->method) {
				continue;
			}
			if (preg_match($path['pattern'], $this->query, $matches) == 0) {
				continue;
			}
			call_user_func($path['callback'], $matches);
			return;
		}
	}
	public function debug() {
		print_r($this);
	}
}

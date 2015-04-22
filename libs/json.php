<?php
/*
	v1.0 2013.05.11
	author: ycchen
*/
function json($data, $HAScallback = false) {
	header('Content-type: application/json');
	$c = json_encode($data);
	if ($HAScallback) {
		if (isset($_GET['callback'])) {
			echo $_GET['callback'] . '(' . $c .')';
		} else {
			echo $c;
		}
    } else {
        echo $c;
    }
}

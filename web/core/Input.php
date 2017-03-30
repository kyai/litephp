<?php 

class Input{

	function get(string $name=''){
		if(empty($name)) return $_GET;
		return $_GET[$name] ? $_GET[$name] : null;
	}

	function post(string $name=''){
		if(empty($name)) return $_POST;
		return $_POST[$name] ? $_POST[$name] : null;
	}
}
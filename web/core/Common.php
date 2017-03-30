<?php 

function P($obj){
	print_r('<pre>');
    print_r($obj);
    print_r('<pre>');
}

function load_class($name,$path = 'core'){
	require_once BASEPATH . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . "$name.php";
	return new $name();
}
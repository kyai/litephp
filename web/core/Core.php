<?php 

define('DIR_C',BASEPATH.'/controllers/');
define('DIR_V',BASEPATH.'/views/');

require_once "smarty/libs/Smarty.class.php";

require_once "Common.php";
require_once "Controller.php";


if(isset($_SERVER['PATH_INFO'])){
	$pathinfo = explode('/', $_SERVER['PATH_INFO']);
    array_shift($pathinfo);
}else{
    exit('error : pathinfo');
}

// p($pathinfo);

if(is_array($pathinfo) && !empty($pathinfo)){

    if(file_exists(DIR_C.$pathinfo[0].'.php')){
        $C = $pathinfo[0];
        if(isset($pathinfo[1])){
            $M = $pathinfo[1];
        }
    }else{
        if(isset($pathinfo[1])){
            $M = array_pop($pathinfo);
            $C = implode('/',$pathinfo);
        }
    }
    
}else{
    $C = 'index';
    $M = 'index';
}

if(isset($C) && isset($M)){
    $F = str_replace('\\', '/', DIR_C.$C) . '.php';
    $C = @array_pop(explode('/', $C));
    $M = $M;

    // echo 'f:'.$F.'<br>';
    // echo 'c:'.$C.'<br>';
    // echo 'm:'.$M.'<br>';

    if(file_exists($F)){
        require_once $F;
        if(class_exists($C)){
            $O = new $C;
            if(method_exists($O,$M)){
                if(is_callable(array($O,$M))){
                    $O -> $M();
                }else{
                    exit('403');
                }
            }else{
                exit('404');
            }
        }else{
            exit('404');
        }
    }else{
        exit('404');
    }
}else{
    exit('500');
}
<?php 
$cfg_host='127.0.0.1'.';port=3306';
$cfg_user='root';
$cfg_pasw='root';
$cfg_dbname='vd';


function __autoload($className) {
	$classPath = dirname(__file__)."/../library/".$className.'.class.php';
	$classPath2 = dirname(__file__)."/../model/".$className.'.class.php';
	if (file_exists($classPath)) {
		require_once ($classPath);
	} elseif (file_exists($classPath2)) {
		require_once ($classPath2);
	} else {
		echo "class path not found!";
	}
}
<?php 
require_once '../Cfg/config.php';
$user = $_REQUEST['user'];

if (is_null($user)) {
	die();
}

$task = Task::getInstance();
$task->updateByUser($user);


?>
<?php
require_once '../Cfg/config.php';
$video = $_REQUEST['video'];


if (is_null($video)) {
	die();
}


$task = Task::getInstance();
$task->saveDescriptionByYoukuId($video);
















<?php 
require_once '../Cfg/config.php';


$queue = new SaeTaskQueue('update');
$data = Data::getInstance();
$userList = $data->getAllUserList();
//批量添加任务

$array = array();
for ($i = 0; $i < count($userList); ++$i) {
	$array[] = array('url'=>"http://hidota.sinaapp.com/Data/script/updatebyuser.php", "postdata"=>"user=".$userList[$i]);
}

//@todo 更新缓存列表
//$array[] = array('url'=>"http://hidota.sinaapp.com/Data/script/updatevideolist.php");

$queue->addTask($array);
//将任务推入队列
$ret = $queue->push();
var_dump($ret);


?>
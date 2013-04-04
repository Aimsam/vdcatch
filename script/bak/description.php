<?php 
require_once '../Cfg/config.php';

$queue = new SaeTaskQueue('description');
$data = Data::getInstance();
$list = $data->getUndescriptionVideos();
//批量添加任务

$array = array();
for ($i = 0; $i < count($list); ++$i) {
	$array[] = array('url'=>"http://hidota.sinaapp.com/Data/script/descriptionbyvideo.php", "postdata"=>"video=".$list[$i]);
}
$queue->addTask($array);
//将任务推入队列
$ret = $queue->push();
var_dump($ret);

?>
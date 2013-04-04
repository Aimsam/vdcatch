<?php 
require_once dirname(__file__).'/../config/config.php';


//初始化存储所有数据
$util = Util::getInstance();
$util->saveAllVideos();




?>
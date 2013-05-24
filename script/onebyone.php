<?php 
require_once dirname(__file__).'/../config/config.php';


$ids = "d,sdfsdf,sdfsdf";

//初始化存储所有数据
$util = Util::getInstance();
$util->saveVideosByIds($ids);




?>
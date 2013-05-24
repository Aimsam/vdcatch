<?php 
require_once dirname(__file__).'/../config/config.php';


$ids = "UMzE2OTY2NjUy,UMzEzMTUwNDIw,UMzUwNTQ4MTEy,UMjIxMTYyOTI0,UMzk2ODA1OTY4,UMjQyNzc4MTAw,UNjk4OTI0NzY=,UMTU0NjE3NDk2,UMzQ1OTA2ODE2,UMzEwNTQ1NjA0,UMzA1OTQ5NjY0,UMTAxMTA2MDY0,UMzA0MDY4OTE2";

//初始化存储所有数据
$util = Util::getInstance();
$util->saveVideosByIds($ids);




?>
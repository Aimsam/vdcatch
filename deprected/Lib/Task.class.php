<?php 
class Task {
	private static $instance;
	private $data;
	private $youku;
	
	private function __construct() {
		$this->data = Data::getInstance();
		$this->youku = Youku::getInstance();
	}
	
	public static function getInstance() {
		if (is_null(self::$instance) || !isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function saveAllUserVideos() {
		$userList = $this->data->getAllUserList();
		for ($i = 0; $i < count($userList); ++$i) {
			$this->saveAllVideosByUser($userList[$i]);
		}
	}
	
	public function saveAllVideosByUser($user) {
		$this->youku->setUser_id($user);
		$pageNum = $this->youku->getUserLastPage();
		for ($i = 0; $i < $pageNum; ++$i) {
			$list = $this->youku->getUserVideosByPage($i);
			$this->data->saveVideoList($list);
		}
	}
	
	public function updateByUser($user) {
		$this->youku->setUser_id($user);
		$videoList = $this->youku->getUserVideosByPage(1);
		$this->data->saveVideoList($videoList);
	}
	
	public function updateAllUserVideos() {
		$userList = $this->data->getAllUserList();
		for ($i = 0; $i < count($userList); ++$i) {
			$this->updateByUser($userList[$i]);
		}
	}
	
	public function saveDescriptionByYoukuId($video_youku_id) {
		$description = $this->youku->getVideoDescription($video_youku_id);
echo $description."\n";		
		if ($description != null) {
			$this->data->saveVideoDescription($video_youku_id, $description);
		}
	}
}




?>
<?php
class Util {
	private static $instance;
	
	public static function getInstance() {
		if (is_null(self::$instance) || !isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	//保存所有
	public function saveAllVideos() {
		$db = new Db;
		$rs = $db->query('select * from author where type = 1');
		$authorList = array();
		foreach ($rs as $row) {
			$author['id'] = $row['id'];
			$author['node_id'] = $row['node_id'];
			$authorList[] = $author;
		}
		foreach ($authorList as $row) {
			$this->saveAllVideosById($row['id'], $row['node_id']);
		}
	}
	
	/**
	 * 
	 * @param int $author_id
	 * @param int $node_id
	 */
	public function saveAllVideosById($author_id, $node_id) {
		$catcher = Catcher::getInstance();
		$video = Video::getInstance();
		$catcher->setAuthor_id($author_id);
		$size = $catcher->getUserLastPage();
		for ($i = 1; $i <= $size; ++$i) {
			$videoList = $catcher->getUserVideos($node_id, $i);
			$video->saveVideoList($videoList);
		}
	}
	
	public function updateVideosById($author_id, $node_id) {
		$catcher = Catcher::getInstance();
		$video = Video::getInstance();
		$catcher->setAuthor_id($author_id);
		$videoList = $catcher->getUserVideos($node_id, 1);
		$video->saveVideoList($videoList);
	}
	
	
	public function update() {
		$db = new Db;
		$rs = $db->query('select * from author where type = 1');
		$authorList = array();
		foreach ($rs as $row) {
			$authorList[] = $row['id'];
		}
		foreach ($authorList as $row) {
			$this->updateVideosById($row);
		}
	}

	public function init() {
		$this->saveAllVideos();
	}
	
	
}



?>
<?php 

class Video {
	private static $instance;
	private $db;
	
	public function __construct() {
		$this->db = new Db();
	}
	
	public static function getInstance() {
		if (is_null(self::$instance) || !isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function saveVideo($video) {
		$rs = $this->db->query("select 1 from video where id = '".$video['id']."'");
		$row = $rs->fetch();
		if ($row == false) {
			$stmt = $this->db->prepare(
					"insert into video (id, author_id, node_id, title, thumbnail, quality,
					 duration, published, description, user_id, type) values(?,?,?,?,?,?,?,?,?,1,1)");
			$temp = 1;		
			$stmt->bindParam(1, $video['id']);
			$stmt->bindParam(2, $video['author_id']);
			$stmt->bindParam(3, $video['node_id']);
			$stmt->bindParam(4, $video['title']);
			$stmt->bindParam(5, $video['thumbnail']);
			$stmt->bindParam(6, $video['quality']);
			$stmt->bindParam(7, $video['duration']);
			$stmt->bindParam(8, $video['published']);
			$stmt->bindParam(9, $video['description']);
echo $stmt->execute() != 1?"sql error\n\r":"user = ".$video['author_id']."----video_id = ".$video['id']." node = ".$video['node_id']."----saved\n";
		} else {
echo "already saved!\n\r";
		}
	}	
	
	public function saveVideoList($videoList) {

		for($i = 0; $i < count ($videoList); ++ $i) {
			$this->saveVideo ($videoList[$i]);
		}
	}
	
}
















?>
<?php 
/**
 * 
 * @author aimsam
 *
 */
class Data {
	private static $instance;
	private $db;
	
	private function __construct() {
		$this->db = new Db();
	}
	
	public static function getInstance() {
		if (is_null(self::$instance) || !isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * 
	 * @param Video $video
	 */
	public function saveVideo($video) {
		$rs = $this->db->query ( "select 1 from video where video_youku_id = '". $video->getVideo_youku_id()."'" );
		$row = $rs->fetch();
		if ($row == false) {
			$stmt = $this->db->prepare ( "insert into video (video_youku_id, user_youku_id, name, image,"."quality, length, date, type) values(?,?,?,?,?,?,?,?)" );
			$stmt->bindParam (1, $video->getVideo_youku_id());
			$stmt->bindParam (2, $video->getUser_youku_id());
			$stmt->bindParam (3, $video->getName());
			$stmt->bindParam (4, $video->getImage());
			$stmt->bindParam (5, $video->getQuality());
			$stmt->bindParam (6, $video->getLength());
			$stmt->bindParam (7, $video->getDate());
			$stmt->bindParam (8, $video->getType());
			$stmt->execute();
			echo 'user = '.$video->getUser_youku_id()."----video_id = ".$video->getVideo_youku_id()."----saved\n";
		} else {
			$stmt = $this->db->prepare ( "update video set video_youku_id = ?, user_youku_id = ?, name = ?, image = ?,".
					"quality = ?, length = ?, date = ?, type = ? where video_youku_id = '".$video->getVideo_youku_id()."'" );
			$stmt->bindParam (1, $video->getVideo_youku_id());
			$stmt->bindParam (2, $video->getUser_youku_id());
			$stmt->bindParam (3, $video->getName());
			$stmt->bindParam (4, $video->getImage());
			$stmt->bindParam (5, $video->getQuality());
			$stmt->bindParam (6, $video->getLength());
			$stmt->bindParam (7, $video->getDate());
			$stmt->bindParam (8, $video->getType());
			$stmt->execute();
			echo 'user = '.$video->getUser_youku_id()."----video_id = ".$video->getVideo_youku_id()."----updated\n";
		}
	}	
	
	public function saveVideoList($videoList) {
		for($i = 0; $i < count ($videoList); ++ $i) {
			$this->saveVideo ($videoList[$i]);
		}
	}
	
	public function getAllUserList() {
		$rs = $this->db->query ( 'select * from author' );
		$data = array ();
		while ( ($row = $rs->fetch ()) != null ) {
			array_push ( $data, $row['youku_id'] );
		}
		return $data;
	}
	
	/**
	 * 保存描述
	 * @param unknown_type $video_youku_id
	 * @param unknown_type $description
	 */
	public function saveVideoDescription($video_youku_id, $description) {
		$sql = "update video set description = '$description' where video_youku_id = '$video_youku_id'";
		$this->db->exec($sql) ;
	}

	/**
	 * 获得没有描述的videos
	 */
	public function getUndescriptionVideos() {
		$rs = $this->db->query ('select video_youku_id from video where isnull(description) limit 100');
		$data = array ();
		while ( ($row = $rs->fetch ()) != null ) {
			array_push ( $data, $row[0] );
		}
		return $data;
	}
}

?>
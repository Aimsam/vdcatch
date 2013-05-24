<?php
class Util {
	private static $instance;
	
	public static function getInstance() {
		if (is_null(self::$instance) || !isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function thumbnail() {
	    $catcher = Catcher::getInstance();
	    //$catcher->getThumbnail2("XNTU4NDE3ODky");
	    $db = new Db;
        $rs = $db->query('select * from video where thumbnail_2 = ""');
        $authorList = array();
        foreach ($rs as $row) {
            $id = $row['id'];
            $thumbnail = $catcher->getThumbnail2($id);
echo $thumbnail."\n\r";
            if ($thumbnail != null && $thumbnail != "") {
                $sql = "update video set thumbnail_2 = '$thumbnail' where id = '$id'";
                $rs = $db->query($sql);
            }
        }
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

    //根据ids
	public function saveVideosByIds($ids) {
	    $arr = explode(",", $ids);
	    $str = "";
	    foreach ($arr as $row) {
	        $str .= '"'.$row .'",';
	    }
	    $db = new Db;
        $sql = 'select * from author where type = 1 and id in ('.$str.'"ddd")';
        $rs = $db->query($sql);
        $authorList = array();
        foreach ($rs as $row) {
            $author['id'] = $row['id'];
            $author['node_id'] = $row['node_id'];
            $authorList[] = $author;
        }
        var_dump($authorList);
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
			$author['id'] = $row['id'];
			$author['node_id'] = $row['node_id'];
			$authorList[] = $author;
		}
		foreach ($authorList as $row) {
			$this->updateVideosById($row['id'], $row['node_id']);
		}
	}

	public function init() {
		$this->saveAllVideos();
	}
	
	
}



?>
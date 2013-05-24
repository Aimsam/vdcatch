<?php 
class Catcher {
	const CLIENT_ID = "74f3668e4f16ef9f";
	const URL_VIDEOS_BY_USER = "https://openapi.youku.com/v2/videos/by_user.json";
	const URL_VIDEOS_BASIC_BATCH = "https://openapi.youku.com/v2/videos/show_basic_batch.json";
	const URL_THUMB_NAIL = "http://api.youku.com/player/getPlayList/VideoIDS/";
	const PAGE = 1;
	const COUNT = 20;
	private static $instance = null;
	private $author_id;
	
	public static function getInstance() {
		if (is_null(self::$instance) || !isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function getThumbnail2($id) {
	    $url = self::URL_THUMB_NAIL.$id;
	    $json = file_get_contents($url);
	    $reg = '$"logo":"(.*?)","seed"$';
        preg_match_all($reg, $json, $matches);
        if(!is_null($matches[1][0])) {
            return str_replace("\\", "", $matches[1][0]);
        }
	}



	public function getUserLastPage($page = self::PAGE, $count = self::COUNT) {
		$url = self::URL_VIDEOS_BY_USER."?client_id=".self::CLIENT_ID.
		"&page=".$page."&count=".$count."&user_id=".$this->author_id;
		$json = file_get_contents($url);
		$json = json_decode($json);
		$total = $json->total;
		
		return ceil($total/$count);
	}
	
	//@todo
	public function getPlayListLastPageBy() {
		
	}
	
	//@todo
	public function getPlayListVideos($page = self::PAGE, $count = self::COUNT) {
		
	}

	public function getUserVideos($node_id, $page = self::PAGE, $count = self::COUNT) {
		$url = self::URL_VIDEOS_BY_USER."?client_id=".self::CLIENT_ID.
		"&page=".$page."&count=".$count."&user_id=".$this->author_id;
		$json = file_get_contents($url);
		$json = json_decode($json);
		$videoList = array();
		$video_ids = "&video_ids=";
		foreach ($json->videos as $row) {
			$video = array();
			$video['id'] = $row->id;
			$video_ids .= $row->id.",";
			$video['author_id'] = $this->author_id;
			$video['node_id'] = $node_id;
			$video['title'] = $row->title;
			$video['thumbnail'] = $row->thumbnail;
			$video['quality'] = '';
			$video['duration'] = gmdate("H:i:s", $row->duration);
			$video['published'] = $row->published;
			$video['description'] = '';
			$videoList[] = $video;
		}
		$url = self::URL_VIDEOS_BASIC_BATCH."?client_id=".self::CLIENT_ID.$video_ids;
		$json = file_get_contents($url);
		$json = json_decode($json);
		$i = 0;
		foreach ($json->videos as $row) {
			$videoList[$i++]['description'] = $row->description;
		}
		
		return $videoList;
	}
	
	/**
	 * @return the $author_id
	 */
	public function getAuthor_id() {
		return $this->author_id;
	}

	/**
	 * @param field_type $author_id
	 */
	public function setAuthor_id($author_id) {
		$this->author_id = $author_id;
	}

	
	
	
}


?>
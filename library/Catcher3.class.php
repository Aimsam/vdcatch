<?php 
class Catcher3 {
	private static $instance = null;
	private $ch;
	private $author_id;
	
	private function __construct() {
		$this->ch = curl_init ();
		curl_setopt ( $this->ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $this->ch, CURLOPT_RETURNTRANSFER, true );
	}
	
	public static function getInstance() {
		if (is_null(self::$instance) || !isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function init() {
		$this->ch = curl_init ();
		curl_setopt ( $this->ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $this->ch, CURLOPT_RETURNTRANSFER, true );
	}
	
	/**
	 * 获得用户最后一页
	 * @return NULL
	 */
	public function getUserLastPage() {
		if (empty($this->author_id)) {
			return NULL;
		}
		$url = "http://i.youku.com/u/".$this->author_id."/videos";
		$this->init();
		curl_setopt ($this->ch, CURLOPT_URL, $url);
		$content = curl_exec ($this->ch);
		preg_match_all('/最后"><a  href=".*_page_(\d{1,3})?">/', $content, $matches);
		if (empty($matches[1][0])) {
			//只有一页
			return 1;
		} else {
			return $matches[1][0];
		}
	}
	
	public function getVideosByPage($page) {
		if (empty($this->author_id)) {
			return NULL;
		}
		$url = "http://i.youku.com/u/".$this->author_id."/videos/order_1_view_1_page_".$page;
		$this->init();
		curl_setopt($this->ch, CURLOPT_URL, $url);

		return $this->getVideos();
	}
	
	/**
	 * 获得用户视频
	 */
	private function getVideos() {
		$content = curl_exec($this->ch);
		preg_match_all("/<a _hz=\"l_v_img\" title=\"(.*)\" target=\"_blank\"".
				" href=\".*id_(.*)\.html\">[\S\s]*?<li class=\"v_thumb\">.*src=\"(.*?)\"[\S\s]*?<li class=\"v_ishd\">([\S\s]*?)<\/[\S\s]*?"
				." .*\"[\S\s]*?\"num\">(.*)?<\/span><span[\s\S]*?发布时间:<\/label><span>(.*)<\/span>/", $content, $matches);
		for($i = 0; $i < count($matches[6]); ++ $i) {
			if (preg_match('/[前]{2}/i', $matches[6][$i])) {
				$matches [6][$i] = date("m").'-'.(date("d"));
			}
			else if (preg_match('/[昨]{2}/i', $matches[6][$i])) {
				$matches [6] [$i] = date("m") . '-' . (date ( "d" ) - 1);
			}
			if (!preg_match ( '/\d{4}/i', $matches [6] [$i] )) {
				$matches [6] [$i] = date("Y") . "-" . $matches [6] [$i];
			}
			if (preg_match_all( '/(.*) /i', $matches [6] [$i], $temp)) {
				$matches [6] [$i] = $temp[1];
			}
		}
		
		for($i = 0; $i < count($matches[4]); ++ $i) {
			if(preg_match_all( '/<span class=\"ico__SD\" title=\"(.*)\"/i', $matches [4] [$i], $temp)) {
				$matches[4][$i] = $temp[1][0];
			} else {
				$matches[4][$i] = "标清";
			}
		}
		$videoList = array();
		$length = count($matches[5]);
		for ($i = 0; $i < $length; ++$i) {
			$video = array('id'=>$matches[2]);
			$video['id'] = $matches[2][$i];
			$video['author_id'] = $this->author_id;
			$video['node_id'] = 1;
			$video['title'] = $matches[1][$i];
			$video['image'] = $matches[3][$i];
			$video['quality'] = $matches[4][$i];
			$video['length'] = $matches[5][$i];
			$video['date'] = $matches[6][$i];
			$video['type'] = 1;
			array_push($videoList, $video);
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
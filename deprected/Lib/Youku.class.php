<?php
/**
 * 
 * @todo album 
 * @author aimsam
 *
 */
class Youku {
	
	private static $instance = null;
	private $user_id;
	private $album_id;
	private $ch;
	private $url;
	
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
	
	public function getVideoDescription($video_youku_id) {
		if (empty($video_youku_id)) {
			return null;
		}
		$this->url = "http://v.youku.com/v_show/id_".$video_youku_id.".html";
		$this->init ();
		curl_setopt ( $this->ch, CURLOPT_URL, $this->url );
		$content = curl_exec ( $this->ch );
		preg_match_all("@<div class=\"info\" id=\"long\" style=\"display:none;\">[\s\S]*?<div class=\"item\">([\s\S]*?)<\/div>[\s\S]*?<div class=\"item\"><span class=\"label\">分类:@", $content, $matches);
		if (!empty($matches[1][0])) {
			return $matches[1][0]; 
		} 
		return "...";
	}
	
	/**
	 * 
	 * @param unknown_type $page
	 * @return NULL|multitype:
	 */
	public function getUserVideosByPage($page) {
		if (empty ( $this->user_id )) {
			return NULL;
		}
		$this->url = "http://i.youku.com/u/" . $this->user_id . "/videos/order_1_view_1_page_" . $page;
		$this->init ();
		curl_setopt ( $this->ch, CURLOPT_URL, $this->url );
		
		return $this->getUserVideo();
	}
	
	/**
	 * 私有方法获得用户视频
	 */
	private function getUserVideo() {
		$content = curl_exec ( $this->ch );
		preg_match_all("/<a _hz=\"l_v_img\" title=\"(.*)\" target=\"_blank\"".
				" href=\".*id_(.*)\.html\">[\S\s]*?<li class=\"v_thumb\">.*src=\"(.*?)\"[\S\s]*?<li class=\"v_ishd\">([\S\s]*?)<\/[\S\s]*?"
				." .*\"[\S\s]*?\"num\">(.*)?<\/span><span[\s\S]*?发布时间:<\/label><span>(.*)<\/span>/", $content, $matches);
		for($i = 0; $i < count ( $matches [6] ); ++ $i) {
			if (preg_match ( '/[前]{2}/i', $matches [6] [$i] )) {
				$matches [6] [$i] = date ( "m" ) . '-' . (date ( "d" ));
			}
			else if (preg_match ( '/[昨]{2}/i', $matches [6] [$i] )) {
				$matches [6] [$i] = date ( "m" ) . '-' . (date ( "d" ) - 1);
			}
			if (!preg_match ( '/\d{4}/i', $matches [6] [$i] )) {
				$matches [6] [$i] = date ( "Y" ) . "-" . $matches [6] [$i];
			}
			if (preg_match_all( '/(.*) /i', $matches [6] [$i], $temp)) {
				$matches [6] [$i] = $temp[1];
			}
		}
		for($i = 0; $i < count ( $matches [4] ); ++ $i) {
			if(preg_match_all( '/<span class=\"ico__SD\" title=\"(.*)\"/i', $matches [4] [$i], $temp)) {
				$matches[4][$i] = $temp[1][0];
			} else {
				$matches[4][$i] = "标清";
			}
		}
		$data = array();
		for ($i = 0; $i < count ( $matches [5] ); ++$i) {
			$video = new Video($matches[2][$i], $this->user_id, $matches[1][$i],
					$matches[3][$i], $matches[4][$i], $matches[5][$i],
					is_array($matches[6][$i])?$matches[6][$i][0]:$matches[6][$i], 1);
			array_push($data, $video);
		}
		curl_close($this->ch);
		//var_dump($data);
		return $data;
	}
	
	/**
	 * 获得用户最后一页
	 * @return NULL
	 */
	public function getUserLastPage() {
		if (empty ( $this->user_id )) {
			return NULL;
		}
		$this->url = "http://i.youku.com/u/" . $this->user_id . "/videos";
		$this->init ();
		curl_setopt ( $this->ch, CURLOPT_URL, $this->url );
		$content = curl_exec ( $this->ch );
		preg_match_all('/最后"><a  href=".*_page_(\d{1,3})?">/', $content, $matches);
		if (empty($matches[1][0])) {
//echo 'user'.$this->user_id."---不能找到最后一页";
			return 1;
		} else {
			return $matches[1][0];
		}
	}	
	
	public function test() {
		$this->user_id = "sdfsf";
		echo $this->user_id;
	}
	
	/**
	 * @return the $user_id
	 */
	public function getUser_id() {
		return $this->user_id;
	}

	/**
	 * 
	 * @param string $user_id
	 */
	public function setUser_id($user_id) {
//@todo 合法验证			
		$this->user_id = $user_id;
	}

	
	
	
}
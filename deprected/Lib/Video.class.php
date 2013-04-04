<?php


class Vide222o {
	protected $video_youku_id;
	protected $user_youku_id;
	protected $name;
	protected $image;
	protected $quality;
	protected $length;
	protected $date;
	protected $type;
	protected $description;
	
	public function __construct($video_youku_id, $user_youku_id, $name, $image, $quality, $length, $date, $type, $description = null) {
		$this->video_youku_id = $video_youku_id;
		$this->user_youku_id = $user_youku_id;
		$this->name = $name;
		$this->image = $image;
		$this->quality = $quality;
		$this->length = $length;
		$this->date = $date;
		$this->type = $type;
		$this->description = $description;
	}
	
	/**
	 * @return the $video_youku_id
	 */
	public function getVideo_youku_id() {
		return $this->video_youku_id;
	}

	/**
	 * @return the $user_youku_id
	 */
	public function getUser_youku_id() {
		return $this->user_youku_id;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * @return the $quality
	 */
	public function getQuality() {
		return $this->quality;
	}

	/**
	 * @return the $length
	 */
	public function getLength() {
		return $this->length;
	}

	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * @param field_type $video_youku_id
	 */
	public function setVideo_youku_id($video_youku_id) {
		$this->video_youku_id = $video_youku_id;
	}

	/**
	 * @param field_type $user_youku_id
	 */
	public function setUser_youku_id($user_youku_id) {
		$this->user_youku_id = $user_youku_id;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param field_type $image
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * @param field_type $quality
	 */
	public function setQuality($quality) {
		$this->quality = $quality;
	}

	/**
	 * @param field_type $length
	 */
	public function setLength($length) {
		$this->length = $length;
	}

	/**
	 * @param field_type $date
	 */
	public function setDate($date) {
		$this->date = $date;
	}
	

	/**
	 * @param field_type $type
	 */
	public function setType($type) {
		$this->type = $type;
	}
	
	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param field_type $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	
	
}

?>
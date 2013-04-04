<?php
/**
 * 简单封装PDO
 * @author aimsam
 *
 */
class Db {
	private $db;
	private $dbhost;
	private $dbuser;
	private $dbpasw;
	private $dbname;
	
	function __construct() {
		$this->dbhost = $GLOBALS ['cfg_host'];
		$this->dbuser = $GLOBALS ['cfg_user'];
		$this->dbpasw = $GLOBALS ['cfg_pasw'];
		$this->dbname = $GLOBALS ['cfg_dbname'];
		
		$dsn = "mysql:host=$this->dbhost;dbname=$this->dbname";
		
		try {
			$this->db = new PDO ( $dsn, $this->dbuser, $this->dbpasw );
		} catch ( PDOException $e ) {
			echo '数据库连接失败:', $e->getMessage ();
			exit ();
		}
		$this->db->query ( "set names utf8" );
	}
	
	public function getDb() {
		return $this->db;
	}
	
	public function exec($sql) {
		return $this->db->exec($sql);
	}
	
	public function query($sql) {
		return $this->db->query($sql);
	}
	
	public function prepare($sql) {
		return $this->db->prepare($sql);
	}
}
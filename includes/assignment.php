<?php

// If it's going to need the database, then it's
// probably smart to require it before we start.
require_once (LIB_PATH . DS . 'database.php');

class Assignment extends DatabaseObject {

	protected static $table_name = "assignments";
	protected static $db_fields = array('id', 'subject', 'description', 'teacher','batch', 'deadline', 'created');

	public $id;
	public $subject;
	public $description;
	public $teacher;
	public $batch;
	public $deadline;
	public $created;
	
	
	public function comments() {
		return Comment::find_comments_on($this -> id);
	}
	
	public  function submitted_requested_count_all($user_id = 0) {
		global $database;
		$sql = "SELECT COUNT(*) FROM " . static::$table_name ." WHERE user_id={$user_id}";
		$result_set = $database -> query($sql);
		$row = $database -> fetch_array($result_set);
		return array_shift($row);
	}
	
	public  function department_requests_count_all($department = "") {
		global $database;
		$sql = "SELECT COUNT(*) FROM " . static::$table_name ." WHERE department='{$department}'";
		$result_set = $database -> query($sql);
		$row = $database -> fetch_array($result_set);
		return array_shift($row);
	}
	
	
	public static function find_by_user_id($user_id = 0) {
		return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE user_id={$user_id}");
	}
	

}
?>
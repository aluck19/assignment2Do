<?php
// If it's going to need the database, then it's
// probably smart to require it before we start.
require_once (LIB_PATH . DS . 'database.php');

class User extends DatabaseObject {

	protected static $table_name = "users";
	protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'role', 'email_id', 'batch', 'created_by', 'created');

	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $role;
	public $email_id;
	public $batch;
	public $created_by;
	public $created;

	public function full_name() {
		if (isset($this -> first_name) && isset($this -> last_name)) {
			return $this -> first_name . " " . $this -> last_name;
		} else {
			return "";
		}
	}

	public static function find_by_username($username = "") {
		$result_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE username='{$username}' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public static function authenticate($username = "", $password = "", $role = "") {
		global $database;
		$username = $database -> escape_value($username);
		$password = $database -> escape_value($password);
		$role = $database -> escape_value($role);

		$sql = "SELECT * FROM users ";
		$sql .= "WHERE username = '{$username}'  ";
		$sql .= "AND password = '{$password}' ";
		$sql .= "AND role = '{$role}' ";
		$sql .= "LIMIT 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

}
?>
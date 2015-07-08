<?php

function strip_zeros_from_date($marked_string = "") {
	// first remove the marked zeros
	$no_zeros = str_replace('*0', '', $marked_string);
	// then remove any remaining marks
	$cleaned_string = str_replace('*', '', $no_zeros);
	return $cleaned_string;
}

function redirect_to($location = NULL) {
	if ($location != NULL) {
		header("Location: {$location}");
		exit ;
	}
}

function output_message($message = "") {
	if (!empty($message)) {
		return "<p style =\"display: inline-block; \" class=\"ui positive message\">{$message}</p>";
	} else {
		return "";
	}
}

function __autoload($class_name) {
	$class_name = strtolower($class_name);
	$path = LIB_PATH . DS . "{$class_name}.php";
	if (file_exists($path)) {
		require_once ($path);
	} else {
		die("The file {$class_name}.php could not be found.");
	}
}

function include_layout_template($template = "") {
	include (SITE_ROOT . DS . 'public' . DS . 'layouts' . DS . $template);
}

function log_action($action, $message = "") {
	$logfile = SITE_ROOT . DS . 'logs' . DS . 'log.txt';
	$new = file_exists($logfile) ? false : true;
	if ($handle = fopen($logfile, 'a')) {// append
		$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message}\n";
		fwrite($handle, $content);
		fclose($handle);
		if ($new) { chmod($logfile, 0755);
		}
	} else {
		echo "Could not open log file for writing.";
	}
}

function datetime_to_text($datetime = "") {
	$unixdatetime = strtotime($datetime);
	return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function password_encrypt($password) {
	$hash_format = "$2y$10$";
	// Tells PHP to use Blowfish with a "cost" of 10
	$salt_length = 22;
	// Blowfish salts should be 22-characters or more
	$salt = generate_salt($salt_length);
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password, $format_and_salt);
	return $hash;
}

function generate_salt($length) {
	// Not 100% unique, not 100% random, but good enough for a salt
	// MD5 returns 32 characters
	$unique_random_string = md5(uniqid(mt_rand(), true));

	// Valid characters for a salt are [a-zA-Z0-9./]
	$base64_string = base64_encode($unique_random_string);

	// But not '+' which is valid in base64 encoding
	$modified_base64_string = str_replace('+', '.', $base64_string);

	// Truncate string to the correct length
	$salt = substr($modified_base64_string, 0, $length);

	return $salt;
}

function password_check($password, $existing_hash) {
	// existing hash contains format and salt at start
	$hash = crypt($password, $existing_hash);
	if ($hash === $existing_hash) {
		return true;
	} else {
		return false;
	}
}
?>
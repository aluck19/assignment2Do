<?php
require_once ("../../includes/initialize.php");
 ?>
<?php
	if (!$session -> is_logged_in() || $_SESSION['role'] != "admin" && $_SESSION['role'] != "moderator") { redirect_to("login.php");
	}
 ?>
<?php // must have an ID
if (empty($_GET['id'])) {
	$session -> message("No notification ID was provided.");
	redirect_to('index.php');
}

$notification = Notification::find_by_id($_GET['id']);

if ($notification && $notification -> delete()) {

	//to get the username for the notification
	$request = Request::find_by_id($notification-> request_id);
	$user = User::find_by_id($request -> user_id);
	$first_name = $user -> first_name;

	$session -> message("Notification by {$first_name} was deleted.");
	redirect_to('index.php');
} else {
	$session -> message("Notification could not be deleted.");
	redirect_to('index.php');
}
?>
<?php
	if (isset($database)) { $database -> close_connection();
	}
 ?>

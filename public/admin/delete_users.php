<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in() || $_SESSION['role']!="admin") { redirect_to("login.php"); } ?>
<?php
	// must have an ID
  if(empty($_GET['id'])) {
  	$session->message("No User ID was provided.");
    redirect_to('users.php');
  }

  $user = User::find_by_id($_GET['id']);

  if($user && $user->delete()) {
     $session->message("The user {$user-> first_name} was deleted.");
    redirect_to('list_users.php');
  } else {
    $session->message("The user could not be deleted.");
    redirect_to('list_users.php');
  }
  
?>
<?php if(isset($database)) { $database->close_connection(); } ?>

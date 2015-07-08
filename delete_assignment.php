<?php
require_once ("includes/initialize.php");
 ?>
<?php
if (!$session -> is_logged_in()) { redirect_to("login.php");
}
 ?>
<?php // must have an ID
	if (empty($_GET['id'])) {
		$session -> message("Assignment ID was not provided.");
		redirect_to('index.php');
	}

	$assignment = Assignment::find_by_id($_GET['id']);
	
	if ($assignment && $assignment -> delete() ) {

		$session -> message("The assignemnt was deleted.");
		redirect_to('list_assignments.php');

	} else {
		$session -> message("The assignemnt could not be deleted.");
		redirect_to('list_assignments.php');
	}
?>
<?php
if (isset($database)) { $database -> close_connection();
}
?>

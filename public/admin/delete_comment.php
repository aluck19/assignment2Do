<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in() || $_SESSION['role']!="admin") { redirect_to("login.php"); } ?>
<?php
	// must have an ID
  if(empty($_GET['id'])) {
  	$session->message("No comment ID was provided.");
    redirect_to('index.php');
  }

  $comment = Comment::find_by_id($_GET['id']);
  
  if($comment && $comment->delete()) {
    $session->message("Comment was deleted.");
    redirect_to("comments.php?id={$comment->request_id}");
  } else {
    $session->message("Comment could not be deleted.");
    redirect_to('list_request.php');  }
  
?>

<?php if(isset($database)) { $database->close_connection(); } ?>

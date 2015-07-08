<?php
require_once ("../../includes/initialize.php");
 ?>
<?php
if (!$session -> is_logged_in()) { redirect_to("login.php");
}
 ?>
<?php
if (empty($_GET['id'])) {
	$session -> message("No request ID was provided.");
	redirect_to('index.php');
}


$request = Request::find_by_id($_GET['id']);

if (!$request) {
	$session -> message("The request could not be found.");
	redirect_to('index.php');
}

$comments = $request -> comments();
?>
<?php include_layout_template('admin_header.php'); ?>

<a class="ui blue basic button" href="list_requests.php">&laquo; Back</a>
<br/>
<?php echo output_message($message); ?>

<div style="min-height: 8rem;" class="ui stacked segment">
	<p class="ui ribbon label">Comments: <?php echo $request -> subject; ?></p>
	
<div class="ui feed" style="margin-top: 10px;">
	<?php foreach($comments as $comment): ?>
<div class="event">
        <div class="label">
          <i class="pencil icon"></i>
        </div>
        <div class="content">
          <div class="summary">
          	 <?php $user = User::find_by_id($comment -> user_id);
			echo htmlentities($user -> first_name);
 ?> 
            wrote 
            <div class="date">
             at <?php echo datetime_to_text($comment -> created); ?>
            </div>
          </div>
          <div class="extra text">
            	<?php echo strip_tags($comment -> body, '<strong><em><p>'); ?>
          </div>
          <?php
			if ($_SESSION['role'] != "moderator" && $_SESSION['role'] != "student") {
				echo "
          <div class=\"meta\">
            <a style=\"color: red;\" href=\"delete_comment.php?id={$comment -> id}\"><b>Delete Comment</b></a>
          </div>
          ";
			}
          ?>
        </div>
      </div>
      <?php endforeach; ?>
</div> <!-- feed--> 

<?php
if (empty($comments)) { echo "<h3>No Comments<h3>";
}
 ?>
</div>


<?php include_layout_template('admin_footer.php'); ?>
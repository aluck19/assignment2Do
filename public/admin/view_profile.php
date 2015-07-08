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

$user = User::find_by_id($_GET['id']);

if (!$user) {
	$session -> message("The user could not be located.");
	redirect_to('index.php');
}
?>

<?php include_layout_template('admin_header.php'); ?>

<a class="ui blue basic button" href="index.php">&laquo; Back</a>
<br>

<?php echo output_message($message); ?>

<div style="min-height: 8rem;" class="ui stacked segment">
	<p class="ui ribbon label">View Profile</p>	
<div class="ui form" style="margin-top: 10px">
	<div class="field">
		<label>Username</label>
		<p><?php echo $user -> username; ?></p>		
	</div>
	<div class="field">
		<label>First Name</label>
		<p><?php echo $user -> first_name; ?></p>
		
	</div>
	<div class="field">
		<label>Last Name</label>
		<p><?php echo $user -> last_name; ?></p>
		
	</div>
	<div class="field">
		<label>Role</label>
		<p><?php echo ucfirst($user -> role); ?>
		</p>
	</div>
	<div class="field">
		<label>Department</label>
		<p><?php echo ucfirst($user -> department); ?>
		</p>
	</div>
	<div class="field">
		<label>Email Address</label>
		<p><?php echo $user -> email_id; ?>
		</p>
	</div>
	
	<?php
	if ($_SESSION['user_id'] == $user -> id) {
		echo "<div>
		<a class=\"ui blue button\" href=\"edit_profile.php?id={$user->id}\">
			<i class=\"settings icon\"></i>
			Profile Settings
		</a>
		</div>";
	}
	?>
	
</div>
</div> <!-- segment -->

<?php include_layout_template('admin_footer.php'); ?>
<?php
require_once ('includes/initialize.php');
if (!$session -> is_logged_in() || $_SESSION['role'] != "admin") { redirect_to("login.php");
}

if (empty($_GET['id'])) {
	$session -> message("No user ID was provided.");
	redirect_to('list_users.php');
}

$user = User::find_by_id($_GET['id']);

if (isset($_POST['submit'])) {
	$user -> username = $_POST['username'];
	$user -> password = password_encrypt($_POST['password']);
	$user -> first_name = $_POST['first_name'];
	$user -> last_name = $_POST['last_name'];
	$user -> batch = $_POST['batch'];
	$user -> role = strtolower($_POST['role']);
	if ($user && $user -> save()) {
		// Success
		$session -> message("User updated successfully.");
		redirect_to('list_users.php');
	} else {
		// Failure
		$session -> message("User update failed.");
		redirect_to('list_users.php');
	}
}
?>

<?php include_layout_template('admin_header.php'); ?>

<a class="ui teal basic button" href="list_users.php">&laquo; Back</a>
<br />

<?php echo output_message($message); ?>

<div style="min-height: 8rem;" class="ui form stacked segment">
	<p class="ui ribbon label">
		Edit User
	</p>

	<form action="edit_users.php?id=<?php echo $user -> id; ?>" method="post" style="margin-top: 10px;">
		<div class="ui form">
			<div class="field">
				<label>Username</label>
				<div>
					<input type="text" name="username" value="<?php echo htmlentities($user -> username); ?>" />
				</div>
			</div>
			<div class="field">
				<label>Password</label>
				<div >
					<input type="password" name="password" value="" />
				</div>
			</div>
			<div class="field">
				<label>First Name</label>
				<div >
					<input type="text" name="first_name"  value="<?php echo htmlentities($user -> first_name); ?>" />
				</div>
			</div>
			<div class="field">
				<label>Last Name</label>
				<div >
					<input type="text" name="last_name" value="<?php echo htmlentities($user -> last_name); ?>" />
				</div>
			</div>
			<div class="field">
				<label>Batch</label>
				<select name="batch" class="ui dropdown">
					<option>2015</option>
					<option>2016</option>
					<option>2017</option>
					<option>2018</option>
				</select>
			</div>
			<div class="field">
				<label>Role</label>
				<select name="role" class="ui dropdown">
					<option>Admin</option>
					<option>CR</option>
					<option>Student</option>
				</select>
			</div>
			<div >
				<input class="ui teal submit button"  type="submit" name="submit" value="Edit User" />
			</div>
		</div>
	</form>
</div>

<?php include_layout_template('admin_footer.php'); ?>
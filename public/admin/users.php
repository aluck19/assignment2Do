<?php
require_once ('../../includes/initialize.php');
if (!$session -> is_logged_in() || $_SESSION['role'] != "admin") { redirect_to("login.php");
}
?>
<?php
if (isset($_POST['submit'])) {
	$user = new User();
	$user -> username = $_POST['username'];
	$user -> password = password_encrypt($_POST['password']);
	$user -> first_name = $_POST['first_name'];
	$user -> last_name = $_POST['last_name'];
	$user -> role = strtolower(($_POST['role']));
	$user -> department = strtolower(($_POST['department']));
	$user -> created_by = (int)$_SESSION['user_id'];
	$user -> created = strftime("%Y-%m-%d %H:%M:%S", time());
	if ($user -> save()) {
		// Success
		$session -> message("User created successfully.");
		redirect_to('index.php');
	} else {
		// Failure
		$session -> message("User creation failed.");
		redirect_to('index.php');
	}
}
?>

<?php include_layout_template('admin_header.php'); ?>

<a class="ui blue basic button" href="index.php">&laquo; Back</a>
<br/>

<?php echo output_message($message); ?>

<div style="min-height: 8rem;" class="ui form stacked segment">
	<p class="ui ribbon label">
		Create User
	</p>
	<form action="users.php" method="post" style="margin-top: 10px;">
		<div class="ui form">
			<div class="field">
				<label>Username</label>
				<div>
					<input type="text" name="username" value="" required />
				</div>
			</div>
			<div class="field">
				<label>Password</label>
				<div >
					<input type="password" name="password" value="" required/>
				</div>
			</div>
			<div class="field">
				<label>First Name</label>
				<div >
					<input type="text" name="first_name"  value="" required />
				</div>
			</div>
			<div class="field">
				<label>Last Name</label>
				<div >
					<input type="text" name="last_name" value="" required/>
				</div>
			</div>
			<div class="field">
				<label>Role</label>
				<select name="role" class="ui dropdown">
					<option>Admin</option>
					<option>Moderator</option>
					<option>Student</option>
				</select>
			</div>
			<div class="field">
				<label>Department</label>
				<select name="department" class="ui dropdown">
					<option>Library</option>
					<option>Canteen</option>
					<option>Account</option>
					<option>Doctor</option>
					<option>Administration</option>
				</select>
			</div>	
			<div >
				<input class="ui green submit button"  type="submit" name="submit" value="Create User" />
			</div>
		</div>
	</form>
</div>

<?php include_layout_template('admin_footer.php'); ?>
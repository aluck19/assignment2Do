<?php
require_once ("../../includes/initialize.php");

if ($session -> is_logged_in()) {
	redirect_to("index.php");
}

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submit'])) {// Form has been submitted.

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$role = trim(strtolower($_POST['role']));


	$find_username = User::find_by_username($username);
	if (!$find_username){
		// username/password combo was not found in the database	
		$session->message("Username/password/role combination incorrect.");			
		redirect_to("login.php");
	}
	
	$hashed_password = $find_username -> password;
	
	$password = $hashed_password;
	//we got the hashed password

	// Check database to see if username/password exist.
	//hashed password sent for authentication
	$found_user = User::authenticate($username, $password, $role);

	if ($found_user) {
		$session -> login($found_user);
		
		$db_username = ucfirst($found_user->username);
		$db_role = ucfirst($found_user-> role);
		log_action('Login', " {$db_username}, {$db_role}  logged in.");
		redirect_to("index.php");
	} else {
		// username/password combo was not found in the database
		$message = "Username/password/role combination incorrect.";
	}

} else {// Form has not been submitted.
	$username = "";
	$password = "";
	$role = "";
}
?>
<?php include_layout_template('admin_header.php'); ?>

	<h2>Login</h2>

<?php echo output_message($message); ?>
		
	<form  action="login.php" method="post">			
		<div  class="col-lg-6">
			<div class="ui form stacked segment">
				<div class="field">
					<label>Username&nbsp;<i class="users icon"></i></label>
					<div>
						<input type="text" name="username" placeholder="Username">
					</div>
				</div>
				<div class="field">
					<label>Password&nbsp;<i class="lock icon"></i></label>
					<div >
						<input type="password" name="password" placeholder="Password">
					</div>
				</div>
				<div class="field">
					<label>Role&nbsp;<i class="user icon"></i></label>
					<select name="role" class="ui dropdown">
						<option>Admin</option>
						<option>Moderator</option>
						<option>Student</option>
					</select>
				</div>
				<div >
					<input class="ui blue submit button"  type="submit" name="submit" value="Login" />
				</div>
			</div>	
		</div>		
	</form>

<?php include_layout_template('admin_footer.php'); ?>

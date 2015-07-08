<?php
require_once ('../../includes/initialize.php');
if (!$session -> is_logged_in()) { redirect_to("login.php");
}

if (empty($_GET['id'])) {
	$session -> message("User ID not provided.");
	redirect_to('index.php');
}

$user = User::find_by_id($_GET['id']);

if (isset($_POST['submit'])) {
	$user -> username = $_POST['username'];
	$user -> password = password_encrypt($_POST['password']);
	$user -> first_name = $_POST['first_name'];
	$user -> last_name = $_POST['last_name'];
	$user -> email_id = strtolower($_POST['email_id']);
	if ($user && $user -> save()) {
		// Success
		$session -> message("Profile updated successfully.");
		redirect_to("view_profile.php?id={$user -> id}");

	} else {
		// Failure
		$session -> message("Profile update failed.");
		redirect_to("view_profile.php?id={$user -> id}");
	}
}
?>

<?php include_layout_template('admin_header.php'); ?>

<a class="ui blue basic button" href="view_profile.php?id=<?php echo $user -> id; ?>">&laquo; Back</a>
<br />

<?php echo output_message($message); ?>

<div style="min-height: 8rem;" class="ui form stacked segment">
	<p class="ui ribbon label">
		Edit Profile
	</p>
	<form action="edit_profile.php?id=<?php echo $user -> id; ?>" method="post" style="margin-top: 10px;">
		<div class="ui form">
			<div class="field">
				<label>Username</label>
				<div>
					<input type="text" name="username" value="<?php echo htmlentities($user -> username); ?>" required/>
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
					<input type="text" name="first_name"  value="<?php echo htmlentities($user -> first_name); ?>" required/>
				</div>
			</div>
			<div class="field">
				<label>Last Name</label>
				<div >
					<input type="text" name="last_name" value="<?php echo htmlentities($user -> last_name); ?>" required/>
				</div>
			</div>
			<div class="field">
				<label>Role</label>
				<input type="text" name="role" value="<?php echo htmlentities(ucfirst($user -> role)); ?>" disabled/>
			</div>
			<div class="field">
				<label>Department</label>
				<input type="text" name="role" value="<?php echo htmlentities(ucfirst($user -> department)); ?>" disabled/>
			</div>
			<div class="field">
				<label>Email Address</label>
				<div >
					<input type="email" name="email_id" value="<?php echo htmlentities($user -> email_id); ?>" />
				</div>
			</div>

			<?php
			if ($_SESSION['user_id'] == $user -> id) {
				echo "
<div >
<input class=\"ui orange submit button\"  type=\"submit\" name=\"submit\" value=\"Edit Profile\" />
</div>
";
			} else {
				redirect_to("view_profile.php?id={$user -> id}");
			}
			?>
		</div>
	</form>
</div>

<?php include_layout_template('admin_footer.php'); ?>
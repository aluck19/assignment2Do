<?php
require_once ('../../includes/initialize.php');
if (!$session -> is_logged_in()) { redirect_to("login.php");
}
?>

<?php include_layout_template('admin_header.php'); ?>

<?php
$user = User::find_by_id($_SESSION['user_id']);

//Get user department to find the department request
$department = $user->department;
	


if($_SESSION['role']=="admin"){
	$notifications = Notification::find_all();	
	$total_count = Notification::count_all();
}else {
	$sql = "SELECT * FROM notifications ";
	$sql .= "WHERE department = '{$department}' ";
	
	$notifications = Notification::find_by_sql($sql);
	
	$total_count = Notification::notification_department_count_all($department);
}



?>

<div>

	<div style="float: left;">
		<?php echo "<b>HELLO " . ucfirst(strtolower($user -> username)) . "</b>!"; ?>
	</div>
	<div style="float: right;">
		<a class="ui blue button" href="view_profile.php?id=<?php echo $user->id?>"> <i class="user icon"></i> View Profile </a>
	</div>

</div>

<h2>Dashboard</h2>

<div style="margin-bottom: 10px;">
	<?php echo output_message($message); ?>
</div>
<div  class="col-lg-6">
	<div style="min-height: 8rem;" class="ui stacked segment">
		<p class="ui ribbon label">
			Menu Vault
		</p>
		<div id="menuPlate">

			<div  style="display: block;" class="ui vertical steps">
				<a href="requests.php" class="step"> <i class="mail icon"></i>
				<div class="content">
					<div class="title">
						Create Request
					</div>
				</div> </a>
				<a href="list_requests.php" class="step"> <i class="payment icon"></i>
				<div class="content">
					<div class="title">
						List Requests
					</div>
				</div> </a>
				<a href="submitted_requests.php" class="step"> <i class="payment icon"></i>
				<div class="content">
					<div class="title">
						Submitted Requests
					</div>
				</div> </a>
				<?php
				if ($_SESSION['role'] != "moderator" && $_SESSION['role'] != "student") {
					echo "
<a href=\"users.php\" class=\"step\"> <i class=\"user icon\"></i>
<div class=\"content\">
<div class=\"title\">
Create User
</div>
</div> </a>
<a href=\"list_users.php\" class=\"step\"> <i class=\"users icon\"></i>
<div class=\"content\">
<div class=\"title\">
List Users
</div>
</div> </a>
<a href=\"logfile.php\" class=\"step\"> <i class=\"info icon\"></i>
<div class=\"content\">
<div class=\"title\">
View Log
</div>
</div> </a>";
				}
				?>

				<?php
				if ($_SESSION['role'] == "moderator") {
					echo "<a href=\"department_requests.php\" class=\"step\"> <i class=\"payment icon\"></i>
						<div class=\"content\">
						<div class=\"title\">
						Department Requests
						</div>
						</div> </a>";
				}
				?>

				<a href="logout.php" class="step"> <i class="remove icon"></i>
				<div class="content">
				<div class="title">
				Logout
				</div>
				</div> </a>
			</div>
		</div>
	</div>
	<!-- segment -->
</div>
<!-- col-lg-6 -->

<?php //notfication count
	

	//notificatio count put html conditional code
	if (!empty($notifications)) {
		$count = "
<div style=\"top: -20px; position: relative; z-index: 100; left: -15px; padding: 6px;\" class=\"floating ui red label\">
$total_count
</div>";
		$paddingStyle = "style=\"padding-right: 20px;\"";
		$overflowHideStyle = "";
	} else {
		$count = "";
		$paddingStyle = "";
		$overflowHideStyle = "style=\"overflow: hidden; \"";
	};

	if ($_SESSION['role'] != "student") {
		echo "
<div class=\"col-lg-6\">
<div style=\"min-height: 8rem;\" class=\"ui stacked segment\">
<p class=\"ui ribbon label\" $paddingStyle >Notifications Vault

$count
</p>
<div  id=\"notifications\" $overflowHideStyle >
";
	}
?>

<?php
if ($_SESSION['role'] != "student") {
	if (empty($notifications)) {
		echo "<b style=\"color: green;\">Congratulation! Notifications vault is empty.</b>";
	}
}
?>
<?php foreach($notifications as $notification):?>
<?php
if ($_SESSION['role'] != "student") {
	echo "
<div style=\"display: inline-block; margin-top: 0px;\" class=\"ui info message\">
<a href=\"view_request.php?id={$notification-> request_id}\">{$notification -> body}</a>
<a style=\"margin-left: 10px;\" href=\"delete_notification.php?id={$notification -> id}\">
<i class=\"small circular inverted red close icon\"></i>
</a>
</div>";
}
?>
<?php endforeach; ?>
</div>
</div><!-- segment -->
</div><!-- col -->
<?php include_layout_template('admin_footer.php'); ?>
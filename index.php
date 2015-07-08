<?php
require_once ('includes/initialize.php');
if (!$session -> is_logged_in()) { redirect_to("login.php");
}
?>

<?php include_layout_template('admin_header.php'); ?>

<?php $user = User::find_by_id($_SESSION['user_id']);


?>

<div>

	<div style="float: left;">
		<?php echo "<b>HELLO " . ucfirst(strtolower($user -> username)) . "</b>!"; ?>
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
				<a href="assignments.php" class="step"> <i class="mail icon"></i>
				<div class="content">
					<div class="title">
						Upload Assignment
					</div>
				</div> </a>
				<a href="list_assignments.php" class="step"> <i class="payment icon"></i>
				<div class="content">
					<div class="title">
						List Assignments
					</div>
				</div> </a>

				<?php
				if ($_SESSION['role'] != "cr" && $_SESSION['role'] != "student") {
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
						";
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


<?php include_layout_template('admin_footer.php'); ?>
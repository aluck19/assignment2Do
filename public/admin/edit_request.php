<?php
require_once ('../../includes/initialize.php');
if (!$session -> is_logged_in() || $_SESSION['role']!="admin") { redirect_to("login.php");
}

if (empty($_GET['id'])) {
	$session -> message("No user ID was provided.");
	redirect_to('list_requests.php');
}

$request = Request::find_by_id($_GET['id']);

if (isset($_POST['submit'])) {
	$request -> subject = $_POST['subject'];
	$request -> description = $_POST['description'];
	$request -> expected_solution = $_POST['expected_solution'];
	if ($request && $request -> save()) {
		// Success
		$session -> message("Request updated successfully.");
		redirect_to('list_requests.php');
	} else {
		// Failure
		$session -> message("Request update failed.");
		redirect_to('list_requests.php');
	}
}
?>

<?php include_layout_template('admin_header.php'); ?>

<a class="ui blue basic button"  href="list_requests.php">&laquo; Back</a>
<br/>

<?php echo output_message($message); ?>

<div style="min-height: 8rem;" class="ui form stacked segment">
	<p class="ui ribbon label">
		Edit Request
	</p>

	<form action="edit_request.php?id=<?php echo $request -> id; ?>" method="post" style="margin-top: 10px;">
		<div class="ui form">
			<div class="field">
				<label>Subject</label>
				<div>
					<input type="text" name="subject" value="<?php echo htmlentities($request -> subject); ?>"/>
				</div>
			</div>
			<div class="field">
				<label>Decription</label>
				<div >
					<textarea name="description" rows="5" cols="80"><?php echo htmlentities($request -> description); ?></textarea>
				</div>
			</div>
			<div class="field">
				<label>Expected Solution</label>
				<div >
					<textarea name="expected_solution" rows="5" cols="80"><?php echo htmlentities($request -> expected_solution); ?></textarea>
				</div>
			</div>
			<div >
				<input class="ui orange submit button"  type="submit" name="submit" value="Edit Request" />
			</div>
		</div>
	</form>
</div>

<?php include_layout_template('admin_footer.php'); ?>
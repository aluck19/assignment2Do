<?php
require_once ('includes/initialize.php');
if (!$session -> is_logged_in() || $_SESSION['role'] != "admin") { redirect_to("login.php");
}

if (empty($_GET['id'])) {
	$session -> message("No user ID was provided.");
	redirect_to('list_assignments.php');
}

$assignment = Assignment::find_by_id($_GET['id']);

if (isset($_POST['submit'])) {
	$assignment -> subject = $_POST['subject'];
	$assignment -> description = $_POST['description'];
	$assignment -> teacher = $_POST['teacher'];
	$assignment -> batch = $_POST['batch'];

	if ($assignment && $assignment -> save()) {
		// Success
		$session -> message("Assignment updated successfully.");
		redirect_to('list_assignments.php');
	} else {
		// Failure
		$session -> message("Assignment update failed.");
		redirect_to('list_assignments.php');
	}
}
?>

<?php include_layout_template('admin_header.php'); ?>

<a class="ui teal basic button"  href="list_assignments.php">&laquo; Back</a>
<br/>

<?php echo output_message($message); ?>

<div style="min-height: 8rem;" class="ui form stacked segment">
	<p class="ui ribbon label">
		Edit Assignment
	</p>
	<form action="edit_assignment.php?id=<?php echo $assignment -> id; ?>" method="post" style="margin-top: 10px;">
		<div class="ui form">
			<div class="field">
				<label>Subject</label>
				<div>
					<input type="text" name="subject" value="<?php echo htmlentities($assignment -> subject); ?>"/>
				</div>
			</div>
			<div class="field">
				<label>Decription</label>
				<div >
					<textarea name="description" rows="5" cols="80"><?php echo htmlentities($assignment -> description); ?></textarea>
				</div>
			</div>
			<div class="field">
				<label>Teacher</label>
				<div>
					<input type="text" name="teacher"  value="<?php echo htmlentities($assignment -> teacher); ?>">
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
			<div >
				<input class="ui teal submit button"  type="submit" name="submit" value="Edit Request" />
			</div>
		</div>
	</form>
</div>

<?php include_layout_template('admin_footer.php'); ?>
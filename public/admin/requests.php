<?php
require_once ('../../includes/initialize.php');
if (!$session -> is_logged_in()) { redirect_to("login.php");
}
?>
<?php
if (isset($_POST['submit'])) {

	//creating a new request
	$request = new Request();
	$request -> department = strtolower($_POST['department']);
	$request -> subject = $_POST['subject'];
	$request -> description = $_POST['description'];
	$request -> expected_solution = $_POST['expected_solution'];
	$request -> priority = $_POST['priority'];
	$request -> user_id = $_SESSION['user_id'];
	$request -> created = strftime("%Y-%m-%d %H:%M:%S", time());

	if ($request -> save()) {
		// Success

		//Create a Notfication for each new request
		$notification = new Notification();
		$notification -> request_id = $request -> id;
		
		//to get the username for the notification
		$request = Request::find_by_id($request -> id);
		$user  = User::find_by_id($request ->user_id);
		$first_name = $user ->first_name;
				
		$notification -> body = "A new request has been created by {$first_name}.";
		$notification -> department = $request -> department;
		$notification -> created = strftime("%Y-%m-%d %H:%M:%S", time());
		$notification -> save();

		//sucess message
		$session -> message("Request created successfully.");
		redirect_to('index.php');
	} else {
		// Failure
		$session -> message("Request failed.");
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
		Create Request
	</p>

	<form action="requests.php" method="post" style="margin-top: 10px;">
		<div class="ui form">
			<div class="field">
				<label>Department</label>
				<select name="department" class="ui dropdown" >
					<option>Library</option>
					<option>Canteen</option>
					<option>Account</option>
					<option>Doctor</option>
					<option>Administration</option>
				</select>
			</div>			
			<div class="field">
				<label>Subject</label>
				<div>
					<input type="text" name="subject" required>
				</div>
			</div>
			<div class="field">
				<label>Decription</label>
				<div >
					<textarea name="description" rows="5" cols="80" required></textarea>
				</div>
			</div>
			<div class="field">
				<label>Expected Solution</label>
				<div >
					<textarea name="expected_solution" rows="5" cols="80" required></textarea>
				</div>
			</div>
			<div class="field">
				<label>Department</label>
				<select name="priority" class="ui dropdown" >
					<option>High</option>
					<option>Middle</option>
					<option>Low</option>
				</select>
			</div>		
			<div >
				<input class="ui green submit button"  type="submit" name="submit" value="Create Request" />
			</div>
		</div>
	</form>

</div>

<?php include_layout_template('admin_footer.php'); ?>
<?php
require_once ('includes/initialize.php');
if (!$session -> is_logged_in()) { redirect_to("login.php");
}
?>
<?php
if (isset($_POST['submit'])) {

	//creating a new Assignment
	$assignment = new Assignment();
	$assignment -> subject = $_POST['subject'];
	$assignment -> description = $_POST['description'];
	$assignment -> teacher = $_POST['teacher'];
	$assignment -> batch = $_POST['batch'];
	$deadline = strtotime($_POST['deadline']);
	$assignment -> deadline = strftime("%Y-%m-%d %H:%M:%S", $deadline);
	$assignment -> created = strftime("%Y-%m-%d %H:%M:%S", time());

	if ($assignment -> save()) {
		$session -> message("Assignment created successfully.");
		redirect_to('index.php');
	} else {
		// Failure
		$session -> message("Assignment failed.");
		redirect_to('index.php');
	}

}
?>

<?php include_layout_template('admin_header.php'); ?>
<!-- datepicker javascript -->
<link href="public/datetime/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

<a class="ui teal basic button" href="index.php">&laquo; Back</a>
<br/>

<?php echo output_message($message); ?>

<div style="min-height: 8rem;" class="ui form stacked segment">
	<p class="ui ribbon label">
		Create Assignment
	</p>

	<form action="assignments.php" method="post" style="margin-top: 10px;">
		<div class="ui form">
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
				<label>Teacher</label>
				<div>
					<input type="text" name="teacher" required>
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
				<label>Deadline</label>
				<div class="row">

					<div class="col-md-4" class="field">
						<div class="input-group date form_datetime" data-date-format="dd MM yyyy  HH:ii p" data-link-field="dtp_input1">
							<input class="form-control" size="16" type="text" value=""   id="dateTime">
							<span style=" position: relative;  left: -3px; " class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
							<span class="input-group-addon" style="position: relative; left: -3px;"><span class="glyphicon glyphicon-th"></span></span>
						</div>
						<input type="hidden" name ="deadline" id="dtp_input1" value="" />
					</div>
				</div><!-- row -->
			</div>

			<div >
				<input class="ui teal submit button"  type="submit" name="submit" value="Create Assignment" />
			</div>
		</div>
	</form>

</div>

<script type="text/javascript" src="public/datetime/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<!-- <script type="text/javascript" src="js/locales/bootstrap-datetimepicker.ee.js" charset="UTF-8"></script> -->
<script type="text/javascript">
	$(".form_datetime").datetimepicker({
		format : "dd MM yyyy  HH:ii P",
		todayHighlight : 1,
		showMeridian : true,
		autoclose : true,
		todayBtn : true,
		pickerPosition : "top-right"
	}); 
</script>

<script>
	var x = document.getElementById("dtp_input1");

	var y = document.getElementById("dateTime");

	y.onchange = dispaly;

	function dispaly() {
		alert(x.value);
		console.log(x.value);
	}

</script>

<?php include_layout_template('admin_footer.php'); ?>
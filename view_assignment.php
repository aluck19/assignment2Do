<?php
require_once ("includes/initialize.php");
 ?>
 <?php
if (!$session -> is_logged_in()) { redirect_to("login.php");
}
 ?>
<?php
if (empty($_GET['id'])) {
	$session -> message("No request ID was provided.");
	redirect_to('index.php');
}

$assignment = Assignment::find_by_id($_GET['id']);
$assignment_id = $assignment -> id;

if (!$assignment) {
	$session -> message("The request could not be located.");
	redirect_to('index.php');
}

//posting deadline
if (isset($_POST['deadline_submit'])) {
	$deadline = strtotime($_POST['deadline']);
	$assignment -> deadline = strftime("%Y-%m-%d %H:%M:%S", $deadline);
	$assignment -> status = "working";
	if ($assignment -> save()) {
		$session -> message("Deadline set to {$_POST['deadline']}");
	}
}
?>



<?php include_layout_template('admin_header.php'); ?>
<!-- datepicker javascript -->
<link href="public/datetime/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

<a class="ui teal basic button" href="index.php">&laquo; Back</a>
<br>

<?php echo output_message($message); ?>



<div style="min-height: 8rem;" class="ui stacked segment">
	<p class="ui ribbon label">View Assignment: <?php echo $assignment -> subject; ?></p>
	
<div class="ui form" style="margin-top: 10px">
	<div class="field">
		<label>Subject</label>
		<p><?php echo $assignment -> subject; ?></p>
		
	</div>
	<div class="field">
		<label>Description</label>
		<p><?php echo $assignment -> description; ?></p>
		
	</div>
	<div class="field">
		<label>Teacher</label>
		<p><?php echo $assignment -> teacher; ?></p>
		
	</div>
	<div class="field">
		<label>Batch</label>
		<p><?php echo $assignment -> batch; ?></p>
		
	</div>	
	
	<?php 
	$deadline = $assignment -> deadline;
	if($deadline != "0000-00-00 00:00:00"){
		echo "
		<div class=\"field\">
			<label>Deadline</label>
			<p>";				
			echo datetime_to_text($assignment -> deadline);		
			echo"</p>
		</div>";		
	}else {
		echo "
		<div class=\"field\">
			<label>Deadline</label>
			<p>Post a deadline</p>
		</div>
		";					
	}		
	?>
</div>





</div> <!-- segment -->


<script type="text/javascript" src="public/datetime/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<!-- <script type="text/javascript" src="js/locales/bootstrap-datetimepicker.ee.js" charset="UTF-8"></script> -->
<script type="text/javascript">
	$(".form_datetime").datetimepicker({
		format : "dd MM yyyy  HH:ii P",
		todayHighlight : 1,
		showMeridian : true,
		autoclose : true,
		todayBtn : true,
		pickerPosition : "bottom-left"
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
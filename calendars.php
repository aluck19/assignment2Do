<?php
require_once ('includes/initialize.php');
 ?>
<?php
if (!$session -> is_logged_in()) { redirect_to("login.php");
}


?>

<?php include_layout_template('admin_header.php'); ?>
<link href="../datetime/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

<a class="ui blue basic button" href="index.php">&laquo; Back</a>
<br/>

<?php echo output_message($message); ?>

<br>

<div style="min-height: 8rem; padding-bottom: 40px;" class="ui stacked segment">
	<p class="ui ribbon label">
		Request List
	</p>

	<form action="" class="form-horizontal"  role="form">
		<fieldset>

			<legend>
				Test
			</legend>
			<div class="form-group">
				<label for="dtp_input1" class="col-md-2 control-label">DateTime Picking</label>
				<div class="input-group date form_datetime col-md-5" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
					<input class="form-control" size="16" type="text" value=""  id="dateTime">
					<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
				</div>
				<input type="hidden" id="dtp_input1" value="" />
				<br/>
			</div>

		</fieldset>
	</form>

</div><!-- segment -->
<script type="text/javascript" src="../datetime/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<!-- <script type="text/javascript" src="js/locales/bootstrap-datetimepicker.ee.js" charset="UTF-8"></script> -->
<script type="text/javascript">
	$(".form_datetime").datetimepicker({
		format : "dd MM yyyy - HH:ii P",
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
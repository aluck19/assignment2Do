<?php
require_once ("../../includes/initialize.php");
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

$request = Request::find_by_id($_GET['id']);
$request_id = $request -> id;

if (!$request) {
	$session -> message("The request could not be located.");
	redirect_to('index.php');
}

//posting deadline
if(isset($_POST['deadline_submit'])){
	$deadline = strtotime($_POST['deadline']);
	$request -> deadline = strftime("%Y-%m-%d %H:%M:%S", $deadline);
	if($request -> save()){
		$session -> message("Deadline set to {$_POST['deadline']}");	
	}			
}


//to get the FULL NAME for the notification
$user = User::find_by_id($request -> user_id);
$first_name = $user -> first_name;
$last_name = $user -> last_name;
$user -> full_name();

if (isset($_POST['submit'])) {
	$request = Request::find_by_id($_GET['id']);
	$user_id = $_SESSION['user_id'];
	$body = trim($_POST['body']);

	$new_comment = Comment::make($request_id, $user_id, $body);

	if ($new_comment && $new_comment -> save()) {
		// comment saved
		$session -> message("Comment was posted sucessfully.");
		// Important!  You could just let the page render from here.
		// But then if the page is reloaded, the form will try
		// to resubmit the comment. So redirect instead:
		redirect_to("view_request.php?id={$request->id}");

	} else {
		// Failed
		$message = "There was an error that prevented the comment from being saved.";
	}
} else {
	$body = "";
}

$comments = $request -> comments();
?>

<?php
//current 
$val1 = strftime("%Y-%m-%d %H:%M:%S", time());

//deadline  time
$val2 = $request->deadline;

$date1=date_create("$val1");
$date2=date_create("$val2");

//calcualte the time difference
$diff=date_diff($date1,$date2);

echo $diff->format("%R %a days %I minutes %S  seconds");

echo "<br>";
if(strtotime($val1) > strtotime($val2)){
	echo "Time finished";
} else {
	echo "Not finished";
}


echo "<br>";
echo strtotime($val1);
echo "<br>";
echo strtotime($val2);
echo "<br>";
?>

<?php include_layout_template('admin_header.php'); ?>
<!-- datepicker javascript -->
<link href="../datetime/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

<a class="ui blue basic button" href="index.php">&laquo; Back</a>
<br>

<?php echo output_message($message); ?>

<div style="min-height: 8rem;" class="ui stacked segment">
	<p class="ui ribbon label">View Request: <?php echo $request -> subject; ?></p>
	
<div class="ui form" style="margin-top: 10px">
	<div class="field">
		<label>Subject</label>
		<p><?php echo $request -> subject; ?></p>
		
	</div>
	<div class="field">
		<label>Description</label>
		<p><?php echo $request -> description; ?></p>
		
	</div>
	<div class="field">
		<label>Expected Solution</label>
		<p><?php echo $request -> expected_solution; ?></p>
		
	</div>
	<div class="field">
		<label>Created By</label>
			<a href="view_profile.php?id=<?php echo $user->id?>"><p><?php echo $user -> full_name(); ?></p></a>
	</div>
</div>



<h3>Comments</h3>
<div class="ui feed" style="margin-top: 10px;">
  <?php foreach($comments as $comment): ?>
    <div class="event">
        <div class="label">
          <i class="pencil icon"></i>
        </div>
        <div class="content">
          <div class="summary">
          	 <?php $user = User::find_by_id($comment -> user_id);
			echo htmlentities($user -> first_name);
 ?> 
            wrote 
            <div class="date">
             at <?php echo datetime_to_text($comment -> created); ?>
            </div>
          </div>
          <div class="extra text">
            	<?php echo strip_tags($comment -> body, '<strong><em><p>'); ?>
          </div>
          </div>
         </div>
  <?php endforeach; ?>
  <?php
if (empty($comments)) { echo "No Comments.";
}
 ?>
 
 <?php
if ($_SESSION['user_id'] == $request -> user_id)

	echo "<a href=\"delete_request.php?id={$request -> id}\" onclick=\"return confirm('Are you sure?');\">
 	<div style=\"float:right;\" class=\"negative ui button\">Close Request</div></a>";
 ?>
</div><!-- feed -->


<div class="ui form">
  <h4>New Comment</h4>
  
  	
   
      <div class="row">
    	<div class="col-md-4" class="field">
    		<form action="view_request.php?id=<?php echo $request -> id; ?>" method="post">   
      <div class="input-group date form_datetime" data-date-format="dd MM yyyy  HH:ii p" data-link-field="dtp_input1">
					<input class="form-control" size="16" type="text" value=""   id="dateTime">
					<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
				</div>
				<input type="hidden" name ="deadline" id="dtp_input1" value="" />
     </div>
      <div >
		<input class="ui green submit button"  type="submit" name="deadline_submit" value="Post Deadline" />
	 </div>
	 </form>
   </div><!-- row -->
    <br/>
  
  
  <form action="view_request.php?id=<?php echo $request -> id; ?>" method="post">    	
     <div class="row">
    		  <div class="col-md-6" class="field">
         <textarea name="body" cols="40" rows="8"> </textarea></td>
     </div>
      </div><!-- row -->
         <br />
         
     <div >
		<input class="ui green submit button"  type="submit" name="submit" value="Submit Comment" />
	 </div>
  </form>
</div>


</div> <!-- segment -->


<script type="text/javascript" src="../datetime/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
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
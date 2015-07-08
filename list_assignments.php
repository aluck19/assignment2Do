<?php
require_once ("includes/initialize.php");
 ?>
<?php
if (!$session -> is_logged_in()) { redirect_to("login.php");
}
 ?>
 <?php
// 1. the current page number ($current_page)
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

// 2. records per page ($per_page)
$per_page = 10;

// 3. total record count ($total_count)
$total_count = Assignment::count_all();

//4. to limit pagination number
// 3 means abc[page]efg -> 3 right, 3 left
$stages = 2;

$pagination = new Pagination($page, $per_page, $total_count);

// Instead of finding all records, just find the records
// for this page
$sql = "SELECT * FROM assignments  ";

if (isset($_POST['sort'])) {
	$batch = strtolower($_POST['batch']);
	$sql .= "WHERE batch={$batch}";
}
$sql .= "ORDER BY created DESC ";
$sql .= " LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()} ";


$assignments = Assignment::find_by_sql($sql);

if (empty($assignments)) {
	$session -> message("There are no Assignments in Assignment vault.");
	redirect_to('index.php');
}

// Need to add ?page=$page to all links we want to
// maintain the current page (or store $page in $session)
?>


<?php include_layout_template('admin_header.php'); ?>

<a class="ui teal basic button" href="index.php">&laquo; Back</a>
<br/>

<?php echo output_message($message); ?>


<div style="min-height: 8rem; padding-bottom: 40px;" class="ui stacked segment">
	<p class="ui ribbon label">All Assignment</p>
	<br>
	<br>
	
	<form action="list_assignments.php" method="post">
		<select class="ui search dropdown" name="batch">		
		  <option value="2015">2015</option>
		  <option value="2016">2016</option>		  
		  <option value="2017">2017</option>
		  <option value="2018">2018</option>		  
		</select>
		  <input name="sort" class="ui teal button" type="submit"/>
	</form>

		<table class="ui celled striped table">
		<thead>
		  <tr>
		  	<th>ID</th>
		  	<th>Subject</th>
		  	<th>Description &nbsp;</th>
		  	<th>Teacher</th>
		  	<th>Batch</th>
		  	<th>Deadline</th>
		  	<th>Created</th>		  
		  	<th>View</th>  	
		  	<?php
			if ($_SESSION['role'] != "cr" && $_SESSION['role'] != "student") {
				echo "<th>Edit</th>
					<th>Delete</th>";
			}
		  	?>  		  	
		  </tr>
	  </thead>
	<?php foreach($assignments as $assignment): ?>
		  <tr> 
		  	<td><?php echo $assignment -> id; ?></td>
		    <td><?php echo $assignment -> subject; ?></td>
		    <td><?php echo ucfirst($assignment -> description); ?></td>
		    <td><?php echo $assignment -> teacher; ?></td>
		    <td><?php echo $assignment -> batch; ?></td>
		    <td><?php echo datetime_to_text($assignment -> deadline); ?></td>
		    <td><?php echo datetime_to_text($assignment -> created); ?></td>   
			<td>		
   			 	<a href="view_assignment.php?id=<?php echo $assignment -> id; ?>"><i class="small circular inverted yellow eye icon"></i></a>
    		</td>
			<?php
			if ($_SESSION['role'] != "cr" && $_SESSION['role'] != "student") {
				echo "<td><a href=\"edit_assignment.php?id={$assignment -> id}\"><i class=\"small circular inverted orange edit icon\"></i></a></td>	
			<td><a href=\"delete_assignment.php?id={$assignment -> id}\" onclick=\"return confirm('Are you sure?');\"><i class=\"small circular inverted red remove icon\"></i></a></td>
			
			";
			}
			?>
		  </tr>  
	<?php endforeach; ?>
	</table>


<?php

$prev = $pagination -> previous_page();
$next = $pagination -> next_page();

$lastpage = $pagination -> total_pages();

$LastPagem1 = $lastpage - 1;

$paginate = '';

if ($lastpage > 1) {

	$paginate .= "<ul class='pagination'>";

	// Previous
	if ($pagination -> has_previous_page()) {
		$paginate .= "<li><a href='list_assignments.php?page=$prev'>&laquo; Previous</a></li>";

	}

	// Pages
	if ($lastpage < 7 + ($stages * 2))// Not enough pages to breaking it up
	{
		for ($counter = 1; $counter <= $lastpage; $counter++) {
			if ($counter == $page) {
				$paginate .= "<li class='active'><a href='list_assignments.php?page=$counter'>$counter</a></li>";
			} else {
				$paginate .= "<li><a href='list_assignments.php?page=$counter'>$counter</a><li>";
			}
		}
	} elseif ($lastpage > 5 + ($stages * 2))// Enough pages to hide a few?
	{
		// Beginning only hide later pages
		if ($page < 1 + ($stages * 2)) {
			for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
				if ($counter == $page) {
					$paginate .= "<li class='active'><a href='list_assignments.php?page=$counter'>$counter</a></li>";
				} else {
					$paginate .= "<li><a href='list_assignments.php?page=$counter'>$counter</a></li>";
				}
			}
			$paginate .= "<li class='disabled'><a>...</a></li>";
			$paginate .= "<li><a href='list_assignments.php?page=$LastPagem1'>$LastPagem1</a></li>";
			$paginate .= "<li><a href='list_assignments.php?page=$lastpage'>$lastpage</a></li>";
		}
		// Middle hide some front and some back
		elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
			$paginate .= "<li><a href='list_assignments.php?page=1'>1</a></li>";
			$paginate .= "<li><a href='list_assignments.php?page=2'>2</a></li>";
			$paginate .= "<li class='disabled'><a>...</a></li>";
			for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
				if ($counter == $page) {
					$paginate .= "<li class='active'><a href='list_assignments.php?page=$counter'>$counter</a></li>";
				} else {
					$paginate .= "<li><a href='list_assignments.php?page=$counter'>$counter</a></li>";
				}
			}
			$paginate .= "<li class='disabled'><a>...</a></li>";
			$paginate .= "<li><a href='list_assignments.php?page=$LastPagem1'>$LastPagem1</a></li>";
			$paginate .= "<li><a href='list_assignments.php?page=$lastpage'>$lastpage</a></li>";
		}
		// End only hide early pages
		else {
			$paginate .= "<li><a href='list_assignments.php?page=1'>1</a></li>";
			$paginate .= "<li><a href='list_assignments.php?page=2'>2</a></li>";
			$paginate .= "<li class='disabled'><a>...</a></li>";
			for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
				if ($counter == $page) {
					$paginate .= "<li class='active'><a href='list_assignments.php?page=$counter'>$counter</a></li>";
				} else {
					$paginate .= "<li><a href='list_assignments.php?page=$counter'>$counter</li>";
				}
			}
		}
	}

	// Next
	if ($pagination -> has_next_page()) {
		$paginate .= "<li><a href='list_assignments.php?page=$next'>Next &raquo;</a></li>";

	}

	$paginate .= "</ul>";

}

//total Result count
echo "<p><b>Total Result:</b> {$total_count}</p>";

// pagination
echo $paginate;
?>

</div><!-- segment -->
<?php include_layout_template('admin_footer.php'); ?>
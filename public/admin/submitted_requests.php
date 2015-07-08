<?php
require_once ("../../includes/initialize.php");
 ?>
<?php
if (!$session -> is_logged_in()) { redirect_to("login.php");
}
 ?>
 
<?php // 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

	// 2. records per page ($per_page)
	$per_page = 10;

	// 3. total record count ($total_count)
	$total_count = Request::submitted_requested_count_all($_SESSION['user_id']);

	//4. to limit pagination number
	// 3 means abc[page]efg -> 3 right, 3 left
	$stages = 2;

	$pagination = new Pagination($page, $per_page, $total_count);

	// Instead of finding all records, just find the records
	// for this page
	$sql = "SELECT * FROM requests ";
	$sql .= "WHERE user_id={$_SESSION['user_id']} ORDER BY created DESC ";
	$sql .= "LIMIT {$per_page} ";
	$sql .= "OFFSET {$pagination->offset()} ";
	$requests = Request::find_by_sql($sql);

	if (empty($requests)) {
		$session -> message("You have not submitted any requests yet.");
		redirect_to('index.php');
	}

	// Need to add ?page=$page to all links we want to
	// maintain the current page (or store $page in $session)
?>


<?php include_layout_template('admin_header.php'); ?>

<a class="ui blue basic button" href="index.php">&laquo; Back</a>
<br />

<?php echo output_message($message); ?>

<div style="min-height: 8rem; padding-bottom: 40px;" class="ui stacked segment">
	<p class="ui ribbon label">Submitted Requests</p>	
	<table class="ui celled striped table">
		<thead>
		  <tr>
		  	<th>Created</th>
		  	<th>Subject</th>	
		  	<th>Department</th>	
		  	<th>Priority</th>		  	
		  	<th>Comments</th>
		  	<th>View</th>  	
		  </tr>
	  </thead>
	<?php foreach($requests as $request): ?>
		  <tr>    
		    <td><?php echo datetime_to_text($request -> created); ?></td>
		    <td><?php echo $request -> subject; ?></td>	
		    <td><?php echo ucfirst($request -> department); ?></td>		   
		    <td><?php echo ucfirst($request -> priority); ?></td>
		    <td>
				<a href="comments.php?id=<?php echo $request -> id; ?>"> 
					<?php
					if (count($request -> comments()) == 0) {
						echo "No Comments";
					} else {
						echo count($request -> comments());
					}
				?> 
				</a>
			</td>
			<td>		
   			 	<a href="view_request.php?id=<?php echo $request -> id; ?>"><i class="small circular inverted yellow eye icon"></i></a>
    		</td>
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
		$paginate .= "<li><a href='submitted_requests.php?page=$prev'>&laquo; Previous</a></li>";

	}

	// Pages
	if ($lastpage < 7 + ($stages * 2))// Not enough pages to breaking it up
	{
		for ($counter = 1; $counter <= $lastpage; $counter++) {
			if ($counter == $page) {
				$paginate .= "<li class='active'><a href='submitted_requests.php?page=$counter'>$counter</a></li>";
			} else {
				$paginate .= "<li><a href='submitted_requests.php?page=$counter'>$counter</a><li>";
			}
		}
	} elseif ($lastpage > 5 + ($stages * 2))// Enough pages to hide a few?
	{
		// Beginning only hide later pages
		if ($page < 1 + ($stages * 2)) {
			for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
				if ($counter == $page) {
					$paginate .= "<li class='active'><a href='submitted_requests.php?page=$counter'>$counter</a></li>";
				} else {
					$paginate .= "<li><a href='submitted_requests.php?page=$counter'>$counter</a></li>";
				}
			}
			$paginate .= "<li class='disabled'><a>...</a></li>";
			$paginate .= "<li><a href='submitted_requests.php?page=$LastPagem1'>$LastPagem1</a></li>";
			$paginate .= "<li><a href='submitted_requests.php?page=$lastpage'>$lastpage</a></li>";
		}
		// Middle hide some front and some back
		elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
			$paginate .= "<li><a href='submitted_requests.php?page=1'>1</a></li>";
			$paginate .= "<li><a href='submitted_requests.php?page=2'>2</a></li>";
			$paginate .= "<li class='disabled'><a>...</a></li>";
			for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
				if ($counter == $page) {
					$paginate .= "<li class='active'><a href='submitted_requests.php?page=$counter'>$counter</a></li>";
				} else {
					$paginate .= "<li><a href='submitted_requests.php?page=$counter'>$counter</a></li>";
				}
			}
			$paginate .= "<li class='disabled'><a>...</a></li>";
			$paginate .= "<li><a href='submitted_requests.php?page=$LastPagem1'>$LastPagem1</a></li>";
			$paginate .= "<li><a href='submitted_requests.php?page=$lastpage'>$lastpage</a></li>";
		}
		// End only hide early pages
		else {
			$paginate .= "<li><a href='submitted_requests.php?page=1'>1</a></li>";
			$paginate .= "<li><a href='submitted_requests.php?page=2'>2</a></li>";
			$paginate .= "<li class='disabled'><a>...</a></li>";
			for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
				if ($counter == $page) {
					$paginate .= "<li class='active'><a href='submitted_requests.php?page=$counter'>$counter</a></li>";
				} else {
					$paginate .= "<li><a href='submitted_requests.php?page=$counter'>$counter</li>";
				}
			}
		}
	}

	// Next
	if ($pagination -> has_next_page()) {
		$paginate .= "<li><a href='submitted_requests.php?page=$next'>Next &raquo;</a></li>";

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
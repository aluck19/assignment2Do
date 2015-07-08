<?php
require_once ("../../includes/initialize.php");
 ?>
<?php
	if (!$session -> is_logged_in() || $_SESSION['role'] != "admin") { redirect_to("login.php");
	}
 ?>

<?php $logfile = SITE_ROOT . DS . 'logs' . DS . 'log.txt'; ?>

<?php include_layout_template('admin_header.php'); ?>

<a class="ui blue basic button" href="index.php">&laquo; Back</a>

<div style="min-height: 8rem; padding-bottom: 40px;" class="ui stacked segment">
	<p class="ui ribbon label">Log File</p>

<?php
if (file_exists($logfile) && is_readable($logfile) && $handle = fopen($logfile, 'r')) {// read
	echo "<ul class=\"log-entries\">";
	while (!feof($handle)) {
		$entry = fgets($handle);
		if (trim($entry) != "") {
			echo "<li>{$entry}</li>";
		}
	}
	echo "</ul>";
	fclose($handle);
} else {
	echo "Could not read from {$logfile}.";
}
?>
<a class="ui green submit button" href="../../logs/log.txt" download>Download log file</a>
<a class="ui blue submit button" href="clear_logfile.php?clear=true">Clear log file</a>
</div>
<?php include_layout_template('admin_footer.php'); ?>
<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in() || $_SESSION['role']!="admin") { redirect_to("login.php"); } ?>

<?php $logfile = SITE_ROOT . DS . 'logs' . DS . 'log.txt';

if ($_GET['clear'] == 'true') {
	file_put_contents($logfile, '');
	// Add the first log entry
	$role = ucfirst($_SESSION['role']);
	log_action('Logs Cleared', "by User ID {$session->user_id}, $role");
	// redirect to this same page so that the URL won't
	// have "clear=true" anymore
	redirect_to('logfile.php');
}else {
	redirect_to('logfile.php');
}
?>
<?php if(isset($database)) { $database->close_connection(); } ?>

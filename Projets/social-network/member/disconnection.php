<?php
	date_default_timezone_set('Europe/Paris');
	session_start();
	$_SESSION= array();
	session_destroy();
	
	header("Location: ../index/index.php");
	
?>
<?php
	session_start();
	include "main.php";
	$_SESSION['cameraid'] = $_POST['camera'];
	$_SESSION['eventid'] = $_POST['event'];
	$_SESSION['dateid'] = $_POST['date'];
	header("Location: ./search");
?>
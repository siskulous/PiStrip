<?php
	require_once "session.php";
	require_once "dbconfig.php";

	$query=sprintf("DELETE FROM schedule WHERE sid=%u",
		$_GET['sid']);
	$db->query($query);
?>
<?php
	require_once "session.php";
	require_once "dbconfig.php";
	var_dump($_GET);
	$com=sprintf("sudo setpin.py %u %u",
		$_GET['outlet'],
		$_GET['state']);
	exec($com);
	/* This is no longer needed as setpin.py handles it
	$query=sprintf("UPDATE outlets SET currentState=%u where oid=%u",
		$_GET['state'],
		$_GET['outlet']);
	*/
	$db->query($query);
?>
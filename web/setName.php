<?php
	require_once "session.php";
	require_once "dbconfig.php";

	$query=sprintf("UPDATE outlets SET currentItem='%s' WHERE oid=%u",
		$_GET['name'],
		$_GET['outlet']);
	$db->query($query);
	closeDB();
?>
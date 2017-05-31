<?php
	$sqlHost="localhost";
	$sqlUser="username";
	$sqlPw="password";
	$sqlDatabase="powerstrip";

	$db= new mysqli($sqlHost,$sqlUser,$sqlPw,$sqlDatabase);
	if($db->connect_errno){
		echo "Could not connect to database: " . $db->connect_error;
	}
	$db->set_charset('utf8');

	function closeBD(){
		global $db;
		$db->close();
	}
?>
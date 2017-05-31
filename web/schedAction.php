<?php
	require_once "session.php";
	require_once "dbconfig.php";
	var_dump($_POST);
	$tarDate=new DateTime($_POST['first']);
	if(isset($_POST["repeatSun"])){
		$Sun=1;
	} else {
		$Sun=0;
	}

	if(isset($_POST["repeatMon"])){
		$Mon=1;
	} else {
		$Mon=0;
	}

	if(isset($_POST["repeatTue"])){
		$Tue=1;
	} else {
		$Tue=0;
	}

	if(isset($_POST["repeatWed"])){
		$Wed=1;
	} else {
		$Wed=0;
	}

	if(isset($_POST["repeatThu"])){
		$Thu=1;
	} else {
		$Thu=0;
	}

	if(isset($_POST["repeatFri"])){
		$Fri=1;
	} else {
		$Fri=0;
	}

	if(isset($_POST["repeatSat"])){
		$Sat=1;
	} else {
		$Sat=0;
	}

	$query=sprintf("INSERT INTO schedule (
		outlet, firstEvent, state, repeatMon, repeatTue, repeatWed, repeatThu, repeatFri, repeatSat, repeatSun)
		VALUES (%u,'%s',%u,%u,%u,%u,%u,%u,%u,%u)",
		$_POST['outlet'],
		$tarDate->format('Y-m-d H:i:s'),
		$_POST['state'],
		$Mon,
		$Tue,
		$Wed,
		$Thu,
		$Fri,
		$Sat,
		$Sun
	);
	print $query;
	$db->query($query);
	$db->close();
?>
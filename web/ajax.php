<?php 
	require_once "session.php";
	require_once "dbconfig.php";

	if(!isset($_POST['field']) || !isset($_POST['value']) || !isset($_POST['sid'])){
		$db->close();
		die("Invalid Request: Missing required fields");
	}

	if($_POST['field'] == 'firstEvent'){
		$tarDate=new DateTime($_POST['value']) or die ("Invalid Request: Invalid date");
		$query=sprintf("UPDATE schedule SET firstEvent = '%s' WHERE sid = %u",
			$tarDate->format('Y-m-d H:i:s'),
			$_POST['sid']
		);
	} elseif ($_POST['field'] == "state") {
		if($_POST['value'] == "true"){
			$_POST['value']=1;
		} elseif($_POST['value'] == "false") {
			$_POST['value']=0;
		}
		if($_POST['value'] == 1 || $_POST['value'] == 0){
			$query=sprintf("UPDATE schedule SET state = %u WHERE sid = %u",
				$_POST['value'],
				$_POST['sid']
			);
			print $query;
		} else {
			$db->close();
			print "dying";
			die("Invalid Request: Invalid bit value");
		}
	} elseif ($_POST['field']=="Sun" ||$_POST['field']=="Mon" ||$_POST['field']=="Tue" ||$_POST['field']=="Wed" ||$_POST['field']=="Thu" ||$_POST['field']=="Fri" ||$_POST['field']=="Sat"){
		if($_POST['value'] == "true"){
			$_POST['value']=1;
		} elseif($_POST['value'] == "false") {
			$_POST['value']=0;
		}
		if($_POST['value'] == 1 || $_POST['value'] == 0){
			$query=sprintf("UPDATE schedule SET repeat%s = %u WHERE sid = %u",
				$_POST['field'],
				$_POST['value'],
				$_POST['sid']
			);
		} else {
			$db->close();
			die("Invalid Request: Invalid bit value");
		}
	} else {
		$db->close();
		die("Invalid Request: Invalid field");
	}

	$db->query($query);
	$db->close();
?>

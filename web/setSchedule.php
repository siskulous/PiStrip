<?php
	require_once "session.php";
	require_once "dbconfig.php";

	$query="SELECT oid, currentItem FROM outlets";
	$res=$db->query($query);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Set Schedule</title>
	<script src="includes/jquery-1.9.1.js"></script>
	<script src="includes/jquery-ui-1.11.4.js"></script>
	<script src="includes/moment.js"></script>
	<script src="includes/jquery.filthypillow.min.js"></script>
	<link rel="stylesheet" href="includes/jquery.filthypillow.css">
	<script type="text/javascript">
		$(function(){
			$(".datepicker").filthypillow();
			$(".datepicker").on("focus",function(){
				console.log("test");
				$(this).filthypillow("show");
			});
			$(".datepicker").on("fp:save",function(e,dateObj){
				$(this).val(dateObj.format("YYYY-MM-DD HH:mm:00.000"));
				$(this).filthypillow("hide");
			});
		});
	</script>
</head>
<body>
	<form action="schedAction.php" method="post">
		Outlet
		<select name="outlet">
			<?php
				while($row=$res->fetch_assoc()){
					print '<option value="'.$row['oid'].'">'.$row['oid']." - ".$row['currentItem']."</option>";
				}
			?>
		</select><br>
		State]
		<select name="state">
			<option value="0">On</option>
			<option value="1">Off</option>
		</select><br>
		First Event Datetime (yyyy-mm-dd hh:mm):
		<input type="text" class='datepicker' name="first"><br>
		<br>
		Repeat:<br>
		<input type="checkbox" name="repeatSun" value="1"> Sunday<br>
		<input type="checkbox" name="repeatMon" value="1"> Monday<br>
		<input type="checkbox" name="repeatTue" value="1"> Tuesday<br>
		<input type="checkbox" name="repeatWed" value="1"> Wednesday<br>
		<input type="checkbox" name="repeatThu" value="1"> Thursday<br>
		<input type="checkbox" name="repeatFri" value="1"> Friday<br>
		<input type="checkbox" name="repeatSat" value="1"> Saturday<br>
		<br>
		<input type="submit" value="Schedule event">
	</form>
</body>
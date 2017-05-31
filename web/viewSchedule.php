<?php
	require_once "session.php";
	require_once "dbconfig.php";

	if(!isset($_GET['outlet'])){
		$_GET['outlet']=1;
	}
	$query=sprintf("SELECT sid, state, firstEvent, repeatSun, repeatMon, repeatTue, repeatWed, repeatThu, repeatFri, repeatSat
		FROM schedule
		WHERE outlet=%u",
		$_GET['outlet']);
	$res=$db->query($query) or die("SQL Error: " . $db->error);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Schedules</title>

</head>
<body>
	<?php
		print "Schedule for outlet ".$_GET['outlet'];
	?>
	<table>
		<tr>
			<th>First Event</th>
			<th>State</th>
			<th>Repeat<br>Sunday</th>
			<th>Repeat<br>Monday</th>
			<th>Repeat<br>Tuesday</th>
			<th>Repeat<br>Wednesday</th>
			<th>Repeat<br>Thursday</th>
			<th>Repeat<br>Friday</th>
			<th>Repeat<br>Saturday</th>
			<th></th>
		</tr>
		<?php
			while($row=$res->fetch_assoc()){
				print "<tr><td>".$row['firstEvent']."</td>";
				if($row['state']==1){
					print "<td>Off</td>";
				} else {
					print "<td>On</td>";
				}
				print "<td>";
				if($row['repeatSun']==0){
					print "Off";
				} else {
					print "On";
				}
				print "</td>";
				print "<td>";
				if($row['repeatMon']==0){
					print "Off";
				} else {
					print "On";
				}
				print "</td>";
				print "<td>";
				if($row['repeatTue']==0){
					print "Off";
				} else {
					print "On";
				}
				print "</td>";
				print "<td>";
				if($row['repeatWed']==0){
					print "Off";
				} else {
					print "On";
				}
				print "</td>";
				print "<td>";
				if($row['repeatThu']==0){
					print "Off";
				} else {
					print "On";
				}
				print "</td>";
				print "<td>";
				if($row['repeatFri']==0){
					print "Off";
				} else {
					print "On";
				}
				print "</td>";
				print "<td>";
				if($row['repeatSat']==0){
					print "Off";
				} else {
					print "On";
				}
				print "</td>";
				print "<td>";
				print '<form><input type="button" value="Delete" class="delete" rel="'.$row['sid'].'"></form>';
				print "</td></tr>";
			}
		?>
	</table>
</body>
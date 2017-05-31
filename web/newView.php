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
	<form>
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
					print "<tr><td><input type='text' class='schedFirst datepicker' ".
						'rel="' . $row['sid'] . '" value="'.
						$row['firstEvent'].'"></td>';

					print '<td><select class="schedStatus" rel="'.$row['sid'].'">';
					if($row['state']==0){
						print '<option value="0">Off</option>'.
						'<option value="1" selected="true">On</option>';
					} else {
						print '<option value="0" selected="true">Off</option>'.
						'<option value="1">On</option>';
					}
					print "</select></td>";
					print '<td><input type="checkbox" class="schedSun" rel="'.
						$row['sid'] . '" ';
					if($row['repeatSun']==1){
						print 'checked="true"';
					}
					print "></td>";
					print '<td><input type="checkbox" class="schedMon" rel="'.
						$row['sid'] . '" ';
					if($row['repeatMon']==1){
						print 'checked="true"';
					}
					print "></td>";
					print '<td><input type="checkbox" class="schedTue" rel="'.
						$row['sid'] . '" ';
					if($row['repeatTue']==1){
						print 'checked="true"';
					}
					print "></td>";
					print '<td><input type="checkbox" class="schedWed" rel="'.
						$row['sid'] . '" ';
					if($row['repeatWed']==1){
						print 'checked="true"';
					}
					print "></td>";
					print '<td><input type="checkbox" class="schedThu" rel="'.
						$row['sid'] . '" ';
					if($row['repeatThu']==1){
						print 'checked="true"';
					}
					print "></td>";
					print '<td><input type="checkbox" class="schedFri" rel="'.
						$row['sid'] . '" ';
					if($row['repeatFri']==1){
						print 'checked="true"';
					}
					print "></td>";
					print '<td><input type="checkbox" class="schedSat" rel="'.
						$row['sid'] . '" ';
					if($row['repeatSat']==1){
						print 'checked="true"';
					}
					print "></td>";
					print "<td>";
					print '<form><input type="button" value="Delete" class="delete" rel="'.$row['sid'].'"></form>';
					print "</td></tr>";
				}
			?>
		</table>
	</form>
</body>
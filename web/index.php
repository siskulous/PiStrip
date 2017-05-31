<?php
	require_once "session.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="manifest" href="manifest.json">
	<title>Power Strip Control</title>
	<script src="includes/jquery-1.9.1.js"></script>
	<script src="includes/jquery-ui-1.11.4.js"></script>
	<script src="includes/moment.js"></script>
	<script src="includes/jquery.filthypillow.min.js"></script>
	<link rel="stylesheet" href="includes/jquery.filthypillow.css">
	<script>
		window.onload=function(){
			offs=document.getElementsByClassName("off");
			ons=document.getElementsByClassName("on");
			names=document.getElementsByClassName("curItem");
			for(i=0;i<offs.length;i++){
				offs[i].addEventListener("click",offCallback, false);
			}
			for(i=0;i<ons.length;i++){
				ons[i].addEventListener("click",onCallback, false);
			}
			for(i=0;i<names.length;i++){
				names[i].addEventListener("change",nameCallback,false);
			}
			document.getElementById("schedSelect").addEventListener("change",schedCallback,false);
			schedCallback();

			//All code after here was added after I decided to quit
			//being a masochist and use jquery.

			$("body").on("click",".delete",function(){
				//req.open("GET","deleteSched.php?sid="+sid);
				$.get("deleteSched.php",
					{
						sid:$(this).attr("rel")
					},
					function(){
						schedCallback();
					}
				);
			});
			
			$("body").on("change",".schedStatus",function(){
				$.post("ajax.php",
					{
						field:"state",
						sid:$(this).attr("rel"),
						value:$(this).val()
					}
				);
			});
			$("body").on("click",".schedSun",function(){
				$.post("ajax.php",
					{
						field:"Sun",
						sid:$(this).attr("rel"),
						value:$(this).is(":checked")
					}
				);
			});
			$("body").on("click",".schedMon",function(){
				$.post("ajax.php",
					{
						field:"Mon",
						sid:$(this).attr("rel"),
						value:$(this).is(":checked")
					}
				);
			});
			$("body").on("click",".schedTue",function(){
				$.post("ajax.php",
					{
						field:"Tue",
						sid:$(this).attr("rel"),
						value:$(this).is(":checked")
					}
				);
			});
			$("body").on("click",".schedWed",function(){
				$.post("ajax.php",
					{
						field:"Wed",
						sid:$(this).attr("rel"),
						value:$(this).is(":checked")
					}
				);
			});
			$("body").on("click",".schedThu",function(){
				$.post("ajax.php",
					{
						field:"Thu",
						sid:$(this).attr("rel"),
						value:$(this).is(":checked")
					}
				);
			});
			$("body").on("click",".schedFri",function(){
				$.post("ajax.php",
					{
						field:"Fri",
						sid:$(this).attr("rel"),
						value:$(this).is(":checked")
					}
				);
			});
			$("body").on("click",".schedSat",function(){
				$.post("ajax.php",
					{
						field:"Sat",
						sid:$(this).attr("rel"),
						value:$(this).is(":checked")
					}
				);
			});
		}

		function delCallback(){
			if(confirm("Delete this schedule?")){
				console.log(this.attributes.rel.value);
				var req=new XMLHttpRequest();
				var sid=this.attributes.rel.value
				req.open("GET","deleteSched.php?sid="+sid);
				req.onreadystatechange=function(){
					if(req.readyState=XMLHttpRequest.DONE){
						schedCallback();
					}
				}
				req.send();
			}
		}
		
		function schedCallback(){
			var sel=document.getElementById("schedSelect");
			var o=sel.options[sel.selectedIndex].value;
			var req=new XMLHttpRequest();
			req.open("GET","newView.php?outlet="+o);
			req.onreadystatechange=function(){
				if(req.readyState=XMLHttpRequest.DONE){
					document.getElementById("schedView").innerHTML=req.responseText;
					$(".schedFirst").filthypillow();
					$(".schedFirst").on("focus",function(){
						console.log("test");
						$(this).filthypillow("show");
					});
					$(".schedFirst").on("fp:save",function(e,dateObj){
						$(this).val(dateObj.format("YYYY-MM-DD HH:mm:00.000"));
						$(this).filthypillow("hide");
						$.post("ajax.php",
							{
								field:"firstEvent",
								sid:$(this).attr("rel"),
								value:$(this).val()
							}
						);				
					});
				}
			}
			req.send();


		}

		function offCallback(){
			console.log(this.attributes.rel.value);
			var req=new XMLHttpRequest();
			var outlet=this.attributes.rel.value
			req.open("GET","setPin.php?state=1&outlet="+outlet);
			req.send();
			document.getElementById(outlet + "state").innerHTML="Off";
		}

		function onCallback(){
			console.log(this.attributes.rel.value);
			var req=new XMLHttpRequest();
			var outlet=this.attributes.rel.value
			req.open("GET","setPin.php?state=0&outlet="+outlet);
			req.send();
			document.getElementById(outlet + "state").innerHTML="On";
		}

		function nameCallback(){
			console.log(this.attributes.rel.value);
			var req=new XMLHttpRequest();
			var outlet=this.attributes.rel.value
			var name=this.value;
			req.open("GET","setName.php?name="+name+"&outlet="+outlet);
			req.send();
			document.getElementById(outlet + "state").innerHTML="On";
		}
	</script>
</head>
<body>
	<table>
		<tr>
			<th>Off</th>
			<th>On</th>
			<th>Current<br>Item</th>
			<th>Current<br>State</th>
		</tr>

		<?php
			require_once "dbconfig.php";

			$query="SELECT oid, currentItem, currentState FROM outlets";
			$res=$db->query($query);
			while($row=$res->fetch_assoc()){
				print '<tr>';
				print '<td><input type="button" class="off" rel="'.$row['oid'].'" value="Outlet '.$row['oid'].' Off"></td>';
				print '<td><input type="button" class="on" rel="'.$row['oid'].'" value="Outlet '.$row['oid'].' On"></td>';
				print '<td><input type="text" class="curItem" rel="'.$row['oid'].'" value="'.$row['currentItem'].'"></td>';
				print '<td id="'.$row['oid'].'state">';
				if($row['currentState']==1){
					print "Off";
				} else {
					print "On";
				}
				print '</td>';
			}
		?>
	</table>
	<form>
		<select id="schedSelect">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
		</select>
		<a href="setSchedule.php" target="_blank">Set Schedule</a>
	</form>
	<div id="schedView"></div>
</body>
</html>
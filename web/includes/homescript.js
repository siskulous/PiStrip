function boolToInt(bool){
	if(bool){
		return 1;
	} else {
		return 0;
	}
}

function getSchedule(){
	$.get("ajax.php",
		{
			method:"getSchedule"
		},
		function(data){
			$("#curSchedule").html(data);
			$(".editDate").filthypillow();
			$(".editDate").on("focus",function(){
				$(this).filthypillow("show");
			});
			$(".editDate").on("fp:save",function(e,dateObj){
				$(this).val(dateObj.format("YYYY-MM-DD HH:mm:00.000"));
				subEdit($(this).attr("rel"));
				$(this).filthypillow("hide");
			});
		}
	);
}
function subEdit(rel){
	$.post("ajax.php",
		{
			method:"edit",
			sid:rel,
			name:$('.editName[rel="'+rel+'"]').val(),
			first:$('.editDate[rel="'+rel+'"]').val(),
			repeatSun:boolToInt($('.editSun[rel="'+rel+'"]').is(":checked")),
			repeatMon:boolToInt($('.editMon[rel="'+rel+'"]').is(":checked")),
			repeatTue:boolToInt($('.editTue[rel="'+rel+'"]').is(":checked")),
			repeatWed:boolToInt($('.editWed[rel="'+rel+'"]').is(":checked")),
			repeatThu:boolToInt($('.editThu[rel="'+rel+'"]').is(":checked")),
			repeatFri:boolToInt($('.editFri[rel="'+rel+'"]').is(":checked")),
			repeatSat:boolToInt($('.editSat[rel="'+rel+'"]').is(":checked")),
			enabled:boolToInt($('.enable[rel="'+rel+'"]').is(":checked"))
		},function(data){
			if(data != "Schedule Updated"){
				alert(data);
			}
			
		});
}
$(function(){
	$("body").on("click","#overlay",function(){
		$("#overlay, #modal").hide();
	});
	/*
	$("body").on("click",".editSubmit",function(){
		$.post("ajax.php",
			{
				method:"edit",
				sid:$(".editSID").val(),
				name:$(".editName").val(),
				first:$(".editDate").val(),
				repeatSun:$(".editRepeatSun").is(":checked"),
				repeatMon:$(".editRepeatMon").is(":checked"),
				repeatTue:$(".editRepeatTue").is(":checked"),
				repeatWed:$(".editRepeatWed").is(":checked"),
				repeatThu:$(".editRepeatThu").is(":checked"),
				repeatFri:$(".editRepeatFri").is(":checked"),
				repeatSat:$(".editRepeatSat").is(":checked")
			}, function(data){
				alert(data);
			}
		);
	});
*/
	$("body").on("click",".editField[type='checkbox']",function(){
		var rel=$(this).attr("rel");
		subEdit(rel);
	});
	$("body").on("blur",".editName",function(){
		var rel=$(this).attr("rel");
		subEdit(rel);
	});
	$("body").on("click",".submitNew",function(){
		$.post("ajax.php",
			{
				method:"new",
				first:$(".newDate").val(),
				name:$(".newName").val(),
				repeatSun:boolToInt($(".newRepeatSun").is(":checked")),
				repeatMon:boolToInt($(".newRepeatMon").is(":checked")),
				repeatTue:boolToInt($(".newRepeatTue").is(":checked")),
				repeatWed:boolToInt($(".newRepeatWed").is(":checked")),
				repeatThu:boolToInt($(".newRepeatThu").is(":checked")),
				repeatFri:boolToInt($(".newRepeatFri").is(":checked")),
				repeatSat:boolToInt($(".newRepeatSat").is(":checked"))
			}, function(data){
				alert(data);
				getSchedule();
			}
		);
	});
	var $newfp=$(".newDate")
	$newfp.filthypillow();
	$newfp.on("focus",function(){
		console.log("click");
		$newfp.filthypillow("show");
	});
	$newfp.on("fp:save",function(e,dateObj){
		$newfp.val(dateObj.format("YYYY-MM-DD HH:mm:00.000"));
		$newfp.filthypillow("hide");
	});

	$("body").on("click",".delete",function(){
		if(confirm("Delete this schedule?")){
			$.get("ajax.php",
				{
					method:"delete",
					sid:$(this).attr("rel")
				},function(data){
					alert(data);
					getSchedule();
				}
			)
		}
	});

	getSchedule();
});
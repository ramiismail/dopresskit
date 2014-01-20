$(function(){

	$("#submit-button").click(function(){
				
		var from = $("#from").val();
		var outlet = $("#outlet").val();
		var subject = "[Request] " + $("#game-title").html() + " Press Copy For " + outlet;
		var content = from + " of " + outlet + " has requested a Press Copy for "+ $("#game-title").html() +" through the press kit interface.";
		
		var data = "from=" + from + "&subject=" + subject + "&content=" + content;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		
		$('#mailinvalid').fadeOut(200);
		$('#mailerror').fadeOut(200);
		
		if( from && emailReg.test(from) && from != "me@website.com" )
		{
			$.ajax({
				type: "POST",
				url: "mail.php",
				data: data,
				success: function(){
					$('#mailform').fadeOut(200);
					$('#mailsuccess').fadeIn(300).show();
				},
				error: function(){
					$('#mailerror').fadeIn(300).show();
				}
			});
		}
		else
		{
			$('#mailinvalid').fadeIn(300).show();
		}
		return false;
	});
});
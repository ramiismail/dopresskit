$(function(){
	$( "#pressrequest" ).submit(function( event ) {
		var nocache = new Date().getTime();

		var data = {
			from: $( "#from" ).val(),
			outlet : $( "#outlet" ).val(),
			game: $( "#game" ).val(),
			gametitle: $( "#gametitle" ).val()
		}

		$.post( "mail.php?ajax=" + nocache, data, function( result ) {
			if (result.success) {
				var html = '<div class="uk-alert uk-alert-success">Thanks for the request. We\'ll be in touch as soon as possible. In the meanwhile, feel free to <a href="#contact">follow up with any questions or requests you might have!</a></div>';
			} else {
				if (result.error == 'from') {
					var html = '<div class="uk-alert uk-alert-danger">We could not validate your email address. Please try contacting us using <a href="#contact">one of the options listed here</a>.</div>';
				} else if (result.error == 'empty') {
					var html = '<div class="uk-alert uk-alert-danger">Please fill in all the fields or try contacting us using <a href="#contact">one of the options listed here</a>.</div>';
				} else {
					var html = '<div class="uk-alert uk-alert-danger">We failed to send the email. Please try contacting us using <a href="#contact">one of the options listed here</a>.</div>';
				}
			}

			$( html ).insertAfter( "#mailform" );
		});

		event.preventDefault();
	});
});

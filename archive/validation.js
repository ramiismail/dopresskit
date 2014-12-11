$(function(){
	$( "#pressrequest" ).submit(function( event ) {
		var nocache = new Date().getTime();

		var data = {
			from: $( "#from" ).val(),
			outlet : $( "#outlet" ).val(),
			game: $( "#game" ).val(),
			gametitle: $( "#gametitle" ).val(),
			l: $( "#language" ).val()
		}

		$.post( "mail.php?ajax=" + nocache, data, function( result ) {
			if (result.success) {
				var html = '<div class="uk-alert uk-alert-success">'+ result.message +'</div>';
			} else {
				var html = '<div class="uk-alert uk-alert-danger">'+ result.message +'</div>';
			}

			$( html ).insertAfter( "#mailform" );
		});

		event.preventDefault();
	});
});

$(document).ready(function(){
	$('#registerEmail').keyUp(function(){
		var url = "/wp-admin/admin-ajax.php?action=email_check";

		$.ajax({
			type:'GET',
			url:url,
			success: function(data){

			}
		});
	});
});
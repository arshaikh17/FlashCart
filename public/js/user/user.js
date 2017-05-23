$(document).ready(function()
{
	$(".viewer_button").click(function(e)
	{
		$.ajaxSetup(
        {
			headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
		});
    	
		var id = $(this).attr('id');
		$.ajax(
		{
			url: '/user/messages/seen_messages',
			data: {id: id},
			method: "POST"
		});
	});
});
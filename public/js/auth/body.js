$(document).ready(function()
{
	$("#login_email, #login_password").hide();
	$("#login_email").show('slide', {direction: 'left'}, 200);
	$("#login_password").show('slide', {direction: 'right'}, 200);

	$("#username, #name, #email, #password, #password-confirm").hide();
	$("#username").show('slide', {direction: 'left'}, 200);
	$("#name").show('slide', {direction: 'right'}, 200);
	$("#email").show('slide', {direction: 'left'}, 200);
	$("#password").show('slide', {direction: 'right'}, 200);
	$("#password-confirm").show('slide', {direction: 'left'}, 200);
});
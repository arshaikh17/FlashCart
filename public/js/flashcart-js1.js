$(document).ready(function()
{
	//{{ url('/register') }}
	$("#username").blur(function()
	{
		var username = $(this).val();
		checkUsername(username);

	});
	$("#email").blur(function()
	{
		var email = $(this).val();
		checkEmail(email);
	});
    /*$("#userRegister").submit(function(e)
    {
        //$(this).css("background-color", "red");
        e.preventDefault();
        $(".loader").slideDown(200);
        var username = $(this).val();
        //var user = checkUsername(username);

        var email = $(this).val();
		//var check_email =	checkEmail(email);

        $.ajaxSetup(
        {
			headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
		});
		if(u_success == true)
		{
			if(e_success==true)
			{
				$.ajax(
				{
					url: '/register',
					method: 'POST',
					data: $(this).serialize(),
					success:function()
					{
						window.location.href = "/home";
					}
				});
			}
			else
			{
				$(".loader").slideUp(200);
				return false;
			}
		}
		else
		{
			$(".loader").slideUp(200);
			return false;
		}
		//alert(e_success+ " "+u_success);
    });*/

    function checkEmail(email)
    {
    	$.ajaxSetup(
        {
			headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
		});
    	
    	$.ajax(
    	{
		    url: '/check_email',
    		method: 'POST',
        	data: {"email":email},
	        success: function(data)
			{
    		   	if(data.error == "yes")
        		{
	        	
    	    		$("#email_error").text("Email already exists");

    	    		window.e_success = false;
	        	}	
		       	else
	    	    {
    		    	$("#email_error").text("");

        			window.e_success = true;
	        	}
		    }
  		});
    }


    function checkUsername(username)
    {
    	$.ajaxSetup(
        {
			headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
		});
    	
    	$.ajax(
    	{
		    url: '/check_username',
    		method: 'POST',
        	data: {"username":username},
	        success: function(data)
			{
    		   	if(data.error == "yes")
        		{
	        	
    	    		$("#username_error").text("Username already exists");

    	    		window.u_success = false;
	        	}	
		       	else
	    	    {
    		    	$("#username_error").text("");

        			window.u_success = true;
	        	}
		    }
  		});
    }
    /////////////////////////////////////////////////////
    $("#store_username").blur(function()
	{
		var store_username = $(this).val();
		checkStoreUsername(store_username);

	});
	$("#store_name").blur(function()
	{
		var store_name = $(this).val();
		checkStoreName(store_name);
		var slug = convertToSlug(store_name);
		$("#store_slug").val("");
		$("#store_slug").val(slug);
	});
	$("#store_email").blur(function()
	{
		var store_email = $(this).val();
		checkStoreEmail(store_email);
	});
    /*$("#storeRegister").submit(function(e)
    {
        //$(this).css("background-color", "red");
        e.preventDefault();
        $(".loader").slideDown(200);
        var store_username = $(this).val();
        //var user = checkUsername(username);

        var store_email = $(this).val();
		//var check_email =	checkEmail(email);

        $.ajaxSetup(
        {
			headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
		});
		if(u_s_success == true)
		{
			if(e_s_success==true)
			{
				if(n_s_success == true)
				{
					$.ajax(
					{
						url: '/save_store',
						method: 'POST',
						data: $(this).serialize(),
						success:function()
						{
							window.location.href = "/home";
						}
					});
				}
				else
				{
					$(".loader").slideUp(200);
					return false;
				}
			}
			else
			{
				$(".loader").slideUp(200);
				return false;
			}
		}
		else
		{
			$(".loader").slideUp(200);
			return false;
		}
		//alert(e_success+ " "+u_success);
    });*/

    function checkStoreName(store_name)
    {
    	$.ajaxSetup(
        {
			headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
		});
    	
    	$.ajax(
    	{
		    url: '/check_store_name',
    		method: 'POST',
        	data: {"store_name":store_name},
	        success: function(data)
			{
    		   	if(data.error == "yes")
        		{
	        	
    	    		$("#name_error").text("Store of this name already exists.");

    	    		window.n_s_success = false;
	        	}	
		       	else
	    	    {
    		    	$("#name_error").text("");

        			window.n_s_success = true;
	        	}
		    }
  		});
    }

    function checkStoreEmail(store_email)
    {
    	$.ajaxSetup(
        {
			headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
		});
    	
    	$.ajax(
    	{
		    url: '/check_store_email',
    		method: 'POST',
        	data: {"store_email":store_email},
	        success: function(data)
			{
    		   	if(data.error == "yes")
        		{
	        	
    	    		$("#email_error").text("Email already exists");

    	    		window.e_s_success = false;
	        	}	
		       	else
	    	    {
    		    	$("#email_error").text("");

        			window.e_s_success = true;
	        	}
		    }
  		});
    }


    function checkStoreUsername(store_username)
    {
    	$.ajaxSetup(
        {
			headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
		});
    	
    	$.ajax(
    	{
		    url: '/check_store_username',
    		method: 'POST',
        	data: {"store_username":store_username},
	        success: function(data)
			{
    		   	if(data.error == "yes")
        		{
	        	
    	    		$("#username_error").text("Username already exists");

    	    		window.u_s_success = false;
	        	}	
		       	else
	    	    {
    		    	$("#username_error").text("");

        			window.u_s_success = true;
	        	}
		    }
  		});
    }

    function convertToSlug(Text)
	{
    	return Text
        	.toLowerCase()
        	.replace(/[^\w ]+/g,'')
        	.replace(/ +/g,'-')
        	;
	}
});

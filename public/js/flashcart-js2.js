$(document).ready(function()
{
	var store_old_name = $("#store_name").val();
	var store_old_username = $("#store_username").val();
	var store_old_email = $("#store_email").val();
    $("#store_username").blur(function()
	{
		var store_username = $(this).val();
		if(store_username != store_old_username)
		{
			checkStoreUsername(store_username);
		}

	});
	$("#store_name").blur(function()
	{
		var store_name = $(this).val();
		if(store_name != store_old_name)
		{
			checkStoreName(store_name);
			var slug = convertToSlug(store_name);
			$("#store_slug").val("");
			$("#store_slug").val(slug);
		}
	});
	$("#store_email").blur(function()
	{
		var store_email = $(this).val();
		if(store_email != store_old_email)
		{
			checkStoreEmail(store_email);
		}
	});
    /*$("#storeUpdate").submit(function(e)
    {
        //$(this).css("background-color", "red");
        e.preventDefault();
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
						url: '/update_store',
						method: 'POST',
						data: $(this).serialize(),
						success:function()
						{
						}
					});
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
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


	/*$("#new-cats").submit(function(e)
	{
		e.preventDefault();

		var new_cat = $("#new-category option:selected").text();
		$(".current-categories").fadeOut(500);

		$.ajaxSetup(
        {
			headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
		});

		$.ajax(
		{
			url: '/add_category',
			data: $(this).serialize(),
			method: 'POST',
			success: function()
			{
				$(".current-categories").append("<li>"+new_cat+"</li>");
				$(".current-categories").fadeIn(200);
				$("#new-category option:selected").remove();
			}
		});
	});*/

	$("#product_code").blur(function()
	{
		var code = $(this).val();
		var old_code = $("#old_code").val();
		if(code != old_code)
		{
			check_code(code);
		}
			
	});

	/*$("#addProduct").submit(function(e)
	{
		e.preventDefault();
		var name = $("#product_name").val();
		var username = $("#store_username").val();
		var code = $("#product_code").val();
		var slug = code+"-"+username+"-"+convertToSlug(name);
		$("#product_slug").val("");
		$("#product_slug").val(slug);

		$.ajax(
		{
			url: '/add_p',
			data: new FormData($("#addProduct")[0]),
			method: 'POST',
			dataType:'json',
      		async:false,
      		processData: false,
      		contentType: false,
      		success:function() 
      		{
      			
      		}
		});
		$("#addProduct").fadeOut(400, function()
		{
			$(this)[0].reset();
		}).fadeIn(400);
	});
	*/

	function check_code(code)
	{
		$.ajaxSetup(
        {
			headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
		});
    	
    	$.ajax(
    	{
		    url: '/check_code',
    		method: 'POST',
        	data: {"code":code},
	        success: function(data)
			{
    		   	if(data.error == "yes")
        		{
	        	
    	    		$("#product_code_error").text("Username already exists");

    	    		window.pc_s_success = false;
	        	}	
		       	else
	    	    {
    		    	$("#product_code_error").text("");

        			window.pc_s_success = true;
	        	}
		    }
  		});
	}

	$("#updateProduct").submit(function(e)
	{
		e.preventDefault();
		var name = $("#product_name").val();
		var username = $("#store_username").val();
		var code = $("#product_code").val();
		var slug = code+"-"+username+"-"+convertToSlug(name);
		$("#product_slug").val("");
		$("#product_slug").val(slug);

		var id = $("#id").val();

		$.ajax(
		{
			url: '/edited_p/'+id,
			data: new FormData($("#updateProduct")[0]),
			method: 'POST',
			dataType:'json',
      		async:false,
      		processData: false,
      		contentType: false,
      		success:function() 
      		{
      			
      		}
		});
		$("#updateProduct").fadeOut(400, function()
		{
		}).fadeIn(400);
	});

});

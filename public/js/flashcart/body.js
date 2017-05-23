$(document).ready(function()
{
	$("#category_nav_ul_category").click(function()
	{
		$("#category_nav_div").slideToggle(400);
	});

	/*$(".category").hover(function()
	{
		var cat = $(this).attr('id');
		//alert(cat);
		$("#sub_cat_"+cat).toggleClass('display');
	});*/
	//$("#heading, #tag_line").hide();
	$("#heading").animate({
    top: '0px'
  }, 500 );
	$("#tag_line").delay(500).animate({
    top: '0px'
  }, 500 );

	$(".featured_anchor").click(function(e)
	{
		e.preventDefault();
		$("#home").slideUp(500);
		$(".featured_div").delay(500).slideDown(500);
	});

	$(".featured_anchor_close").click(function(e)
	{
		e.preventDefault();
		$(".featured_div").slideUp(500);
		$("#home").delay(500).slideDown(500);
	});

});
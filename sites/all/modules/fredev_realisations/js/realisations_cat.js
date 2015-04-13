(function($)
{
	$(function()
	{
		$(".sheet").css("cursor", "pointer").click(function()
		{
			sessionStorage.setItem("recaid", $(this).find(".tag").attr("data-id"));
			window.location.href = "/realisations";
		});
	});
	
})(jQuery);
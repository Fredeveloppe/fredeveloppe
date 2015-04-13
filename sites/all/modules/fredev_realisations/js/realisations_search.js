(function($)
{
	$(document).ready(function()
	{
		$("#realisations-wrapper .box").each(prepareHover);


		// Gestion du shuffle dynamique
		var initialData = $('#wrapping').clone();	
		var selectedCat = "*";

		// Connecteur de catégories via le menu
		$("#realisations-cats li").click(function()
		{
			var node = $(this);
			if(!node.hasClass("active"))
			{
				node.parent().find(".active").removeClass("active");
				node.addClass("active");
				$("#realisations-cats select option").filter(function()
				{
					return node.attr("data-recaid") == $(this).val();
				}).attr('selected', true);
				$("#realisations-cats select").trigger("change");
			}
			
		});

		// Connecteur de catégories via le selectbox
		$("#realisations-cats select").change(function()
		{
			selectedCat = $(this).val();
			$("#realisations-cats li.active").removeClass("active");
			$("#realisations-cats li[data-recaid='" + selectedCat + "']").addClass("active");

			merge_query();
		});

		// Effectue l'affichages des éléments de la dite catégorie
		function merge_query()
		{
			var newData = initialData;

			if(selectedCat != "*") newData = newData.find("article[data-recaid~='" + selectedCat + "']").clone();
			else newData = newData.find(".box").clone();

			if(newData.length == 0) newData = $("<div data-id='nothing' class='nothing-to-see'>").text("Aucune réalisation ne correspond à votre recherche...");

            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) $('#wrapping').html(newData);
            else $('#wrapping').quicksand(newData, {
			      adjustHeight : 'dynamic',
			      adjustWidth : 'dynamic',
			      useScaling : true,           
			});

            $("#realisations-wrapper .box").each(prepareHover);
		}

		if(sessionStorage.getItem("recaid"))
		{
			selectedCat = sessionStorage.getItem("recaid");
			sessionStorage.removeItem("recaid");
			$("#realisations-cats select option").filter(function()
			{
				return selectedCat == $(this).val();
			}).attr('selected', true);
			$("#realisations-cats select").trigger("change");
		}


	});

	// Série de fonction pour transformer un code hexadécimal en son équivalence RGB
	function hexToR(h) {return parseInt((cutHex(h)).substring(0,2),16)}
	function hexToG(h) {return parseInt((cutHex(h)).substring(2,4),16)}
	function hexToB(h) {return parseInt((cutHex(h)).substring(4,6),16)}
	function cutHex(h) {return (h.charAt(0)=="#") ? h.substring(1,7):h}

	// Effet des bordures de couleur pour représenter la catégorie
	function prepareHover()
	{
		var color = cutHex($(this).attr("data-color"));

		$(this).find(".hover").hover(function()
		{
			$(this).css("border-color", "rgba(" + hexToR(color) + "," + hexToG(color) + "," + hexToB(color) + ",0.75)");
		}, function()
		{
			$(this).css("border-color", "rgba(" + hexToR(color) + "," + hexToG(color) + "," + hexToB(color) + ",0)");
		});
	}
})(jQuery);
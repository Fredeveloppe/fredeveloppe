(function($)
{
	var mediaTimer, 
		erreur = 0,
		Page;

	$(function()
	{
		// Effet de mouseOver sur les médias sociaux
		$("#contact-media-icon").on('mouseenter', "img", function()
		{
			clearTimeout(mediaTimer);

			var node = this;
			$(this).removeClass("contact-overlay").closest("#contact-media-icon").find("img").not(this).addClass("contact-overlay");

			mediaTimer = setTimeout(function(){hideTip(node);},100);
		});

		// Fais tourner la page
		Page = (function() {
				
			var config = {
					bookBlock : $('#bb-bookblock')
				},
				init = function() {
					config.bookBlock.bookblock( {
						speed : 800,
						shadowSides : 0.8,
						shadowFlip : 0.7
					} );
					initEvents();
				},
				initEvents = function() {
					// add keyboard events

					/*
					$( document ).keydown( function(e) {
						console.log("Next!");
						config.bookBlock.bookblock( 'next' );
					} );
					*/
				},
				nextPage = function()
				{
					config.bookBlock.bookblock( 'next' );
				}

				return { init : init, nextPage: nextPage};
		})();
		Page.init();

		// Validation automatique d'un champ
		$("#form-contact textarea, #form-contact input").change(function()
		{
			valider_champ(this.id);
		});

		// Validation de tous les champs
		$("#form-contact").submit(function()
		{
			return valider_all_champs();
		});

		// Efface tous les indicateurs d'erreurs
		$("#form-contact .action-btns .effacer").click(function()
		{
			$(".erreurIcon").removeClass("valide invalide").qtip('destroy', true).attr('title', "").qtip({
				style: {
			        classes: "qtip-light qtip-rounded qtip-shadow"
			    },
		        content: this.title,
		        position: {
		            target: 'mouse',
		            adjust: { x: 15, y: 30 },
		            viewport: $(window)
		        }
			});
		});

	});

	// Simulation du mouseOut
	function hideTip(objet)
	{
		if ($(objet).is(":hover")) mediaTimer = setTimeout(function(){hideTip(objet);},100);
		else $("#contact-media-icon").find("img").removeClass("contact-overlay");
	}

	// Validation du champ passé en paramètre
	function valider_champ(idChamp)
	{
		var message_erreur = "",
			field = $("#" + idChamp),
			currErreur = false;

		if(idChamp == "prenom") idChamp = "prénom";

		if(field.val().length != 0)
		{

			switch(idChamp)
			{
				case "prénom":
				case "nom":

					var caracteres_valides = "ABCDEFGHIJKLMNOPQRSTUVWXYZÇçéèêëÉÈÊËöòôÖÒÔïîìÏÎÌ0123456789-' ";
					
					for(var i = 0; i < field.length; i++)
					{
						if(i == 0)
						{
							// Validation du premier caractères
							if(caracteres_valides.substr(0, caracteres_valides.indexOf("0")).indexOf(field.val()[i].toUpperCase()) < 0)
							{
								message_erreur = "Votre " + idChamp + " doit commencer par une lettre";
								erreur++;
								currErreur = true;
							}
						}
						else if(caracteres_valides.indexOf(field.val()[i].toUpperCase()) < 0)
						{
							message_erreur = "Caractères invalides dans votre " + idChamp;
							erreur++;
							currErreur = true;
						}
					}

					break;

				case "courriel":

					pattern = /^[a-z](([a-z0-9]|\-|\.|\_)?[a-z0-9])+@[a-z]+(\-[a-z]+)?(\.[a-z]{2,6}){1,2}$/i;
					if(!pattern.test(field.val()))
					{
						message_erreur = "Cette adresse courriel n'existe pas";
						erreur++;
						currErreur = true;
					}

					break;

				default:
					
					pattern = /^\s*$/;	
					if(pattern.test(field.val()))
					{
						message_erreur = "Veuillez entrer un vrai " + idChamp;
						erreur++;
						currErreur = true;
					}

					break;
			}

			if(currErreur) switch_icon_class(field.parent().find(".erreurIcon"), "invalide", message_erreur);
			else switch_icon_class(field.parent().find(".erreurIcon"), "valide", "");
		}
		else
		{
			erreur++;
			message_erreur = "Veuillez entrer votre " + idChamp;
			switch_icon_class(field.parent().find(".erreurIcon"), "invalide", message_erreur);
		}
	}

	// Prépare le tooltip du message d'erreur
	function switch_icon_class(icon, iconClass, iconMess)
	{
		icon.removeClass("invalide valide").addClass(iconClass).qtip('destroy', true).attr('title', iconMess).qtip({
			style: {
		        classes: "qtip-light qtip-rounded qtip-shadow"
		    },
	        content: this.title,
	        position: {
	            target: 'mouse',
	            adjust: { x: 15, y: 30 },
	            viewport: $(window)
	        }
		});
	}

	// Validation de tous les champs
	function valider_all_champs()
	{
		$("#contact-submit").attr("disabled", "disabled");
		erreur = 0;

		valider_champ('prenom');
		valider_champ('nom');
		valider_champ('courriel');
		valider_champ('sujet');
		valider_champ('message');

		if(!erreur)
		{
			var action = Drupal.settings.fredev_contact.modPath + "/submit.php";

			$.ajax({
				type: "POST",
				url: action,
				data: {
					prenom: $("#prenom").val(),
					nom: $("#nom").val(),
					courriel: $("#courriel").val(),
					sujet: $("#sujet").val(),
					message: $("#message").val(),
					ajax: true
				},

				success: function(valeur_retour)
				{
					$("#bloc-message").html(valeur_retour);
					Page.nextPage();
				}

			});
		}
		else $("#contact-submit").removeAttr("disabled");

		return false;
	}

})(jQuery);
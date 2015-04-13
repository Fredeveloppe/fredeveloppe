// Force le déclanchement de la vérification du nombre de caractères
jQuery(function()
{
	jQuery(".textLimit").each(function()
	{
		jQuery(this).trigger("onload");
	});
});

// Limite le nombre maximal de caractères
function textareaMaxLength(field, evt, limit) 
{
	if(field.value.length > limit) jQuery(field).val(field.value.substr(0, limit));
  	jQuery(field).closest(".form-item").find("label").text("Contenu de votre commentaire. (" + (limit - field.value.length) + ")");
}
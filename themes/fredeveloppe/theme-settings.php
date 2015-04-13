<?php

function fredeveloppe_form_system_theme_settings_alter(&$form, $form_state)
{
	$form['foo_example'] = array(
	  '#type'          => 'textfield',
	  '#title'         => t('Texte du bandeau dans le pied de page'),
	  '#default_value' => theme_get_setting('bandeau'),
	  '#description'   => t("Texte qui sera utilisé dans le bandeau du pied de page, laissez vide pour enlever le bandeau"),
	);
}

?>
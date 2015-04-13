<?php

require_once(drupal_get_path('module', 'fredev_dependencies')."/inc/images.upload.inc");

// Callback appellé lors de la construction de la page des catégories de réalisation
function realisations_categories_admin()
{
	$mod_path = drupal_get_path('module', 'fredev_realisations');

	// Évalue le PHP/HTML et stock son résultat dans une variable
	ob_start();
	include($mod_path."/inc/categories.admin.list.template.php");
	$output = ob_get_clean();

	return $output;
}

// Callback appellé lors de la construction de la page logements
function realisations_categories_formulaire()
{
	$output = drupal_get_form("fredev_realisations_categories_form");

	return $output;
}

// Callback appellé lors de la construction de la page logements
function realisations_categories_suppression()
{
	$mod_path = drupal_get_path('module', 'fredev_realisations');

	// Évalue le PHP/HTML et stock son résultat dans une variable
	ob_start();
	include($mod_path."/inc/categories.admin.delform.template.php");
	$content = ob_get_clean();

	return $content.drupal_render($output);
}

// Construction du formulaire des catégories de réalisation
function fredev_realisations_categories_form($form, &$form_state)
{
	$id = intval(substr($_GET['q'], strrpos($_GET['q'], "/") + 1));

	if(is_int($id) && $id > 0)
	{
		$result = db_query('SELECT * FROM {realisations_categories} WHERE recaid = '.$id);
		if($result->rowCount()) $data = $result->fetchObject();
	}

	drupal_add_js(drupal_get_path('module', 'fredev_dependencies'). '/js/textLimit.js');

	$form['id'] = array(
		'#type' => 'hidden',
	    '#default_value' => (isset($data) && $data->recaid)?$data->recaid:'0',
	);

	$form['nom_recaid'] = array(
		'#type' => 'textfield',
	    '#title' => t('Nom de la catégorie de réalisation'),
	    '#default_value' => (isset($data) && $data->nom_recaid)?$data->nom_recaid:'',
	    '#description' => t("Le nom de la catégorie de réalisation qui sera utilisé par les moteurs de recherche")
	);

	$max_length = 300;
	$form['description_recaid'] = array(
		'#type' => 'textarea',
	    '#title' => t('Courte description de la catégorie (%limit)', array('%limit' => $max_length)),
	    '#default_value' => (isset($data) && $data->description_recaid)?$data->description_recaid:'',
	    '#description' => t("Une description pour votre catégorie de réalisation. Elle représente un résumé de ce que nous pourrons trouver à l'intérieur de cette catégorie et elle est limitée à %limit caractères", array('%limit' => $max_length)),
	    '#attributes' => array(
	    	'onkeyup' => "textareaMaxLength(this, event, $max_length);",
	    	'onload' => "textareaMaxLength(this, event, $max_length);",
	    	'class' => array("textLimit")
	    )
	);

	$form['fid_icone_recaid'] = array(
		'#title' => "Détermine l'icone qui représentera la catégorie",
	    '#type' => 'managed_file',
	    '#description' => "Téléverser l'icone qui représentera la catégorie",
	    '#upload_location'    => 'public://realisations/categories',
	    "#upload_validators"  => array("file_validate_extensions" => array("png gif jpg jpeg")),
	    '#default_value' => (isset($data) && $data->fid_icone_recaid)?$data->fid_icone_recaid:'',
	);

	$form['fid_miniature_recaid'] = array(
		'#title' => 'Détermine la miniature qui représentera la catégorie',
	    '#type' => 'managed_file',
	    '#description' => 'Téléverser la miniature qui représentera la catégorie',
	    '#upload_location'    => 'public://realisations/categories',
	    "#upload_validators"  => array("file_validate_extensions" => array("png gif jpg jpeg")),
	    '#default_value' => (isset($data) && $data->fid_miniature_recaid)?$data->fid_miniature_recaid:'',
	);

	$form['ordre_recaid'] = array(
		'#type' => 'textfield',
	    '#title' => t("Ordre dans laquelle la catégorie s'affichera"),
	    '#size' => 10,
	    '#default_value' => (isset($data) && $data->ordre_recaid)?$data->ordre_recaid:'',
	    '#description' => t("Permet de déterminer quelle catégorie sera prioritaire pour l'affichage. L'ordre 1 vient avant l'ordre 2.")
	);

	$form['color_recaid'] = array(
		'#type' => 'jquery_colorpicker',
	    '#title' => t('Couleur associé à la catégorie de réalisation'),
	    '#default_value' => (isset($data) && $data->color_recaid)?$data->color_recaid:'',
	    '#description' => t("La couleur de la catégorie de réalisation qui sera utilisé comme aide visuel pour représenter la catégorie")
	);

	$form['submit'] = array(
		'#type' => 'submit',
		'#value' => t('Save settings'),
	);

	return $form;
}

// Envoit du formulaire de création et validation
function fredev_realisations_categories_form_submit($form, &$form_state)
{
	// Récupération des données du formulaire
	$id = filter_var($form_state['values']['id'], FILTER_SANITIZE_NUMBER_INT);
	$nom_recaid = filter_var($form_state['values']['nom_recaid'], FILTER_SANITIZE_STRING);
	$description_recaid = substr(filter_var($form_state['values']['description_recaid'], FILTER_SANITIZE_STRING), 0, 300);
	$color_recaid = filter_var($form_state['values']['color_recaid'], FILTER_SANITIZE_STRING);
	$fid_icone_recaid = filter_var($form_state['values']['fid_icone_recaid'], FILTER_SANITIZE_NUMBER_INT);
	$fid_miniature_recaid = filter_var($form_state['values']['fid_miniature_recaid'], FILTER_SANITIZE_NUMBER_INT);
	$ordre_recaid = filter_var($form_state['values']['ordre_recaid'], FILTER_SANITIZE_NUMBER_INT);

	// Fallback value
	if(!$ordre_recaid) $ordre_recaid = 1;

	if(!$id)
	{
		fredev_dependencies_add_img($fid_icone_recaid, "fredev_realisations");
		fredev_dependencies_add_img($fid_miniature_recaid, "fredev_realisations");

		$prepare_sql = "INSERT INTO {realisations_categories} VALUES('".
			$id."', '".
			$nom_recaid."', '".
			$description_recaid."', '".
			$color_recaid."', '".
			$fid_icone_recaid."', '".
			$fid_miniature_recaid."', '".
			$ordre_recaid."')";
	}
	else
	{
		$result = db_query('SELECT * FROM {realisations_categories} WHERE recaid = '.$id);
		$row = $result->fetchObject();

		if($row->fid_icone_recaid != $fid_icone_recaid) fredev_dependencies_delete_img($row->fid_icone_recaid, $fid_icone_recaid, "fredev_realisations");
		if($row->fid_miniature_recaid != $fid_miniature_recaid) fredev_dependencies_delete_img($row->fid_miniature_recaid, $fid_miniature_recaid, "fredev_realisations");

		$prepare_sql = "UPDATE {realisations_categories} SET".
			" nom_recaid = '".$nom_recaid.
			"', description_recaid = '".$description_recaid.
			"', color_recaid = '".$color_recaid.
			"', fid_icone_recaid = '".$fid_icone_recaid.
			"', fid_miniature_recaid = '".$fid_miniature_recaid.
			"', ordre_recaid = ".$ordre_recaid.
			" WHERE recaid = ".$id;
	}

	db_query($prepare_sql);
	$form_state['redirect'] = '/admin/config/fredeveloppe/realisations/categories';

	drupal_set_message(t("Les modifications ont bel et bien étés enregistrées"));
}

// Formulaire de confirmation de suppression d'une catégorie
function fredev_realisations_categories_delform($form, &$form_state)
{

	$id = intval(substr($_GET['q'], strrpos($_GET['q'], "/") + 1));

	$form['id'] = array(
		'#type' => 'hidden',
	    '#default_value' => $id,
	);

	$form['submit'] = array(
		'#type' => 'submit',
		'#value' => t('Confirmer suppression'),
	);

	return $form;
}

// Envoie du formulaire de suppression et validation
function fredev_realisations_categories_delform_submit($form, &$form_state)
{
	$id = filter_var($form_state['values']['id'], FILTER_SANITIZE_NUMBER_INT);

	db_query("DELETE FROM {realisations_categories} WHERE recaid = ".$id);

	// Redirection vers la page de vue d'ensemble et préparation du message de confirmation
	$form_state['redirect'] = '/admin/config/fredeveloppe/realisations/categories';
	drupal_set_message(t("La catégorie de réalisation à bel et bien été supprimée"));
}

?>
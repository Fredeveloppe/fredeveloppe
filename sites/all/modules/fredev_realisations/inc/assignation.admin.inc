<?php

require_once(drupal_get_path('module', 'fredev_dependencies')."/inc/images.upload.inc");

// Callback appellé lors de la construction de la page d'assignation
function realisations_assignation_admin()
{
	$mod_path = drupal_get_path('module', 'fredev_realisations');

	// Évalue le PHP/HTML et stock son résultat dans une variable
	ob_start();
	include($mod_path."/inc/assignation.admin.list.template.php");
	$output = ob_get_clean();

	return $output;
}

// Callback appellé lors de la construction de la page logements
function realisations_assignation_formulaire()
{
	$output = drupal_get_form("fredev_realisations_assignation_form");

	return $output;
}

// Callback appellé lors de la construction de la page logements
function realisations_assignation_suppression()
{
	$mod_path = drupal_get_path('module', 'fredev_realisations');

	// Évalue le PHP/HTML et stock son résultat dans une variable
	ob_start();
	include($mod_path."/inc/assignation.admin.delform.template.php");
	$content = ob_get_clean();

	return $content.drupal_render($output);
}

// Construction du formulaire de settings des conseils du profesionnel
function fredev_realisations_assignation_form($form, &$form_state)
{
	// Vérification de base si l'affichage de la page est permise
	$predicat = db_query("SELECT recaid, nom_recaid FROM {realisations_categories} ORDER BY nom_recaid ASC");
	if(!$predicat->rowCount())
	{
		die('<meta http-equiv="refresh" content="0; url=/admin/config/fredeveloppe/realisations/assignation">');
	}

	$id = intval(substr($_GET['q'], strrpos($_GET['q'], "/") + 1));

	if(is_int($id) && $id > 0)
	{
		$result = db_query('SELECT * FROM {realisations_definitions} WHERE redefid = '.$id);
		if($result->rowCount()) $data = $result->fetchObject();
	}

	$form['id'] = array(
		'#type' => 'hidden',
	    '#default_value' => (isset($data) && $data->redefid)?$data->redefid:'0',
	);

	$form['nom_redefid'] = array(
		'#type' => 'textfield',
	    '#title' => t('Titre de la réalisation'),
	    '#default_value' => (isset($data) && $data->nom_redefid)?$data->nom_redefid:'',
	    '#description' => t("Titre de la réalisation qui sera utilisée sur le site")
	);

	$form['fid_miniature_redefid'] = array(
		'#title' => 'Détermine la miniature qui représentera la réalisation',
	    '#type' => 'managed_file',
	    '#description' => 'Téléverser la miniature qui représentera la réalisation',
	    '#upload_location'    => 'public://realisations/vignettes',
	    "#upload_validators"  => array("file_validate_extensions" => array("png gif jpg jpeg")),
	    '#default_value' => (isset($data) && $data->fid_miniature_redefid)?$data->fid_miniature_redefid:'',
	);

	$form['date_debut_redefid'] = array(
	    '#type' => 'date_popup',
	    '#title' => t('Date à laquelle votre réalisation à réellement démarrée'),
	    '#default_value' => (isset($data) && $data->date_debut_redefid)?$data->date_debut_redefid:date('Y-m-d H:i'),
	    '#date_format' => "Y-m-d H:i",
	    '#description' => t("Cette date de démarrage est utilisée pour déterminer l'ordre d'affichage dans le site"),
	);

	$form['date_fin_redefid'] = array(
	    '#type' => 'date_popup',
	    '#title' => t("Date à laquelle votre réalisation c'est réellement terminée"),
	    '#default_value' => (isset($data) && $data->date_fin_redefid)?$data->date_fin_redefid:'',
	    '#date_format' => "Y-m-d H:i",
	    '#description' => t("Cette date représente la date réelle de clôture de votre réalisation."),
	);

	$catList = array(
		0 => "----- SELECTION -----"
	);

	foreach($predicat as $item)
	{
		$catList[$item->recaid] = $item->nom_recaid;
	}

	$form['recaid'] = array(
	    '#type' => 'select',
	    '#title' => t("Catégorie de réalisation pour lequel se projet est associé"),
	    '#default_value' => (isset($data) && $data->recaid)?$data->recaid:'',
	    '#description' => t("Si un projet semble correspondre à plusieurs catégories, veuillez choisir la catégorie qui le représente le mieux."),
	    '#options' => $catList
	);


	$form['activite_redefid'] = array(
	    '#type' => 'radios',
	    '#title' => t("Détermine si cette réalisation doit s'afficher dans le site"),
	    '#default_value' => (isset($data) && $data->activite_redefid)?$data->activite_redefid:1,
	    '#description' => t("Cette valeur décidera si votre réalisation est une archive ou si elle peut s'afficher dans le site et lors des recherches."),
	    '#options' => array(
	    	0 => t("Non (Archivé)"),
	    	1 => t("Oui (Affiché)")
	    )
	);

	$form['submit'] = array(
		'#type' => 'submit',
		'#value' => t('Save settings'),
	);

	return $form;
}

// Envoit du formulaire de création et validation
function fredev_realisations_assignation_form_submit($form, &$form_state)
{
	// Récupération des données du formulaire
	$id = filter_var($form_state['values']['id'], FILTER_SANITIZE_NUMBER_INT);
	$nom_redefid = filter_var($form_state['values']['nom_redefid'], FILTER_SANITIZE_STRING);
	$fid_miniature_redefid = filter_var($form_state['values']['fid_miniature_redefid'], FILTER_SANITIZE_NUMBER_INT);
	$date_debut_redefid = filter_var($form_state['values']['date_debut_redefid'], FILTER_SANITIZE_STRING);
	$date_fin_redefid = filter_var($form_state['values']['date_fin_redefid'], FILTER_SANITIZE_STRING);
	$recaid = filter_var($form_state['values']['recaid'], FILTER_SANITIZE_NUMBER_INT);
	$activite_redefid = filter_var($form_state['values']['activite_redefid'], FILTER_SANITIZE_NUMBER_INT);
	if(!$recaid) $recaid = "NULL";

	if(!$id)
	{
		fredev_dependencies_add_img($fid_miniature_redefid, "fredev_realisations");

		$prepare_sql = "INSERT INTO {realisations_definitions} VALUES('".
			$id."', '".
			$nom_redefid."', ".
			$fid_miniature_redefid.", '".
			$date_debut_redefid."', '".
			$date_fin_redefid."', ".
			$recaid.", ".
			$activite_redefid.")";
	}
	else
	{
		$result = db_query('SELECT * FROM {realisations_definitions} WHERE redefid = '.$id);
		$row = $result->fetchObject();

		if($row->fid_miniature_redefid != $fid_miniature_redefid) fredev_dependencies_delete_img($row->fid_miniature_redefid, $fid_miniature_redefid, "fredev_realisations");

		$prepare_sql = "UPDATE {realisations_definitions} SET".
			" nom_redefid = '".$nom_redefid.
			"', fid_miniature_redefid = ".$fid_miniature_redefid.
			", date_debut_redefid = '".$date_debut_redefid.
			"', date_fin_redefid = '".$date_fin_redefid.
			"', recaid = ".$recaid.
			", activite_redefid = ".$activite_redefid.
			" WHERE redefid = ".$id;
	}

	db_query($prepare_sql);
	$form_state['redirect'] = '/admin/config/fredeveloppe/realisations/assignation';

	//drupal_set_message($prepare_sql);
	drupal_set_message(t("Les modifications ont bel et bien étés enregistrées"));
}

// Formulaire de confirmation de suppression d'un logement
function fredev_realisations_assignation_delform($form, &$form_state)
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
function fredev_realisations_assignation_delform_submit($form, &$form_state)
{
	$id = filter_var($form_state['values']['id'], FILTER_SANITIZE_NUMBER_INT);

	db_query("DELETE FROM {realisations_definitions} WHERE redefid = ".$id);

	// Redirection vers la page de vue d'ensemble et préparation du message de confirmation
	$form_state['redirect'] = '/admin/config/fredeveloppe/realisations/assignation';
	drupal_set_message(t("La réalisation à bel et bien été supprimée"));
}

?>
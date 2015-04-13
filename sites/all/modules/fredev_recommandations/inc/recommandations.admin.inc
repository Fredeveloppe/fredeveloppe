<?php

require_once(drupal_get_path('module', 'fredev_dependencies')."/inc/images.upload.inc");

// Callback appellé lors de la construction de la page logements
function recommandations_admin()
{
	$mod_path = drupal_get_path('module', 'fredev_recommandations');

	// Évalue le PHP/HTML et stock son résultat dans une variable
	ob_start();
	include($mod_path."/inc/admin.list.template.php");
	$output = ob_get_clean();

	return $output;
}

// Callback appellé lors de la construction de la page logements
function recommandations_formulaire()
{
	$output = drupal_get_form("fredev_recommandations_form");

	return $output;
}

// Callback appellé lors de la construction de la page logements
function recommandations_suppression()
{
	$mod_path = drupal_get_path('module', 'fredev_recommandations');

	// Évalue le PHP/HTML et stock son résultat dans une variable
	ob_start();
	include($mod_path."/inc/admin.delform.template.php");
	$content = ob_get_clean();

	return $content.drupal_render($output);
}

// Construction du formulaire de settings des conseils du profesionnel
function fredev_recommandations_form($form, &$form_state)
{
	$id = intval(substr($_GET['q'], strrpos($_GET['q'], "/") + 1));

	if(is_int($id) && $id > 0)
	{
		$result = db_query('SELECT * FROM {recommandations} WHERE id = '.$id);
		if($result->rowCount()) $data = $result->fetchObject();
	}

	$form['id'] = array(
		'#type' => 'hidden',
	    '#default_value' => (isset($data) && $data->id)?$data->id:'0',
	);

	$form['titre'] = array(
		'#type' => 'textfield',
	    '#title' => t('Titre de la recommandation'),
	    '#default_value' => (isset($data) && $data->titre)?$data->titre:'',
	    '#description' => t("Titre de la recommandation de la personne qui à travaillé en votre compagnie")
	);

	$form['texte'] = array(
		'#type' => 'textarea',
	    '#title' => t("Contenu de la recommandation"),
	    '#default_value' => (isset($data) && $data->texte)?$data->texte:'',
	    '#description' => t("Le contenu de la recommandation de la personne qui à travaillé en votre compagnie.")
	);

	$form['personne_ressource'] = array(
		'#type' => 'textfield',
	    '#title' => t('Nom de la personne ressource'),
	    '#default_value' => (isset($data) && $data->personne_ressource)?$data->personne_ressource:'',
	    '#description' => t("Nom de la personne ressource qui à travaillé en votre compagnie")
	);

	$form['poste'] = array(
		'#type' => 'textfield',
	    '#title' => t('Poste qu\'occupe la personne ressource'),
	    '#default_value' => (isset($data) && $data->poste)?$data->poste:'',
	    '#description' => t("Poste qu'occupe la personne ressource qui à travaillé en votre compagnie")
	);

	$form['fid'] = array(
		'#title' => 'Logo de la compagnie',
	    '#type' => 'managed_file',
	    '#description' => 'Téléverser le logo de votre compagnie',
	    '#upload_location'    => 'public://recommandation',
	    "#upload_validators"  => array("file_validate_extensions" => array("png gif jpg jpeg")),
	    '#default_value' => (isset($data) && $data->fid)?$data->fid:'',
	);

	$form['date_publication'] = array(
	    '#type' => 'date_popup',
	    '#title' => t('Date à laquelle cette recommandation à été écrite'),
	    '#default_value' => (isset($data) && $data->date_publication)?$data->date_publication:date('Y-m-d H:i'),
	    '#date_format' => "Y-m-d H:i",
	    '#description' => t("Cette date de recommandation est utilisée pour déterminer l'ordre d'affichage dans le site"),
	);

	$form['submit'] = array(
		'#type' => 'submit',
		'#value' => t('Save settings'),
	);

	return $form;
}

// Envoit du formulaire de création et validation
function fredev_recommandations_form_submit($form, &$form_state)
{
	// Récupération des données du formulaire
	$id = filter_var($form_state['values']['id'], FILTER_SANITIZE_NUMBER_INT);
	$titre = filter_var($form_state['values']['titre'], FILTER_SANITIZE_STRING);
	$texte = filter_var($form_state['values']['texte'], FILTER_SANITIZE_STRING);
	$date_publication = filter_var($form_state['values']['date_publication'], FILTER_SANITIZE_STRING);
	$personne_ressource = filter_var($form_state['values']['personne_ressource'], FILTER_SANITIZE_STRING);
	$poste = filter_var($form_state['values']['poste'], FILTER_SANITIZE_STRING);
	$fid = filter_var($form_state['values']['fid'], FILTER_SANITIZE_NUMBER_INT);

	if(!$id)
	{
		fredev_dependencies_add_img($fid, "fredev_recommandations");

		$prepare_sql = "INSERT INTO {recommandations} VALUES('".
			$id."', '".
			$titre."', '".
			$texte."', '".
			$date_publication."', '".
			$personne_ressource."', '".
			$poste."', ".
			$fid.")";
	}
	else
	{
		$result = db_query('SELECT * FROM {recommandations} WHERE id = '.$id);
		$row = $result->fetchObject();

		if($row->fid != $fid) fredev_dependencies_delete_img($row->fid, $fid, "fredev_recommandations");

		$prepare_sql = "UPDATE {recommandations} SET".
			" titre = '".$titre.
			"', texte = '".$texte.
			"', date_publication = '".$date_publication.
			"', personne_ressource = '".$personne_ressource.
			"', poste = '".$poste.
			"', fid = ".$fid.
			" WHERE id = ".$id;
	}

	db_query($prepare_sql);
	$form_state['redirect'] = '/admin/config/fredeveloppe/recommandations';

	//drupal_set_message($prepare_sql);
	drupal_set_message(t("Les modifications ont bel et bien étés enregistrées"));
}

// Formulaire de confirmation de suppression d'un logement
function fredev_recommandations_delform($form, &$form_state)
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
function fredev_recommandations_delform_submit($form, &$form_state)
{
	$id = filter_var($form_state['values']['id'], FILTER_SANITIZE_NUMBER_INT);

	db_query("DELETE FROM {recommandations} WHERE id = ".$id);

	// Redirection vers la page de vue d'ensemble et préparation du message de confirmation
	$form_state['redirect'] = '/admin/config/fredeveloppe/recommandations';
	drupal_set_message(t("La recommandation à belle et bien été supprimée"));
}

?>
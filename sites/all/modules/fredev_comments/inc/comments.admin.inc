<?php

// Callback appellé lors de la construction de la page logements
function comments_admin()
{
	$mod_path = drupal_get_path('module', 'fredev_comments');

	// Évalue le PHP/HTML et stock son résultat dans une variable
	ob_start();
	include($mod_path."/inc/admin.list.template.php");
	$output = ob_get_clean();

	return $output;
}

// Callback appellé lors de la construction de la page logements
function comments_formulaire()
{
	$output = drupal_get_form("fredev_comments_form");

	return $output;
}

// Callback appellé lors de la construction de la page logements
function comments_suppression()
{
	$mod_path = drupal_get_path('module', 'fredev_comments');

	// Évalue le PHP/HTML et stock son résultat dans une variable
	ob_start();
	include($mod_path."/inc/admin.delform.template.php");
	$content = ob_get_clean();

	return $content.drupal_render($output);
}

// Construction du formulaire de settings des conseils du profesionnel
function fredev_comments_form($form, &$form_state)
{

	$id = intval(substr($_GET['q'], strrpos($_GET['q'], "/") + 1));

	if(is_int($id) && $id > 0)
	{
		$result = db_query('SELECT * FROM {commentaires} WHERE id = '.$id);
		if($result->rowCount()) $data = $result->fetchObject();
	}

	drupal_add_js(drupal_get_path('module', 'fredev_dependencies'). '/js/textLimit.js');

	$form['id'] = array(
		'#type' => 'hidden',
	    '#default_value' => (isset($data) && $data->id)?$data->id:'0',
	);

	$max_length = 180;
	$form['commentaire'] = array(
		'#type' => 'textarea',
	    '#title' => t('Contenu de votre commentaire. (%limit)', array('%limit' => $max_length)),
	    '#default_value' => (isset($data) && $data->commentaire)?$data->commentaire:'',
	    '#description' => t("Le contenu de votre commentaire. Il est limité à %limit caractères", array('%limit' => $max_length)),
	    '#attributes' => array(
	    	'onkeyup' => "textareaMaxLength(this, event, $max_length);",
	    	'onload' => "textareaMaxLength(this, event, $max_length);",
	    	'class' => array("textLimit")
	    )
	);

	$form['date_publication'] = array(
	    '#type' => 'date_popup',
	    '#title' => t('Date à laquelle votre projet démarrera'),
	    '#default_value' => (isset($data) && $data->date_publication)?$data->date_publication:date('Y-m-d H:i'),
	    '#date_format' => "Y-m-d H:i",
	    '#description' => t("Cette date de publication est utilisée pour déterminer l'ordre d'affichage dans le site"),
	);

	$form['submit'] = array(
		'#type' => 'submit',
		'#value' => t('Save settings'),
	);

	return $form;
}

// Envoit du formulaire de création et validation
function fredev_comments_form_submit($form, &$form_state)
{
	global $user;

	// Récupération des données du formulaire
	$id = filter_var($form_state['values']['id'], FILTER_SANITIZE_NUMBER_INT);
	$commentaire = substr(filter_var($form_state['values']['commentaire'], FILTER_SANITIZE_STRING), 0, 165);
	$date_publication = filter_var($form_state['values']['date_publication'], FILTER_SANITIZE_STRING);
	$uid = $user->uid;

	if(!$id)
	{
		$prepare_sql = "INSERT INTO {commentaires} VALUES('".
			$id."', '".
			$commentaire."', '".
			$date_publication."', ".
			$uid.")";
	}
	else
	{
		$prepare_sql = "UPDATE {commentaires} SET".
			" commentaire = '".$commentaire.
			"', date_publication = '".$date_publication.
			"' WHERE id = ".$id;
	}

	db_query($prepare_sql);
	$form_state['redirect'] = '/admin/config/fredeveloppe/comments';

	//drupal_set_message($prepare_sql);
	drupal_set_message(t("Les modifications ont bel et bien étés enregistrées"));
}

// Formulaire de confirmation de suppression d'un logement
function fredev_comments_delform($form, &$form_state)
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
function fredev_comments_delform_submit($form, &$form_state)
{
	$id = filter_var($form_state['values']['id'], FILTER_SANITIZE_NUMBER_INT);

	db_query("DELETE FROM {commentaires} WHERE id = ".$id);

	// Redirection vers la page de vue d'ensemble et préparation du message de confirmation
	$form_state['redirect'] = '/admin/config/fredeveloppe/comments';
	drupal_set_message(t("Le commentaire à bel et bien été supprimé"));
}

?>
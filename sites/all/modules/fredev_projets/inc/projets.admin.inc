<?php

// Callback appellé lors de la construction de la page logements
function projets_admin()
{
	$mod_path = drupal_get_path('module', 'fredev_projets');

	// Évalue le PHP/HTML et stock son résultat dans une variable
	ob_start();
	include($mod_path."/inc/admin.list.template.php");
	$output = ob_get_clean();

	return $output;
}

// Callback appellé lors de la construction de la page logements
function projets_formulaire()
{
	$output = drupal_get_form("fredev_projets_form");

	return $output;
}

// Callback appellé lors de la construction de la page logements
function projets_suppression()
{
	$mod_path = drupal_get_path('module', 'fredev_projets');

	// Évalue le PHP/HTML et stock son résultat dans une variable
	ob_start();
	include($mod_path."/inc/admin.delform.template.php");
	$content = ob_get_clean();

	return $content.drupal_render($output);
}

// Essais d'établir une connexion à l'API de facebook
function try_facebook_connexion()
{
	/**************************    Permanent token! *******************************
	https://graph.facebook.com/oauth/access_token?%20client_id=APP_ID&%20client_secret=APP_SECRET&%20grant_type=fb_exchange_token&%20fb_exchange_token=TOKEN_TO_TRANSFORM
	*/
	require_once(drupal_get_path('module', 'fredev_projets').'/facebook/facebook.php');

	// Information pour la connexion de l'application
	$config = array();
	$config['appId'] = '597211260324589';
	$config['secret'] = '0710c8bea3e02ae90ece66f471b135eb';
	$config['cookie'] = true;

	$facebook = new Facebook($config);

	// Représente la page Fredeveloppe sur Facebook
	$facebook->setAccessToken("CAAIfKRUHCu0BAKILuQVOYrZBaXKTi0FeWvNriARYkgiu5Kn7NDOEIOcsDX8w2VS8h0CavE6USHZAuP2HQa6XExPWzf8t3PjXTw9TILBrJmpI8zmfFZAitNZBMpkRgZCUfmZBUG2wrbCYWqwiIHwMWO2NsOIy6CsTm9fxdZCluYtPnRlJxWkrNdXY81o8ZBr57SoZD");

	return $facebook;
}

// Envoie un message sur Facebook
function send_facebook_wallpost($facebook, $wallpost, $wall_target)
{
	// Publication du message
	$params = array();
	$params['message'] = $wallpost;
	$test = $facebook->api($wall_target, "POST", $params);
}

// Construction du formulaire de settings des conseils du profesionnel
function fredev_projets_form($form, &$form_state)
{

	$facebook = try_facebook_connexion();

	// Redirige l'utilisateur vers la page d'obtention des droits
	if(!$facebook->getUser())
	{
	   $login_url_params = array(
	      'scope' => 'publish_stream,read_stream,offline_access,manage_pages',
	      'fbconnect' =>  1,
	      'redirect_uri' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
	   );
	   $login_url = $facebook->getLoginUrl($login_url_params);
	    
	   // Redirection forcé vers la connexion de facebook
	   die("<meta http-equiv='refresh' content='0; url=".$login_url."'> ");
	   exit();
	}


	$id = intval(substr($_GET['q'], strrpos($_GET['q'], "/") + 1));

	if(is_int($id) && $id > 0)
	{
		$result = db_query('SELECT * FROM {projets} WHERE id = '.$id);
		if($result->rowCount()) $data = $result->fetchObject();
	}

	drupal_add_js(drupal_get_path('module', 'fredev_dependencies'). '/js/textLimit.js');

	$form['id'] = array(
		'#type' => 'hidden',
	    '#default_value' => (isset($data) && $data->id)?$data->id:'0',
	);

	$form['titre'] = array(
		'#type' => 'textfield',
	    '#title' => t('Titre du projet actuel'),
	    '#default_value' => (isset($data) && $data->titre)?$data->titre:'',
	    '#description' => t("Titre du projet qui sera utilisé sur le site et sur facebook")
	);

	$max_length = 300;
	$form['texte'] = array(
		'#type' => 'textarea',
	    '#title' => t('Courte description de votre projet (%limit)', array('%limit' => $max_length)),
	    '#default_value' => (isset($data) && $data->texte)?$data->texte:'',
	    '#description' => t("Une description pour votre projet. Il représente un résumé du devis technique du projet et il est limité à %limit caractères", array('%limit' => $max_length)),
	    '#attributes' => array(
	    	'onkeyup' => "textareaMaxLength(this, event, $max_length);",
	    	'onload' => "textareaMaxLength(this, event, $max_length);",
	    	'class' => array("textLimit")
	    )
	);

	$form['date_debut'] = array(
	    '#type' => 'date_popup',
	    '#title' => t('Date à laquelle votre projet démarrera'),
	    '#default_value' => (isset($data) && $data->date_debut)?$data->date_debut:date('Y-m-d H:i'),
	    '#date_format' => "Y-m-d H:i",
	    '#description' => t("Cette date de démarrage est utilisée pour déterminer l'ordre d'affichage dans le site"),
	);

	$form['date_fin'] = array(
	    '#type' => 'date_popup',
	    '#title' => t("Date à laquelle votre projet c'est terminé"),
	    '#default_value' => (isset($data) && $data->date_fin)?$data->date_fin:'',
	    '#date_format' => "Y-m-d H:i",
	    '#description' => t("Cette date représente la date réelle de clôture de votre projet. Elle désaffiche le contenu du site"),
	);

	$form['submit'] = array(
		'#type' => 'submit',
		'#value' => t('Save settings'),
	);

	return $form;
}

// Envoit du formulaire de création et validation
function fredev_projets_form_submit($form, &$form_state)
{
	// Récupération des données du formulaire
	$id = filter_var($form_state['values']['id'], FILTER_SANITIZE_NUMBER_INT);
	$titre = filter_var($form_state['values']['titre'], FILTER_SANITIZE_STRING);
	$texte = substr(filter_var($form_state['values']['texte'], FILTER_SANITIZE_STRING), 0, 300);
	$date_debut = filter_var($form_state['values']['date_debut'], FILTER_SANITIZE_STRING);
	$date_fin = filter_var($form_state['values']['date_fin'], FILTER_SANITIZE_STRING);
	$date_fin_value = (!empty($date_fin))?"'".$date_fin."'":"NULL";

	if(!$id)
	{
		// Si l'identification à obtenu un utilisateur, je peux faire des call à l'API
		$facebook = try_facebook_connexion();
		
		if($facebook->getUser()) send_facebook_wallpost($facebook, "[Projet] ".$titre."\n\n".$texte, "/fredevelopement/feed");

		$prepare_sql = "INSERT INTO {projets} VALUES('".
			$id."', '".
			$titre."', '".
			$texte."', '".
			$date_debut."', ".
			$date_fin_value.")";
	}
	else
	{
		$prepare_sql = "UPDATE {projets} SET".
			" titre = '".$titre.
			"', texte = '".$texte.
			"', date_debut = '".$date_debut.
			"', date_fin = ".$date_fin_value.
			" WHERE id = ".$id;
	}

	db_query($prepare_sql);
	$form_state['redirect'] = '/admin/config/fredeveloppe/projets';

	//drupal_set_message($prepare_sql);
	drupal_set_message(t("Les modifications ont bel et bien étés enregistrées"));
}

// Formulaire de confirmation de suppression d'un logement
function fredev_projets_delform($form, &$form_state)
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
function fredev_projets_delform_submit($form, &$form_state)
{
	$id = filter_var($form_state['values']['id'], FILTER_SANITIZE_NUMBER_INT);

	db_query("DELETE FROM {projets} WHERE id = ".$id);

	// Redirection vers la page de vue d'ensemble et préparation du message de confirmation
	$form_state['redirect'] = '/admin/config/fredeveloppe/projets';
	drupal_set_message(t("Le projet à bel et bien été supprimé"));
}

?>
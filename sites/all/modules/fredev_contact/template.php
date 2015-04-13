<?php
	// Assigne des variables pour une meilleure utilisation par la suite
	$nom = variable_get("contact_nom");
	$adresse = variable_get("contact_adresse");
	$cp = variable_get("contact_code_postal");
	$courriel = variable_get("contact_courriel");
	$maison = variable_get("contact_maison");
	$travail = variable_get("contact_travail");
	$cell = variable_get("contact_cell");
	$fb = variable_get('contact_facebook');
	$twitter = variable_get('contact_twitter');
	$google = variable_get('contact_google');
	$skype = variable_get('contact_skype');

	$message_send = false;

	// Prépare le contenu des champs
	$prenom = (isset($_POST['prenom']))?$_POST['prenom']:"";
	$nom = (isset($_POST['nom']))?$_POST['nom']:"";
	$courriel_form = (isset($_POST['courriel']))?$_POST['courriel']:"";
	$sujet = (isset($_POST['sujet']))?$_POST['sujet']:"";
	$message = (isset($_POST['message']))?$_POST['message']:"";

	// Validation PHP (sans javascript)
	$erreur = array();
	$erreur['prenom'] = "";
	$erreur['nom'] = "";
	$erreur['courriel'] = "";
	$erreur['sujet'] = "";
	$erreur['message'] = "";

	$classError = array();
	$classError['prenom'] = "";
	$classError['nom'] = "";
	$classError['courriel'] = "";
	$classError['sujet'] = "";
	$classError['message'] = "";

	if(isset($_POST['prenom']))
	{
		$erreur['prenom'] = (!empty($prenom))?validation_noms($prenom, 'prénom'):"Veuillez entrer votre prénom";
		$erreur['nom'] = (!empty($nom))?validation_noms($nom, 'nom'):"Veuillez entrer votre nom";
		$erreur['courriel'] = (!empty($courriel))?validation_adresse($courriel_form, 'courriel'):"Veuillez entrer votre adresse courriel";
		$erreur['sujet'] = (!empty($sujet))?validation_standard($sujet, 'sujet'):"Veuillez entrer votre sujet";
		$erreur['message'] = (!empty($message))?validation_standard($message, 'message'):"Veuillez entrer votre message";

		$erreur_count = 0;
		foreach($erreur as $err)
		{
			if($err != "") $erreur_count++;
		}

		if(!$erreur_count) require_once("submit.php");

		$classError['prenom'] = ($erreur['prenom'] != "")?"invalide":"valide";
		$classError['nom'] = ($erreur['nom'] != "")?"invalide":"valide";
		$classError['courriel'] = ($erreur['courriel'] != "")?"invalide":"valide";
		$classError['sujet'] = ($erreur['sujet'] != "")?"invalide":"valide";
		$classError['message'] = ($erreur['message'] != "")?"invalide":"valide";
	}

	// Validation du prénom et du nom
	function validation_noms($valeur_champ, $name)
	{	
		$caracteres_valides = "ABCDEFGHIJKLMNOPQRSTUVWXYZÇçéèêëÉÈÊËöòôÖÒÔïîìÏÎÌ0123456789-' ";
		
		for($i = 0; $i < strlen(stripslashes($valeur_champ)); $i++)
		{
			if($i == 0)
			{
				// Validation du premier caractères
				if(strpos(substr($caracteres_valides,0,strpos($caracteres_valides,"0")),substr(strtoupper($valeur_champ),$i,1)) === false)
				{
					$message_erreur = "Votre ".$name." doit commencer par une lettre";
				}
			}
			else if(strpos($caracteres_valides,substr(strtoupper(stripslashes($valeur_champ)),$i,1)) === false)
			{
				$message_erreur = "Caractères invalides dans votre ".$name;
			}
		}

		if(!isset($message_erreur)) return "";
		else return $message_erreur;
	}

	// Validation de l'adresse courriel
	function validation_adresse($valeur_champ, $name)
	{
		$filtre_champ = preg_match("/^[a-z](([a-z0-9]|\-|\.|\_)?[a-z0-9])+@[a-z]+(\-[a-z]+)?(\.[a-z]{2,6}){1,2}$/i",$valeur_champ);
		if($filtre_champ == 0) return "Cette adresse courriel n'existe pas";
		else return "";	
	}

	// Validation du sujet et du message
	function validation_standard($valeur_champ, $name)
	{
		$filtre_champ = filter_var($valeur_champ, FILTER_SANITIZE_STRING);
					
		if(html_entity_decode($filtre_champ,ENT_QUOTES) == $valeur_champ)
		{
			// Validation que l'usager a entré autre chose que des espaces et des Enter
			$espace_only = preg_match("/^\s+$/",$valeur_champ);
			if($espace_only == 1)
			{
				$message_erreur = "Veuillez entrer un vrai ".$id_champ;
			}
		}
		else $message_erreur = "Caractères invalides dans votre ".$id_champ;

		if(!isset($message_erreur)) return "";
		else return $message_erreur;
	}

?>

<div class="middle-content">

	<div id="contact">

		<div class="page-top"><!-- CSS bg-style --></div>

		<div id="contact-wrapper">

			<div id="bb-bookblock" class="bb-bookblock">

			<?php if(!$message_send): ?>
				<div class="bb-item"><?php require_once("page.cover.php") ?></div>
			<?php endif; ?>
				<div class="bb-item"><?php require_once("page.under.php") ?></div>

			</div> <!-- EOF: #bb-bookblock -->

		</div> <!-- EOF: #contact-wrapper -->

		<div class="page-bottom"><!-- CSS bg-style --></div>

	</div> <!-- EOF: #contact -->

</div> <!-- EOF: .middle-content -->
<?php
	require_once('courriel.php');

	// Pour être sur de pas envoyer de courriel malicieux
	$prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
	$nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
	$courriel = filter_var($_POST['courriel'], FILTER_SANITIZE_STRING);
	$sujet = filter_var($_POST['sujet'], FILTER_SANITIZE_STRING);
	$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

	// Soumission du courriel
	$courriel = new Courriel($prenom, $nom, $courriel, $sujet, $message);
	$envoie_courriel = $courriel->envoyer();
	$mail_content = ($envoie_courriel)?$courriel->show_mail():$courriel->mail_fallback();
	
	if(isset($_POST['ajax'])) echo $mail_content;
	else $message_send = true;

?>
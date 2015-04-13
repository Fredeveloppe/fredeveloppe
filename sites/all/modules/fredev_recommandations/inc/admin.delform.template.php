<?php

	$id = intval(substr($_GET['q'], strrpos($_GET['q'], "/") + 1));

	// Va chercher les données
	$result = db_query('SELECT * FROM {recommandations} WHERE id = '.$id);

	// Fallback aucun contenu trouvé
	if($result->rowCount() < 1):
		$output = null;
?>

	<h2>Contenu introuvable</h2>
	<a href="/admin/config/fredeveloppe/recommandations">Revenir à la liste de projets</a>

<?php 
	// Affichage des information de l'objet en attente de suppression
	else:
	$row = $result->fetchObject();

	// Va chercher le formulaire de suppression
	$output = drupal_get_form('fredev_recommandations_delform');
?>

	<h2>Êtes-vous certain de vouloir supprimer la recommandation suivante?</h2>
	<p><?=$row->titre?></p>
	<p><?=$row->texte?></p>
	<p>Publié le : <em><?=$row->date_publication?></em></p>
<?php endif; ?>
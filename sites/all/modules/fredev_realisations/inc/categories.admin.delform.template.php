<?php

	$id = intval(substr($_GET['q'], strrpos($_GET['q'], "/") + 1));

	// Va chercher les données
	$result = db_query('SELECT * FROM {realisations_categories} WHERE recaid = '.$id);

	// Fallback aucun contenu trouvé
	if($result->rowCount() < 1):
		$output = null;
?>

	<h2>Contenu introuvable</h2>
	<a href="/admin/config/fredeveloppe/realisations/categories">Revenir à la liste des catégories de réalisation</a>

<?php 
	// Affichage des informations de l'objet en attente de suppression
	else:
	$row = $result->fetchObject();

	// Va chercher le formulaire de suppression
	$output = drupal_get_form('fredev_realisations_categories_delform');
?>

	<h2>Êtes-vous certain de vouloir supprimer la catégorie de réalisation suivante?</h2>
	<p><?=$row->nom_recaid?></p>
	<p><?=nl2br($row->description_recaid)?></p>
<?php endif; ?>
<?php

	$id = intval(substr($_GET['q'], strrpos($_GET['q'], "/") + 1));

	// Va chercher les données
	$result = db_query('SELECT {commentaires}.*, {field_data_field_prenom}.field_prenom_value as prenom, {field_data_field_nom}.field_nom_value as nom 
		FROM {commentaires} LEFT JOIN {users} ON {commentaires}.uid = {users}.uid
		LEFT JOIN {profile} ON {profile}.uid = {users}.uid
		LEFT JOIN {field_data_field_prenom} ON {field_data_field_prenom}.entity_id = {profile}.pid
		LEFT JOIN {field_data_field_nom} ON {field_data_field_nom}.entity_id = {profile}.pid
		WHERE {commentaires}.id = '.$id);

	// Fallback aucun contenu trouvé
	if($result->rowCount() < 1):
		$output = null;
?>

	<h2>Contenu introuvable</h2>
	<a href="/admin/config/fredeveloppe/comments">Revenir à la liste des commentaires</a>

<?php 
	// Affichage des information de l'objet en attente de suppression
	else:
	$row = $result->fetchObject();

	// Va chercher le formulaire de suppression
	$output = drupal_get_form('fredev_comments_delform');
?>

	<h2>Êtes-vous certain de vouloir supprimer le commentaire suivant?</h2>
	<p><?=$row->commentaire?></p>
	<p>Publié le : <em><?=$row->date_publication?></em></p>
	<p>Par <em><?=$row->prenom." ".$row->nom?></em></p>
<?php endif; ?>
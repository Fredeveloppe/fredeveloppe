<?php
	$results = db_query("SELECT {commentaires}.*, {field_data_field_prenom}.field_prenom_value as prenom, {field_data_field_nom}.field_nom_value as nom 
		FROM {commentaires} LEFT JOIN {users} ON {users}.uid = {commentaires}.uid 
		LEFT JOIN {profile} ON {profile}.uid = {users}.uid
		LEFT JOIN {field_data_field_prenom} ON {field_data_field_prenom}.entity_id = {profile}.pid
		LEFT JOIN {field_data_field_nom} ON {field_data_field_nom}.entity_id = {profile}.pid
		ORDER BY {commentaires}.date_publication DESC");
?>

<p><a href="<?=base_path()?>admin/config/fredeveloppe/comments/formulaire">Ajouter un nouveau commentaire</a></p>

<table>
	<tr>
		<th>Commentaire n&deg;</th>
		<th>Commentaire</th>
		<th>Écrit par</th>
		<th>Date publication</th>
		<th>Actions</th>
	</tr>
	<?php 
		if($results->rowCount()):
		foreach($results as $commentaire): 
	?>
	<tr>
		<td><a href="<?=base_path()?>admin/config/fredeveloppe/comments/formulaire/<?=$commentaire->id?>">n&deg;<?=$commentaire->id?></a></td>
		<td style="width: 50%;"><?=$commentaire->commentaire?></td>
		<td><?=$commentaire->prenom." ".$commentaire->nom?></td>
		<td><?=$commentaire->date_publication?></td>
		<td><a href="<?=base_path()?>admin/config/fredeveloppe/comments/formulaire/<?=$commentaire->id?>">Modifier</a> | <a href="<?=base_path()?>admin/config/fredeveloppe/comments/suppression/<?=$commentaire->id?>">Supprimer</a></td>
	</tr>
	<?php 
		endforeach; 
		else:
	?>
	<tr><td colspan="5">Aucune donnée dans la base de données</td></tr>
	<?php endif; ?>
</table>
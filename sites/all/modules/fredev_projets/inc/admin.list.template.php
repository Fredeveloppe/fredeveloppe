<?php
	$results = db_query("SELECT * FROM {projets} ORDER BY date_debut DESC");
?>

<p><a href="<?=base_path()?>admin/config/fredeveloppe/projets/formulaire">Ajouter un nouveau projet</a></p>

<table>
	<tr>
		<th>Projet n&deg;</th>
		<th>Titre</th>
		<th>Contenu</th>
		<th>Date de début</th>
		<th>Date de fin</th>
		<th>Actions</th>
	</tr>
	<?php 
		if($results->rowCount()):
		foreach($results as $projet): 
	?>
	<tr>
		<td><a href="<?=base_path()?>admin/config/fredeveloppe/projets/formulaire/<?=$projet->id?>">n&deg;<?=$projet->id?></a></td>
		<td><?=$projet->titre?></td>
		<td style="width: 50%;"><?=$projet->texte?></td>
		<td><?=$projet->date_debut?></td>
		<td><?=$projet->date_fin?></td>
		<td><a href="<?=base_path()?>admin/config/fredeveloppe/projets/formulaire/<?=$projet->id?>">Modifier</a> | <a href="<?=base_path()?>admin/config/fredeveloppe/projets/suppression/<?=$projet->id?>">Supprimer</a></td>
	</tr>
	<?php 
		endforeach; 
		else:
	?>
	<tr><td colspan="6">Aucune donnée dans la base de données</td></tr>
	<?php endif; ?>
</table>
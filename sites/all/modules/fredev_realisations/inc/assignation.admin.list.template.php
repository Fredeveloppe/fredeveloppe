<?php
	$predicat = db_query("SELECT recaid FROM {realisations_categories}");
	if($predicat->rowCount()):
		$results = db_query("SELECT * FROM {realisations_definitions}
								LEFT JOIN {realisations_categories}
								ON {realisations_categories}.recaid = {realisations_definitions}.recaid
								order by date_fin_redefid DESC");
?>

<p><a href="<?=base_path()?>admin/config/fredeveloppe/realisations/assignation/formulaire">Ajouter une nouvelle réalisation</a></p>

<table>
	<tr>
		<th>Réalisation n&deg;</th>
		<th>Titre</th>
		<th>Catégorie</th>
		<th>Date de début</th>
		<th>Date de fin</th>
		<th>Activation</th>
		<th>Actions</th>
	</tr>
	<?php 
		if($results->rowCount()):
		foreach($results as $realisation): 
	?>
	<tr>
		<td><a href="<?=base_path()?>admin/config/fredeveloppe/realisations/assignation/formulaire/<?=$realisation->redefid?>">n&deg;<?=$realisation->redefid?></a></td>
		<td><?=$realisation->nom_redefid?></td>
		<td><?=$realisation->nom_recaid?></td>
		<td><?=$realisation->date_debut_redefid?></td>
		<td><?=$realisation->date_fin_redefid?></td>
		<td><?=$realisation->activite_redefid?></td>
		<td><a href="<?=base_path()?>admin/config/fredeveloppe/realisations/assignation/formulaire/<?=$realisation->redefid?>">Modifier</a> | <a href="<?=base_path()?>admin/config/fredeveloppe/realisations/assignation/suppression/<?=$realisation->redefid?>">Supprimer</a></td>
	</tr>
	<?php 
		endforeach; 
		else:
	?>
	<tr><td colspan="7">Aucune donnée dans la base de données</td></tr>
	<?php endif; ?>
</table>
<?php else: ?>

<h2>Impossible d'assigner des réalisations.</h2>

<p>Oups! Vous devez d'abord créer une <a href="/admin/config/fredeveloppe/realisations/categories">catégorie de réalisation</a> avant de pouvoir assigner des réalisations.</p>

<?php endif; ?>
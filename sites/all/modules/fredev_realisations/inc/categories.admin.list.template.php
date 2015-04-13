<?php
	$results = db_query("SELECT * FROM {realisations_categories} ORDER BY ordre_recaid ASC");
?>

<p><a href="<?=base_path()?>admin/config/fredeveloppe/realisations/categories/formulaire">Ajouter une nouvelle catégorie de réalisation</a></p>

<table>
	<tr>
		<th>Catégorie n&deg;</th>
		<th>Nom de la catégorie</th>
		<th>Description</th>
		<th>Couleur associée</th>
		<th>Ordre d'affichage</th>
		<th>Actions</th>
	</tr>
	<?php 
		if($results->rowCount()):
		foreach($results as $realisation): 
	?>
	<tr>
		<td><a href="<?=base_path()?>admin/config/fredeveloppe/realisations/categories/formulaire/<?=$realisation->recaid?>">n&deg;<?=$realisation->recaid?></a></td>
		<td><?=$realisation->nom_recaid?></td>
		<td style="width: 50%;"><?=$realisation->description_recaid?></td>
		<td style="width: 85px;"><div style="width: 35px; height: 35px; background-color: #<?=$realisation->color_recaid?>; box-shadow: 1px 1px 1px 0; margin: 0 auto;"></div></td>
		<td><?=$realisation->ordre_recaid?></td>
		<td><a href="<?=base_path()?>admin/config/fredeveloppe/realisations/categories/formulaire/<?=$realisation->recaid?>">Modifier</a> | <a href="<?=base_path()?>admin/config/fredeveloppe/realisations/categories/suppression/<?=$realisation->recaid?>">Supprimer</a></td>
	</tr>
	<?php 
		endforeach; 
		else:
	?>
	<tr><td colspan="6">Aucune donnée dans la base de données</td></tr>
	<?php endif; ?>
</table>
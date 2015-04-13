<?php
	$results = db_query("SELECT * FROM {recommandations} ORDER BY date_publication DESC");
?>

<p><a href="<?=base_path()?>admin/config/fredeveloppe/recommandations/formulaire">Ajouter une nouvelle recommandation</a></p>

<table>
	<tr>
		<th>Recommandation n&deg;</th>
		<th>Titre</th>
		<th>Contenu</th>
		<th>Personne ressource</th>
		<th>Poste</th>
		<th>Date de publication</th>
		<th>Actions</th>
	</tr>
	<?php 
		if($results->rowCount()):
		foreach($results as $recommandation): 
	?>
	<tr>
		<td style="width: 7.5%;"><a href="<?=base_path()?>admin/config/fredeveloppe/recommandations/formulaire/<?=$recommandation->id?>">n&deg;<?=$recommandation->id?></a></td>
		<td style="width: 7.5%;"><?=$recommandation->titre?></td>
		<td style="width: 50%;"><?=$recommandation->texte?></td>
		<td style="width: 7.5%;"><?=$recommandation->personne_ressource?></td>
		<td style="width: 7.5%;"><?=$recommandation->poste?></td>
		<td style="width: 7.5%;"><?=$recommandation->date_publication?></td>
		<td style="width: 10%;"><a href="<?=base_path()?>admin/config/fredeveloppe/recommandations/formulaire/<?=$recommandation->id?>">Modifier</a> | <a href="<?=base_path()?>admin/config/fredeveloppe/recommandations/suppression/<?=$recommandation->id?>">Supprimer</a></td>
	</tr>
	<?php 
		endforeach; 
		else:
	?>
	<tr><td colspan="7">Aucune donnée dans la base de données</td></tr>
	<?php endif; ?>
</table>
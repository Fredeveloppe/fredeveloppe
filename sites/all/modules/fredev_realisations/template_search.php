<?php
	$cats = db_query("SELECT recaid, nom_recaid FROM {realisations_categories} ORDER BY ordre_recaid ASC");
	$cats_2 = db_query("SELECT recaid, nom_recaid FROM {realisations_categories} ORDER BY ordre_recaid ASC");

	$realisations = db_query("SELECT redefid, nom_redefid, fid_miniature_redefid,
								{realisations_definitions}.recaid, color_recaid, nom_recaid
								FROM {realisations_definitions}
								LEFT JOIN {realisations_categories}
								ON {realisations_definitions}.recaid = {realisations_categories}.recaid
								WHERE activite_redefid = 1
								ORDER BY date_fin_redefid DESC");
?>

<?php if($cats->rowCount()): ?>
	<div id="realisations-cats">
		<ul>
			<li class="active" data-recaid="*">Toutes</li>
			<?php foreach($cats as $cat): ?>
				<li data-recaid="<?=$cat->recaid?>"><?=$cat->nom_recaid?></li>
			<?php endforeach; ?>
		</ul>
		<select>
			<option value="*">Toutes</li>
			<?php foreach($cats_2 as $cat): ?>
				<option value="<?=$cat->recaid?>"><?=$cat->nom_recaid?></li>
			<?php endforeach; ?>
		</select>
	</div>
<?php endif; ?>

<?php if($realisations->rowCount()): ?>
	<div id="realisations-wrapper">
		<div id="wrapping">
			<?php 
				$compteur = 0;
				foreach($realisations as $realisation):
					$compteur++;
			?>
				<article data-id="<?=$compteur?>" class="box" data-recaid="<?=$realisation->recaid?>" data-color="<?=$realisation->color_recaid?>">
					<img src="<?=file_create_url(file_load($realisation->fid_miniature_redefid)->uri)?>" alt="<?=$realisation->nom_redefid?>" />
					<div class="hover">
						<div class="hover-content">
							<h2><?=$realisation->nom_redefid?></h2>
							<span><?=$realisation->nom_recaid?></span>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>
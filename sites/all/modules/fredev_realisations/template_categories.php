<?php
	$results = db_query("SELECT * FROM {realisations_categories} ORDER BY ordre_recaid ASC");
	if($results->rowCount()):
?>


<div class="middle-content">
	<article class="tag services">
		<div class="title-box"><h3><span>Services</span></h3></div>

		<?php 
		$compteur = 0;
		foreach($results as $categorie): 
			if($compteur % 2 == 0) echo "<div class='dual'>";
		?>
		<div class="sheet">
			<div class="imgs">
				<img src="<?=file_create_url(file_load($categorie->fid_miniature_recaid)->uri)?>" alt="<?=$categorie->nom_recaid?>" />
				<div class="hideout"><img class="icon-img" src="<?=file_create_url(file_load($categorie->fid_icone_recaid)->uri)?>" alt="<?=$categorie->nom_recaid?>" /></div>
			</div>
			<div class="relative">
				<div data-id="<?=$categorie->recaid?>" class="tag">
					<div class="title-box">
						<h3><span><?=$categorie->nom_recaid?></span></h3>
					</div>
				</div>
				<p><?=$categorie->description_recaid?></p>
			</div>
		</div>
		<?php 
		$compteur++;
		if($compteur % 2 == 0) echo "</div>";
		endforeach;
		if($compteur % 2 != 0) echo "</div>";
		?>
		<div class="clear"></div>
	</article>
</div>

<?php endif; ?>
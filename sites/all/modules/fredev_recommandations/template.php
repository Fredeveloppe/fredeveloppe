<?php
	$results = db_query("SELECT * FROM {recommandations} ORDER BY date_publication DESC LIMIT 1");
	if($results->rowCount()):
		foreach($results as $recommandation):
?>

<div class="middle-content">
	<article class="tag">
		<div class="title-box"><h3><span>Témoignage</span></h3></div>

		<div class="letterbox-outer">
			<div class="letterbox-inner">
				<h2><?=$recommandation->titre?></h2>
				<img class="letter-timbre" src="<?=$mod_path?>/img/timbre.png" alt="Approuvé" />
				<p class="letter-content">&ldquo;<?=$recommandation->texte?>&rdquo;</p>
				<p class="letter-outro"><?=$recommandation->personne_ressource?>, <em><?=$recommandation->poste?></em>, <img src="<?=file_create_url(file_load($recommandation->fid)->uri)?>" alt="Logo de l'entreprise" /></p>
			</div>
		</div>
	</article>
</div>

<?php 
	endforeach;
endif; 
?>
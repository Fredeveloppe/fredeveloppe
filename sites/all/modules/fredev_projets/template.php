<?php
	$results = db_query("SELECT * FROM {projets} ORDER BY date_debut DESC LIMIT 3");
	$compteur = 0;

	if(!function_exists("convertDate"))
	{
		// Convertie la date reçue en lettre ex: 18 mars 2013
		function convertDate($date)
		{
			$mois = array("janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre");

			$dateArr = explode("-",$date);
			$timeArr = explode(" ", $dateArr[2]);

			return intval($timeArr[0])." ".$mois[intval($dateArr[1]) - 1]." ".$dateArr[0];
		}
	}
?>

<div class="footer-col1">
	<div class="footer-col-inner">
		<h2 class="titre">Projets actuels</h2>
		<div class="separateur"></div>

		<?php 
		// Contenu principal
		if($results->rowCount() > 0):
			foreach($results as $result): 
		?>
			<article>
				<h3><?=$result->titre?></h3>
				<p><?=$result->texte?></p>
				<div>Depuis le <?=convertDate($result->date_debut)?></div>
			</article>
		<?php 
			$compteur++;
			if($compteur != 3) echo "<div class='separateur'></div>";
			endforeach;
		endif;

		// Contenu fallback
		while($compteur > 3):
		?>
			<article>
				<h3>Faites votre demande</h3>
				<p>On dirais que je suis en manque de projets ambicieux. Si vous avez un petit quelque chose qui concerne le développement Web que vous avez toujours voulu concevoir, <a href='".base_path()."contact'>prenez contact avec moi</a>. Si ma disponibilité me le permet, je me ferais un plaisir de rendre vos idées tangibles.</p>
			</article>

		<?php 
			$compteur++;
			if($compteur != 3) echo "<div class='separateur'></div>";
		endwhile; 
		?>
	</div>
</div>
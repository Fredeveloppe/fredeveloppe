<?php
	$results = db_query("SELECT {commentaires}.*, {field_data_field_prenom}.field_prenom_value as prenom, {field_data_field_nom}.field_nom_value as nom, {field_data_field_avatar}.field_avatar_fid as avatar 
		FROM {commentaires} LEFT JOIN {users} ON {users}.uid = {commentaires}.uid 
		LEFT JOIN {profile} ON {profile}.uid = {users}.uid
		LEFT JOIN {field_data_field_prenom} ON {field_data_field_prenom}.entity_id = {profile}.pid
		LEFT JOIN {field_data_field_nom} ON {field_data_field_nom}.entity_id = {profile}.pid
		LEFT JOIN {field_data_field_avatar} ON {field_data_field_avatar}.entity_id = {profile}.pid
		ORDER BY {commentaires}.date_publication DESC LIMIT 3");
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

<div class="footer-col2">
	<div class="footer-col-inner">
		<h2 class="titre">Derniers commentaires</h2>
		<div class="separateur"></div>
		<?php
			// Contenu principal
			if($results->rowCount() > 0):
				foreach($results as $commentaire):
		?>

			<article>
				<div class="zone-comment">
					<div class="zone-photo"><div class="photo"><img src="<?=file_create_url(file_load($commentaire->avatar)->uri)?>" alt="<?=$commentaire->prenom.' '.$commentaire->nom?>" /></div></div>
					<div class="text">
						<h3><?=$commentaire->prenom." ".$commentaire->nom?> dit&nbsp;:</h3>
						<p><?=$commentaire->commentaire?></p>
					</div>
				</div>
				<span class="writed">Écrit le <?=convertDate($commentaire->date_publication)?></span>
			</article>

		<?php
					$compteur++;
					if($compteur != 3) echo "<div class='separateur'></div>";
				endforeach;
			endif;
		?>
	</div>
</div>
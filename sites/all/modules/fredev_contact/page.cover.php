<div class="page-trick">

	<div class="page">

		<?php 
		// Section contact
		if($nom || $adresse || $cp || $courriel || $maison || $travail || $cell):
		?>
		
			<h2 class="contact-coords contact-title">Mes coordonnées</h2>

			<?php
			// Section Adresse
			if($nom || $adresse || $cp):
			?>

			<div class='contact-box'>
				<div class="box-left">
					<img src="<?=base_path().$mod_path?>/img/adresse-icon.png" alt='adresse' />
					<span>Adresse</span>
				</div>

				<div class="box-right">
					<?php
						if($nom) echo $nom."<br />";
						if($adresse) echo $adresse."<br />";
						if($cp) echo $cp."<br />"; 
					?>
				</div>
			</div> <!-- EOF: .contact-box -->

			<?php endif; ?>

			<?php
			// Section Adresse
			if($courriel):
			?>

			<div class='contact-box'>
				<div class="box-left">
					<img src="<?=base_path().$mod_path?>/img/courriel-icon.png" alt='adresse' />
					<span>Courriel</span>
				</div>
				<div class="box-right"><a href="mailto:<?=$courriel?>"><?=$courriel?></a></div>
			</div> <!-- EOF: .contact-box -->

			<?php endif; ?>

			<?php
			// Section Adresse
			if($maison || $travail || $cell):
			?>

			<div class='contact-box'>
				<div class="box-left">
					<img src="<?=base_path().$mod_path?>/img/tel-icon.png" alt='adresse' />
					<span>Téléphone</span>
				</div>
				<div class="box-right">
					<?php
						if($maison) echo "Maison : ".$maison."<br />";
						if($travail) echo "Travail : ".$travail."<br />";
						if($cell) echo "Cellulaire : ".$cell."<br />"; 
					?>
				</div>
			</div> <!-- EOF: .contact-box -->

			<?php endif; ?>

		<?php endif; ?>

		<?php 
		// Section médias sociaux
		if($fb || $twitter || $google || $skype):
		?>

			<h2 class="contact-medias contact-title">Médias Sociaux</h2>

			<div id="contact-media-icon">
				<?php
					if($fb) echo "<a href='".$fb."' target='_blank'><img src='".base_path().$mod_path."/img/facebook.png' alt='Facebook' title='Voir ma page profesionnelle Facebook' /></a>";
					if($twitter) echo "<a href='".$twitter."' target='_blank'><img src='".base_path().$mod_path."/img/twitter.png' alt='Twitter' title='Suivre mes divers projets sur Twitter' /></a>";
					if($google) echo "<a href='".$google."' rel='publisher' target='_blank'><img src='".base_path().$mod_path."/img/google-plus.png' alt='Google+' title='Voir ma page profesionnelle Google+' /></a>";
					if($skype):
				?>
					<script type="text/javascript" src="http://cdn.dev.skype.com/uri/skype-uri.js"></script>
					<a href="skype:<?=$skype?>?call"><img src='<?=base_path().$mod_path?>/img/skype.png' alt='Google+' title="Me parler gratuitement via le service Skype" /></a>

				<?php endif; ?>
			</div>

		<?php endif; ?>

	</div> <!-- EOF: .page -->

	<div class="page2">

		<h2 class="contact-message contact-title">Message privé</h2>

		<form id="form-contact" action="<?=base_path()?>contact" method="post">

			<div class="form-container">

				<div class="dual-input">
					<div class="relative">
						<label for="prenom">Prénom<span class="erreurIcon <?=$classError['prenom']?>" title="<?=$erreur['prenom']?>"></span></label>
						<input type="text" id="prenom" name="prenom" value="<?=$prenom?>" />
					</div>
				</div>

				<div class="dual-input">
					<div class="relative">
						<label for="nom">Nom<span class="erreurIcon <?=$classError['nom']?>" title="<?=$erreur['nom']?>"></span></label>
						<input type="text" id="nom" name="nom" value="<?=$nom?>" />
					</div>
				</div>

				<div class="dual-input">
					<div class="relative">
						<label for="courriel">Courriel<span class="erreurIcon <?=$classError['courriel']?>" title="<?=$erreur['courriel']?>"></span></label>
						<input type="text" id="courriel" name="courriel" value="<?=$courriel_form?>" />
					</div>
				</div>

				<div class="dual-input">
					<div class="relative">
						<label for="sujet">Sujet<span class="erreurIcon <?=$classError['sujet']?>" title="<?=$erreur['sujet']?>"></span></label>
						<input type="text" id="sujet" name="sujet" value="<?=$sujet?>" />
					</div>
				</div>

				<div class="clear"><!-- Rétablie le flux de la page --></div>

				<div class="textarea-input">
					<div class="relative">
						<label for="message">Message<span class="erreurIcon <?=$classError['message']?>" title="<?=$erreur['message']?>"></span></label>
						<textarea id="message" name="message"><?=$message?></textarea>
					</div>
				</div>

				<div class="action-btns">
					<input type="reset" class="effacer" value="Effacer" />
					<input id="contact-submit" type="submit" value="Envoyer" />
				</div>

			</div> <!-- EOF: .form-container -->

		</form>

	</div> <!-- EOF: .page2 -->

	<div class="clear"><!-- Rétablie le flux de la page --></div>

</div> <!-- EOF: .page-trick -->

<div class="clear"><!-- Rétablie le flux de la page --></div>
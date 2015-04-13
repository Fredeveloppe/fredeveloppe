<div class="page-trick">

	<div class="page">

		<h2 class="contact-merci contact-title">Merci beaucoup</h2>

		<article id="bloc-remerciement">

			<p>Chaque message reçu est lu avec une attention particulière. Si votre message requiert une réponse, surveillez votre boîte de messagerie. Je prends mes courriels régulièrement et je devrais vous répondre dans un délai raisonnable.</p>

			<p>Advenant que vous soyez pressé, vous pouvez toujours <a href="<?=base_path()?>contact">revenir à la page précédente</a> et choisir un média social pour communiquer avec moi.</p>

			<p>Votre opinion est importante pour Fredeveloppe. Alors, n’hésitez pas à m’écrire à nouveau!</p>

			<p>Frédéric Bouchard</p>

		</article>


	</div> <!-- EOF: .page -->

	<div class="page2">

		<h2 class="contact-votre-message contact-title">Votre message</h2>

		<div id="bloc-message"><?php if(isset($mail_content)) echo $mail_content?></div>

	</div> <!-- EOF: .page2 -->

	<div class="clear"><!-- Rétablie le flux de la page --></div>

</div> <!-- EOF: .page-trick -->

<div class="clear"><!-- Rétablie le flux de la page --></div>
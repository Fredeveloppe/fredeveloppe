<div>
	<?php if ($messages): ?>
	    <div id="messages"><div class="section clearfix">
	      <?php print $messages; ?>
	    </div></div> <!-- /.section, /#messages -->
	<?php endif; ?>
</div>

<header id="entete">

	<?php if($page['connexion']): ?>
		<div class="middle-content">
			<section id="connexion">
				<?php print drupal_render($page['connexion']); ?>
			</section> <!-- EOF: #connexion -->
		</div>
	<?php endif; ?>

	<?php if($page['menu']): ?>
		<section id="menu-principal" class="middle-content">
			<?php print drupal_render($page['menu']); ?>
		</section> <!-- EOF: #menu-principal -->
	<?php endif; ?>

	<div class="clear"></div>

</header>

<div id="main-content">

	<div class="middle-content center">
		<div id="fil-ariane">
			<?=$variables['breadcrumb']?>
		</div>
	</div>

	<section id="contenu">
		<?php 
			unset($page['content']['system_main']['default_message']);
			print drupal_render($page['content']);
		?>
	</section>

</div> <!-- EOF: #main-content -->

<footer id="pied">

	<?php if(theme_get_setting('bandeau')): ?>
		<div class="bandeau"><?=theme_get_setting('bandeau')?></div>
	<?php endif; ?>

	<?php if($page['footer']): ?>
		<section id="pied-page">
			<div class="middle-content">
				<?php print drupal_render($page['footer']); ?>
				<div class="clear"><!-- Rétablie le flux de la page --></div>
			</div>
		</section> <!-- EOF: #pied-page -->
	<?php endif; ?>

	<?php if($page['final_footer']): ?>
		<div class="ppf">
			<div class="middle-content">
				<section id="pied-page-final">
					<?php print drupal_render($page['final_footer']); ?>
					<span>&copy; Frédéric Bouchard 2013 <span> - <em>Valide HTML5/CSS3</em></span></span>
				</section> <!-- EOF: #pied-page-final -->
			</div>
		</div>
	<?php endif; ?>

</footer>
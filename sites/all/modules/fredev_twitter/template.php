<?php
	$file_content = file_get_contents($mod_path."/tweet.txt");
	$tweet_content = json_decode($file_content, true);

	function convert_twitter_date($twitter_date)
	{
		$mois_lettre = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
		$jour = date("j ", strtotime($twitter_date));
		$mois = date("n", strtotime($twitter_date));

		return $jour.$mois_lettre[$mois - 1].date(" Y \- g:i A",strtotime($twitter_date));
	}
?>

<div class="footer-col3">
	<div class="footer-col-inner">
		<h2 class="titre">On garde contact?</h2>
		<div class="separateur"></div>
		<div class="twitter-box">
			<div><img class="twitter-buble" src="/<?=$mod_path?>/img/bulle-twitter.png" alt="" /></div>
			<div><img class="twitter-bird" src="/<?=$mod_path?>/img/twitter-bird.png" alt="" /></div>
			<?php 
				if($tweet_content):
					$tweet_img = preg_replace("/_normal/", "", $tweet_content[0]['user']['profile_image_url']);
			?>
				<div class="tweet">
					<div class="tweet-mess">
						<img class="tweet-profile" src="<?=$tweet_img?>" alt="<?=$tweet_content[0]['user']['name']?>" />
						<p class="tweet-intro"><a href="https://twitter.com/<?=$tweet_content[0]['user']['screen_name']?>" target="_blank"><?=$tweet_content[0]['user']['name']?> <span>@<?=$tweet_content[0]['user']['screen_name']?></span></a></p>
						<p class="tweet-content"><?=$tweet_content[0]['text']?></p>
						<p class="tweet-outro"><?=convert_twitter_date($tweet_content[0]['created_at'])?></p>
					</div>
				</div>
			<?php else: ?>
				<div class="tweet no-tweet">
					<span>Aucun tweet</span>n'a été publié. 
				</div>
			<?php endif; ?>
		</div>
		<div class="separateur sp-separator"></div>
	</div>

	<div class="col3-end-block">
		<div class="col3-part2-entete">
			<h2 class="titre2">Médias sociaux</h2>
			<div class="separateur"></div>
		</div>
		<div class="small-img">
			<a href="<?=variable_get('medias_facebook')?>" target="_blank"><img src="/<?=$mod_path?>/img/facebook.png" title="Consulter ma page facebook profesionnelle" alt="Consulter ma page facebook profesionnelle" /></a>
			<a href="<?=variable_get('medias_google')?>" target="_blank"><img src="/<?=$mod_path?>/img/google-plus.png" title="Consulter la page Google+ de Fredeveloppe" alt="Consulter la page Google+ de Fredeveloppe" /></a>
			<div class="breaker"></div>
			<a href="https://twitter.com/<?=variable_get('medias_twitter')?>" target="_blank"><img src="/<?=$mod_path?>/img/twitter.png" title="Voir mon flux Twitter" alt="Voir mon flux Twitter" /></a>
			<a href="skype:<?=variable_get('medias_skype')?>?call"><img src="/<?=$mod_path?>/img/skype.png" title="Me téléphoner via Skype" alt="Me téléphoner via Skype" /></a>
		</div>
		<div>
			<div id="google-plus"><div class="g-plusone" data-href="http://www.fredeveloppe.com/index.php"></div></div>
            <div id="facebook-like"><div class="fb-like" data-href="http://www.fredeveloppe.com/index.php" data-send="true" data-layout="button_count" data-width="200" data-show-faces="true"></div></div>
		</div>
		<div id="haut-page"><a href="#">Haut de page</a></div>
	</div>

	<!-- Facebook Like Moteur -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/fr_CA/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script> 
   
    <!-- Google Like Moteur -->
    <script type="text/javascript">
	  window.___gcfg = {lang: 'fr'};
	
	  (function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>
</div>
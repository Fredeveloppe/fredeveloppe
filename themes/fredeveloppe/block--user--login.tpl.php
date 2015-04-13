<div id="ecusson-front"><span id="vis"></span></div>

<form action="<?=base_path()?>node?destination=node" method="post" id="user-login-form" accept-charset="UTF-8">
	<div>
		<div class="form-item form-type-textfield form-item-name">
  			<label for="edit-name">Utilisateur <span class="form-required" title="Ce champ est obligatoire.">*</span><span class="form-required2" title="Ce champ est obligatoire.">:</span></label>
 			<input type="text" id="edit-name" name="name" value="" size="15" maxlength="60" class="form-text required">
		</div>

		<div class="form-item form-type-password form-item-pass">
  			<label for="edit-pass">Mot de passe <span class="form-required" title="Ce champ est obligatoire.">*</span><span class="form-required2" title="Ce champ est obligatoire.">:</span></label>
 			<input type="password" id="edit-pass" name="pass" size="15" maxlength="128" class="form-text required">
		</div>
		<div class="item-list">
			<ul>
				<li class="first"><a href="/user/register" title="Créer un nouveau compte utilisateur.">Inscription</a></li>
				<li class="last"><a href="/user/password" title="Demander un nouveau mot de passe par courriel.">Mot de passe oublié</a></li>
			</ul>
			<div class="clear"><!-- Rétablie le flux de la page --></div>
		</div>
		<input type="hidden" name="form_build_id" value="<?php print $elements['form_build_id']['#value']; ?>">
		<input type="hidden" name="form_id" value="user_login_block">
		<div class="form-actions form-wrapper" id="edit-actions">
			<input type="submit" id="edit-submit" name="op" value="Se connecter" class="form-submit">
		</div>
	</div>
</form>
<?php

// Callback appellé lors de la construction du sélecteur d'option des réalisations
function realisations_root()
{
	$mod_path = drupal_get_path('module', 'fredev_realisations');

	// Évalue le PHP/HTML et stock son résultat dans une variable
	ob_start();
	include($mod_path."/inc/root.php");
	$output = ob_get_clean();

	return $output;
}

?>
<?php

	function fredeveloppe_breadcrumb($variables) {
	  $breadcrumb = $variables['breadcrumb'];
	  
	  // Inclue la page courante
	  if (arg(0) == 'node' && is_numeric(arg(1))) $nodeid = arg(1);

	  if(isset($nodeid))
	  {
	  	$node = node_load($nodeid);
	  	$breadcrumb[] = $node->title;
	  }
	  else $breadcrumb[] = "Accueil";
	  
	  // Output graphique
	  $output = "<div class='breadcrum-text'><div id='breadcrum-rel'>";
	  $output .= "<span id='breadcrumb-left' class='breadcrumb crumbs-aside'></span>";
	  $output .= "<span id='breadcrumb-right' class='breadcrumb crumbs-aside'></span>";
	  $output .= "<span id='breadcrumb-top1' class='breadcrumb crumbs-top'></span>";
	  $output .= "<span id='breadcrumb-top2' class='breadcrumb crumbs-top'></span>";


	  // Output textuel
	  $output .= '<h3>' . t('Perdu sur mon portfolio?') . '</h3>';
	  $output .= "Vous êtes ici : ".implode(' » ', $breadcrumb);
	  $output .= "</div></div>";
	  return $output;
	}

	function fredeveloppe_preprocess_html(&$vars)
	{
		 $vars['head_title'] = implode(' | ', array(drupal_get_title(), variable_get('site_name')))." - ".variable_get('site_slogan');  
	}

?>
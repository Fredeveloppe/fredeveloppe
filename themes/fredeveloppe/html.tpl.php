<?php

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 */
?>
<?php global $base_path; ?>
<?php global $base_root; ?>
<!DOCTYPE HTML>
<html>
<head profile="<?php print $grddl_profile; ?>">
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1">
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="<?php print $base_root . $base_path . path_to_theme() ?>/stylesheets/jquery.qtip.min.css" />
  <?php print $scripts; ?>

  <!-- Compatibilité pour Internet Explorer avec le HTML5 -->
    <!--[if IE]>
    <script type="text/javascript">
    
      (function(){

            var html5elmeents = "address|article|aside|audio|canvas|command|datalist|details|dialog|figure|figcaption|footer|header|hgroup|keygen|mark|meter|menu|nav|progress|ruby|section|time|video".split('|');
    
          for(var i = 0; i < html5elmeents.length; i++)
            {
          document.createElement(html5elmeents[i]);
        }
    
        })();
  
  </script>
  <![endif]-->

  <script src="<?php print $base_root . $base_path . path_to_theme() ?>/js/jquery-easing.js"></script>
  <script src="<?php print $base_root . $base_path . path_to_theme() ?>/js/jquery-easing-compatibility.js"></script>
  <script src="<?php print $base_root . $base_path . path_to_theme() ?>/js/jQueryRotate.2.1.js"></script>
  <script src="<?php print $base_root . $base_path . path_to_theme() ?>/js/jquery.qtip.min.js"></script>
  <script src="<?php print $base_root . $base_path . path_to_theme() ?>/js/main.js"></script>

</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>
</html>

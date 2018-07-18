<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/mobile-detect.php',       //Detect mobile browsers
  'lib/assets.php',    // Scripts and stylesheets
  'lib/comments.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/nav.php',             // Custom nav modifications
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php', // Theme customizer
  'lib/shortcodes.php',          // Shortcode Definitions
  'lib/post-types/case-study-post-type.php',          // Case Study Custom Post Type functions
  'lib/post-types/client-anniversary-post-type.php',          // Client Anniversary Custom Post Type functions
  'lib/post-types/landing-post-type.php',          // Landing Page Custom Post Type
  'lib/post-types/person-post-type.php',          // Person Custom Post Type
  'lib/post-types/industry-post-type.php'          // Industry Custom Post Type
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

<?php
namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

flush_rewrite_rules(true);

define('TYPE_SLIDER', 'slide');
define('TYPE_CASE_STUDY', 'case_study');
define('TYPE_PERSON', 'person');
define('MAX_SLIDER_ITEMS', 4);
define('THUMB_TWO_COL_CONTENT_BLOCK_WITH_SIDEBAR', '2ColWithSide_Thumb');
define('THUMB_PAGE_ILLUSTRATION', 'pageIllustration_Thumb');
define('THUMB_PAGE_ILLUSTRATION_1x', 'pageIllustration_thumb_1x');
define('THUMB_PERSON', 'Team_Thumb');
define('THUMB_PERSON_ZOOM', 'Person_Zoom_Thumb');
define('THUMB_BLOG_AUTHOR', 'Blog_Author_Thumb');
define('THUMB_BLOG_RELATED_POST', 'Blog_Related_post_Thumb');
define('THUMB_CONTENT_BLOCK', 'THUMB_CONTENT_BLOCK');
define('POST_EXCERPT_LENGTH', 40);

/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  // add_theme_support('soil-clean-up');
  // add_theme_support('soil-nav-walker');
  // add_theme_support('soil-nice-search');
  add_theme_support('jquery-cdn');
  // add_theme_support('soil-relative-urls');

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  // Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
  register_nav_menus(array(
    'primary' => 'Primary Menu',
    'topRight' => 'Top Right Menu',
	'footer' => 'Footer Menu',
	'support' => 'Support Menu'
  ));

  // Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size(75, 75, false);
  add_image_size(THUMB_CONTENT_BLOCK, 1024, 9999, false);
  add_image_size(THUMB_PAGE_ILLUSTRATION, 750, 360, false);
  add_image_size(THUMB_PAGE_ILLUSTRATION_1x, 380, 175, false);
  add_image_size(THUMB_PERSON, 216, 216, true);
  add_image_size(THUMB_PERSON_ZOOM, 118, 126, true);
  add_image_size(THUMB_BLOG_AUTHOR, 58, 70, true);
  add_image_size(THUMB_BLOG_RELATED_POST, 245, 92, true);

//  acf_add_options_page('Theme Options');

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  add_editor_style(Assets\asset_path('styles/main.css'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
  register_sidebar([
    'name'          => __('Primary', 'sage'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
  static $display;

  $display = !in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_front_page(),
    tf_hide_sidebar(),
    is_page_template('template-section-main.php'),
    is_page_template('template-one-column-no-subnav.php'),
    is_page_template('template-fluid-layout.php'),
    is_singular('case_study')
  ]);

  return apply_filters('sage/display_sidebar', $display);
}

function tf_hide_sidebar() {
  global $post;

  $hideSidebar = false;

  if ($post && !in_array($post->post_type, array(TYPE_CASE_STUDY))) {
    $subNav = get_sub_nav($post);

    if (empty($subNav)  ||  (strpos($subNav, 'subdepth2') == false && strpos($subNav, 'id="menu-') == false) || in_array($post->ID, array(17, 18))) {
      $hideSidebar = true;
    }
  }

  return $hideSidebar;
}

/**
 * Theme assets
 */
function assets() {

  wp_enqueue_style('tf/fonts', 'https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,700', false, '112017');
  wp_enqueue_style('tf/css', Assets\asset_path('styles/main.css'), false, 20180306);

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('tf/js', Assets\asset_path('scripts/main.js'), ['jquery'], 20180315.2, true);

  if (is_page_template('template-case-studies.php')):
  	wp_enqueue_script('tf/case_study_js', Assets\asset_path('scripts/case-studies.js'), ['jquery'], 20171220, true);
  endif;

  if (!is_admin() && current_theme_supports('jquery-cdn')) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', array(), null, false);
    add_filter('script_loader_src', __NAMESPACE__ . '\\jquery_local_fallback', 10, 2);
  }

  wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 1);


// http://wordpress.stackexchange.com/a/12450
function jquery_local_fallback($src, $handle = null) {
  static $add_jquery_fallback = false;

  if ($add_jquery_fallback) {
    echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/assets/js/vendor/jquery-1.11.0.min.js"><\/script>\')</script>' . "\n";
    $add_jquery_fallback = false;
  }

  if ($handle === 'jquery') {
    $add_jquery_fallback = true;
  }

  return $src;
}
add_action('wp_head', __NAMESPACE__ . '\\jquery_local_fallback', 1);


function extended_upload_mimes ( $mime_types =array() ) {
   $mime_types['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

   return $mime_types;
}
add_filter('upload_mimes', __NAMESPACE__ . '\\extended_upload_mimes');

add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );

// setup one language for admin and the other for theme
// must be called before load_theme_textdomain()
function wpsx_redefine_locale($locale) {
    // run your tests on the URI
        $lang = explode('/', $_SERVER['REQUEST_URI']);
        // here change to english if requested
        if($lang[1] == 'fr'){
          $locale = 'fr_FR';
        } elseif($lang[1] == 'de'){
          $locale = 'de_DE';
        } elseif($lang[1] == 'nl'){
          $locale = 'nl_NL';
        }
    return $locale;
}
add_filter('locale',__NAMESPACE__ . '\\wpsx_redefine_locale');

add_action('after_setup_theme', __NAMESPACE__ . '\\my_child_theme_setup');
function my_child_theme_setup() {
    load_child_theme_textdomain('thoughtfarmer', get_stylesheet_directory() . '/languages');
}

add_action( 'wp_print_styles', __NAMESPACE__ . '\\my_deregister_styles', 100 );

function my_deregister_styles() {
    wp_dequeue_script('public-documentation-tree');
    wp_dequeue_style('public-documentation-tree');
}

// remove the ... from excerpt and change the text, this was a pain to figure out
function change_excerpt_more()
{
    function thoughtfarmer_excerpt_length( $length ) {
            return 40;
    }
    remove_filter('excerpt_length', 'twentyten_excerpt_length');
    add_filter('excerpt_length', __NAMESPACE__ . '\\thoughtfarmer_excerpt_length');

    function thoughtfarmer_auto_excerpt_more( $more ) {
        return '&hellip;';
    }
    remove_filter('excerpt_more', 'twentyten_auto_excerpt_more');
    add_filter('excerpt_more', __NAMESPACE__ . '\\thoughtfarmer_auto_excerpt_more');

    function thoughtfarmer_custom_excerpt_more( $output ) {
            return $output;
    }
    remove_filter('get_the_excerpt', 'twentyten_custom_excerpt_more');
    add_filter('get_the_excerpt', __NAMESPACE__ . '\\thoughtfarmer_custom_excerpt_more');
}
add_action('after_setup_theme', __NAMESPACE__ . '\\change_excerpt_more');

// allow script & iframe tag within posts
function tf_allow_post_tags( $allowedposttags ){
   $allowedposttags['object'] = array(
         'id' => array (),
         'classid' => array (),
         'width' => array (),
         'height' => array (),
         'codebase' => array ());

   $allowedposttags['embed'] = array(
         'id' => array (),
         'type' => array (),
         'width' => array (),
         'height' => array (),
         'name' => array (),
         'allowfullscreen' => array (),
         'allowscriptaccess' => array (),
                           'flashvars' => array(),
         'src' => array ());

   $allowedposttags['param'] = array(
         'name' => array (),
         'value' => array ());

   $allowedposttags['ul'] = array (
         'class' => array (),
         'style' => array (),
         'id' => array (),
         'type' => array ());

   $allowedposttags['div']  = array(
         'align' => array (),
         'class' => array (),
         'dir' => array (),
         'lang' => array(),
         'style' => array (),
         'id' => array (),
         'xml:lang' => array());

   $allowedposttags['iframe']  = array(
         'align' => array (),
         'class' => array (),
         'height' => array (),
         'width' => array(),
         'style' => array (),
         'id' => array (),
         'src' => array (),
         'scrolling' => array (),
         'name' => array (),
         'xml:lang' => array());

   $allowedposttags['span'] = array (
         'class' => array (),
         'dir' => array (),
         'align' => array (),
         'lang' => array (),
         'style' => array (),
         'title' => array (),
         'id' => array (),
         'xml:lang' => array());

   $allowedposttags['textarea'] = array (
         'name' => array (),
         'class' => array (),
         'align' => array (),
         'lang' => array (),
         'style' => array (),
         'readonly' => array (),
         'id' => array (),
         'xml:lang' => array());

   $allowedposttags['input'] = array (
         'name' => array (),
         'class' => array (),
         'align' => array (),
         'lang' => array (),
         'style' => array (),
         'type' => array (),
         'readonly' => array (),
         'value' => array (),
         'id' => array (),
         'xml:lang' => array());

   $allowedposttags['button'] = array (
         'name' => array (),
         'class' => array (),
         'align' => array (),
         'lang' => array (),
         'style' => array (),
         'type' => array (),
         'readonly' => array (),
         'value' => array (),
         'id' => array (),
         'xml:lang' => array());

    return $allowedposttags;
}
add_filter('wp_kses_allowed_html',__NAMESPACE__ . '\\tf_allow_post_tags', 1);

function add_tf_documentation_sitemap_to_yoast(){
  if (get_current_blog_id() == 8):
    $documentationSitemap = 'documentation-site-map.xml';

    // http://wordpress.stackexchange.com/a/188461
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    $path = get_home_path() . '/' . $documentationSitemap;

    // http://wordpress.stackexchange.com/a/8404
    date_default_timezone_set(get_option('timezone_string'));
    $lastmod = date('c', filemtime($path));

    $sitemap_custom_items = '<sitemap>
      <loc>'.get_site_url().'/'.$documentationSitemap.'</loc>
      <lastmod>'.$lastmod.'</lastmod>
    </sitemap>
    ';

    return $sitemap_custom_items;
  endif;
}
add_filter('wpseo_sitemap_index', __NAMESPACE__ . '\\add_tf_documentation_sitemap_to_yoast', 1);
add_filter('wpseo_enable_xml_sitemap_transient_caching', '__return_false');

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide, set $content_width = 620; so images and videos will not overflow.
 * Default: 1140px is the default Bootstrap container width.
 */
if (!isset($content_width)) { $content_width = 940; }



/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', __NAMESPACE__ . '\\disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', __NAMESPACE__ . '\\disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', __NAMESPACE__ . '\\disable_emojis');

/**
 * Filter function used to remove the tinymce emoji plugin.
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {

		// Strip out any URLs referencing the WordPress.org emoji location
		$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
		foreach ( $urls as $key => $url ) {
			if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
				unset( $urls[$key] );
			}
		}

	}

	return $urls;
}

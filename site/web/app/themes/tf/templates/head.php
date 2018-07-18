<!DOCTYPE html>
<?php
$htmlClass = '';

if ($post && $post->post_type == 'anniversary'):
  $htmlClass = 'full-height';
endif;
?>
<html class="<?php echo $htmlClass; ?> no-js" <?php language_attributes(); ?>>
<head>
   <?php the_field('head_tag'); ?>
   <?php
   //If we're on the documentation site we'll request the title, but not output it. This is a weird issue with the MVC plugin where it'll show the site name by default if we don't call this method. If you call this method it then shows the proper documentation page title.
   if (get_current_blog_id() == 8):
    wp_title('|', false);
   endif;
   ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
    <?php /*if (is_home() || $post->post_type == 'post'): ?>
    <link href="<?php bloginfo('stylesheet_directory'); ?>/_css/responsive.css?v=1.3" rel="stylesheet" media="all" type="text/css"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <?php endif;
  <meta name="viewport" content="width=960" />*/?>
  <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon-leaf.ico" type="image/x-icon"/>
  <meta name="google-site-verification" content="szOBsLhlGTmcbRgFxSthoP1AtBvRIe9j-ivq2OU7UOk" />
  <meta name="msvalidate.01" content="2429CD6E9810AE03D2E2FF02AD441B83" />
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

  <?php wp_head(); ?>

   <?php
    if (get_current_blog_id() == 2 && (is_front_page() || basename(get_page_template()) == 'page-multilingual-landing-page.php')):
        if ($post->ID != 3) echo '<link rel="alternate" hreflang="en" href="https://www.thoughtfarmer.com/" />';
        if ($post->ID != 11088) echo '<link rel="alternate" hreflang="fr" href="https://www.thoughtfarmer.com/fr/" />';
        if ($post->ID != 11271) echo '<link rel="alternate" hreflang="de" href="https://www.thoughtfarmer.com/de/" />';
        if ($post->ID != 11270) echo '<link rel="alternate" hreflang="nl" href="https://www.thoughtfarmer.com/nl/" />';
    endif;
    ?>
    <script type="text/javascript">
    if ((!$.cookieCuttr.accepted && !$.cookieCuttr.declined) || $.cookieCuttr.accepted) {
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push(
        {'gtm.start': new Date().getTime(),event:'gtm.js'}
        );var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NC8RVN');
    }
    </script>
</head>
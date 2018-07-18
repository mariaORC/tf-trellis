<?php
use Roots\Sage\Setup;
use Roots\Sage\Assets;
use Roots\Sage\Wrapper;

get_template_part('templates/head');
?>
<body <?php body_class(); ?>>
  <div class="page-container">
    <?php
        $_SERVER['QUICK_CACHE_ALLOWED'] = FALSE;
        do_action('get_header');
        get_template_part('templates/header');
    ?>
    <div class="home-feature">
        <div class="feature-caption text-center">
            <div class="inner">
                <h1><?php the_field('intro_title'); ?></h1>
                <p class="lead"><?php the_field('intro_content'); ?></p>
                <?php
					echo '<div class="clearfix"><a href="/#demo" class="play-demo" title=\''.get_field('intro_video_lightbox_caption').'\'>';
					echo Assets\get_responsive_image(get_field('intro_screenshot'), get_field('intro_title'), '', THUMB_CONTENT_BLOCK, 'full', THUMB_CONTENT_BLOCK, 'full', THUMB_PAGE_ILLUSTRATION, THUMB_CONTENT_BLOCK, THUMB_PAGE_ILLUSTRATION_1x, THUMB_PAGE_ILLUSTRATION, '100%');
					echo '</a></div>';
                ?>
            </div>
        </div>
	</div>
	<div class="home-header cta_wrap text-center">
		<div id="ctas" class="<?php echo $ctaClass; ?>">
			<a id="request-demo-button" href="/demo/" class="btn btn-success-dark btn-outline">Request Demo</a>
			<a id="watch-tour-button" href="/#demo" class="tour-button btn btn-danger play-demo">Watch the Tour</a>
		</div>
	</div>
    <?php if (get_field('show_announcement_strip')): ?>
        <div class="announcement-strip">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-sm-offset-2 text-center">
                        <h2><?php the_field('strip_title'); ?></h2>

                        <?php
                        if (get_field('strip_icon')):
                            echo '<p><img src="'.get_field('strip_icon').'" alt="'.get_field('strip_title').'" /></p>';
                        endif;
                        ?>

                        <p><a href="<?php the_field('strip_button_url'); ?>" class="btn btn-warning"><?php the_field('strip_button_label'); ?></a></p>

                        <?php
                        if (get_field('strip_footer')):
                            echo '<div class="strip-footer">'.get_field('strip_footer').'</div>';
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<!--                 case 'announcement_strip':
                    ///strip_title
                    ///strip_icon
                    ///button_label
                    ///button_url
                    ///strip_footer
                    break;
 -->
    <div class="wrap" role="document">
        <div class="content">
            <main class="main" role="main">
                <?php include Wrapper\template_path(); ?>
            </main><!-- /.main -->
        </div><!-- /.content -->
    </div><!-- /.wrap -->
    </div>
    <?php get_template_part('templates/footer'); ?>
</body>
</html>

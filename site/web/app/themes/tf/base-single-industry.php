<?php
use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Extras;
use Roots\Sage\Assets;

get_template_part('templates/head');

$css = 'industry-page';
?>
<body <?php body_class($css); ?>>
  <div class="page-container">
    <?php
        do_action('get_header');

        if (!get_field('hide_header'))
            get_template_part('templates/header');

		$image = wp_get_attachment_image_src(get_field('intro_page_illustration'), 'full');

		if ($image && get_field('intro_title')):
			$bannerHeight = get_field('banner_height');

			if (empty($bannerHeight)) {
				$bannerHeight = 380;
			}

			$captionStyle = '';
			$bannerTextColor = get_field('banner_text_colour');
			$bannerSubHeadingTextColor = get_field('banner_sub_heading_text_colour');
			$bannerCTAColor = get_field('banner_cta_colour');
			$bannerCTATextColor = get_field('banner_cta_text_colour');
			$bannerTextShadowColor = get_field('banner_text_shadow_colour');
			$addBannerTextShadow = get_field('add_text_shadow');
			$bannerTextShadow = '';

			if ($addBannerTextShadow && !empty($bannerTextShadowColor)) {
				$bannerTextShadow = ' text-shadow: 2px 2px 12px '.Extras\hex2rgba($bannerTextShadowColor, 1).'; ';
			}

			if (!empty($bannerTextColor)) {
				$bannerTextColor = ' color: '.$bannerTextColor.'; ';
			}

			if (!empty($bannerSubHeadingTextColor)) {
				$bannerSubHeadingTextColor = ' color: '.$bannerSubHeadingTextColor.'; ';
			}

			if (!empty($bannerCTAColor)) {
				$bannerCTAColor = ' background: '.$bannerCTAColor.'; ';
			}

			if (!empty($bannerCTATextColor)) {
				$bannerCTATextColor = ' color: '.$bannerCTATextColor.'; ';
			}

			if ($addBannerTextShadow) {
				$captionStyle = 'background: transparent url('.Assets\asset_path('images/video-caption-shadow.png').') no-repeat center 36px;';
			}
		?>
		<div class="industry-feature" style="height: <?php echo $bannerHeight; ?>px; background: transparent url(<?php echo $image[0]; ?>) no-repeat center center; background-size: cover;">
	<!--         <div class="background">
				<?php
				// $image = wp_get_attachment_image_src(get_field('intro_page_illustration'), 'full');
				// echo '<img src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" style="min-height: '.$bannerHeight.'px;" />';
				?>
			</div>
	-->        <div class="feature-caption text-center" style="<?php echo $captionStyle; ?>">
				<div class="absolute-center">
					<div class="inner">
						<?php
							if (get_field('title_prefix')):
								echo '<p class="intro-title" style="'.$bannerTextShadow.$bannerTextColor.'">'.get_field('title_prefix').'</p>';
							endif;
						?>
						<h1 style="<?php echo $bannerTextShadow.$bannerTextColor; ?>"><?php the_field('intro_title'); ?></h1>
                        <?php if (get_field('intro_content')): ?>
                        <p class="intro" style="<?php echo $bannerTextShadow.$bannerSubHeadingTextColor; ?> font-size: 22px;"><?php the_field('intro_content'); ?></p>
                        <?php endif; ?>
						<?php
						if (get_field('cta_label')):
							$linkClass = '';
							$linkURL = get_field('cta_url');

							if (strpos(get_field('cta_url'), 'youtube.com') !== false || strpos(get_field('cta_url'), 'vimeo') !== false || strpos(get_field('cta_url'), 'wistia') !== false):
								$linkClass = 'full-videobox';
							endif;

							echo '<a href="'.$linkURL.'" style="'.$bannerCTAColor.$bannerCTATextColor.' padding: 16px; text-transform: uppercase;" class="btn btn-primary btn-lg '.$linkClass.'">'.get_field('cta_label').'</a>';
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
	<?php
	endif;

	if (get_field('page_intro')):
	?>
    <div class="page-intro text-center">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <?php the_field('page_intro'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (get_field('cta_banner_title')): ?>
        <div class="cta-banner text-center">
            <div class="banner-title"><?php the_field('cta_banner_title'); ?></div>
            <div class="banner-button">
                <a href="<?php the_field('cta_banner_button_url'); ?>" class="btn btn-danger"><?php the_field('cta_banner_button_label'); ?></a>
                <?php
                if (get_field('cta_banner_button_icon')):
                    echo '<img src="'.get_field('cta_banner_button_icon').'" alt="'.get_field('cta_banner_title').'" />';
                endif;
                ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (is_page_template('template-fluid-layout.php')): ?>
        <div class="wrap" role="document">
            <div class="content">
                <main class="main" role="main">
                    <?php include Wrapper\template_path(); ?>
                </main><!-- /.main -->
            </div><!-- /.content -->
        </div><!-- /.wrap -->
    <?php elseif (is_page_template('template-fluid-layout-with-subnav.php')): ?>
        <div class="wrap" role="document">
            <div class="container">
                <div class="content row">
                    <main class="main <?php echo Wrapper\roots_main_class(); ?>" role="main">
						<?php if (get_field('intro_title') == ''): ?>
						<div class="page-header">
                            <h2 class="h1"><?php the_title(); ?></h2>
						</div>
						<?php endif; ?>
                        <?php include Wrapper\template_path(); ?>
                        <?php
                        $nextPage = get_field('next_page');
                        if ($nextPage):
                        echo '<div class="next-page text-right"><a href="'.get_permalink($nextPage->ID).'">Next : '.$nextPage->post_title.'</a></div>';
                        endif;
                        ?>
                    </main><!-- /.main -->
                    <?php if (Setup\display_sidebar()) : ?>
                        <aside class="sidebar <?php echo Wrapper\roots_sidebar_class(); ?>" role="complementary">
                            <?php include Wrapper\sidebar_path(); ?>
                        </aside><!-- /.sidebar -->
                    <?php endif; ?>
                </div><!-- /.content -->
            </div>
        </div>
    <?php else: ?>
        <div class="wrap" role="document">
            <div class="content">
                <main class="main" role="main">
                    <?php include Wrapper\template_path(); ?>
                </main><!-- /.main -->
            </div><!-- /.content -->
        </div><!-- /.wrap -->
    <?php endif; ?>
</div>
<?php get_template_part('templates/footer'); ?>
</body>
</html>

<?php
/**
 * @package Wordpress
 * @subpackage Thoughtfarmer
 * Template Name: Multilingual Landing Page
 **/
?>
<?php
use Roots\Sage\Extras;
?>

<div class="row page-intro">
    <div class="col-sm-6">
            <h1 class="mainHeading"><?php the_field('intro_title'); ?></h1>
            <p class="intro"><?php the_field('intro_content'); ?></p>
            <?php the_field('intro_feature'); ?>
    </div>
    <div class="col-sm-6 text-right">
            <?php
                $image = wp_get_attachment_image_src(get_field('intro_page_illustration'), 'full');
                $illustrationURL = $image[0];
                $illustrationTitle = get_field('intro_video_lightbox_caption');

                echo '<a href="'.$illustrationURL.'" class="lightbox" rel="gallery" title=\''.$illustrationTitle.'\'><img src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" class="big shadow alignright illustration" /></a>';

                $gallery = get_field('screenshots');

                if ($gallery):
                    for ($i=0; $i < count($gallery); $i++):
                        $imagefull = wp_get_attachment_image_src($gallery[$i]['screenshot_full'], 'full');
                        echo '<a href="'.$imagefull[0].'" class="lightbox hidden-gallery" rel="gallery" title="'.$gallery[$i]['description'].'"></a>';
                    endfor;
                endif;
            ?>
    </div>
</div>
<div class="row">
	<div class="col-sm-12">
		<h2 class="page-title"><?php _e('Key Features', 'thoughtfarmer'); ?></h2>
		<div class="content-blocks cols2 row">
			<?php
			$counter = 0;
			$blockCounter = 0;
			$numCols = 2;

			while(the_flexible_field('content_blocks')):
				$blockCSSClass = 'col'.$counter;

				echo '<div class="contentBlock  col-sm-6 '.$blockCSSClass.'  top">';
				echo '<div class="row">';
				echo '<div class="col-xs-3">';

					$image_url = wp_get_attachment_image_src(get_sub_field('thumbnail'), 'full');
					echo '<img src="'.$image_url[0].'" width="'.$image_url[1].'" height="'.$image_url[2].'" class="" />';
				echo '</div><div class="col-xs-9">';
				echo '<h3>'.get_sub_field('title').'</h3>';

				if (get_sub_field('content'))
					echo get_sub_field('content');

				echo '</div></div></div>';

				$counter++;
			endwhile;
			?>
		</div>
	</div>
</div>
<div id="homeFooter" class="contentContainer shadowBox container">
    <div class="content">
        <h2 class="page-title"><?php _e('Pricing', 'thoughtfarmer'); ?></h2>
        <div class="pricing-row row">
            <div class="col-sm-3">
                <h3><?php _e('Cloud', 'thoughtfarmer'); ?></h3>
                <p><?php _e("Let us do the work for you. We'll host everything securely in our data centre in London or Vancouver.", 'thoughtfarmer'); ?></p>
            </div>
            <div class="col-sm-9 price-table">
                <div class="table-container euros">
                    <?php Extras\output_cloud_pricing_table(3420); ?>
                </div>
                <div class="table-container canadian jshide">
                    <?php Extras\output_cloud_pricing_table(3418); ?>
                </div>
                <?php
                if ($post->ID == 11088):
                ?>
                <div class="price-tabs text-right">
                    <a href="#euros" class="active"><?php _e('Euros', 'thoughtfarmer'); ?></a> &nbsp; | &nbsp; <a href="#canadian"><?php _e('Canadian Dollar (Québec)', 'thoughtfarmer'); ?></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="pricing-row row">
            <div class="col-sm-3">
                <h3><?php _e('On-Premise', 'thoughtfarmer'); ?></h3>
                <p><?php _e('Host on your own servers and enjoy complete control. Requires Windows Server, SQL Server and Active Directory.', 'thoughtfarmer'); ?></p>
            </div>
            <div class="col-sm-9 price-table">
                <div class="table-container euros">
                    <?php Extras\output_self_hosted_pricing_table(3432); ?>
                </div>
                <div class="table-container canadian jshide">
                    <?php Extras\output_self_hosted_pricing_table(3430); ?>
                </div>
                <?php
                if ($post->ID == 11088):
                ?>
                <div class="price-tabs text-right">
                    <a href="#euros" class="active"><?php _e('Euros', 'thoughtfarmer'); ?></a> &nbsp; | &nbsp; <a href="#canadian"><?php _e('Canadian Dollar (Québec)', 'thoughtfarmer'); ?></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $(window).on('hashchange', function() {
                    setPricingTable();

                    var hash = window.location.hash;

                    if (hash != '' && hash != 'demo') {
                        return false;
                    }
                });

                //setPricingTable();

                function setPricingTable() {
                    var hash = window.location.hash;

                    if (hash != '' && hash != 'demo') {
                        $('.table-container').hide();
                        $('.table-container.' + hash.substring(1)).show();

                        $('.price-table .price-tabs a').removeClass('active');
                        $('.price-table .price-tabs a[href="'+hash+'"]').addClass('active');
                    }
                }
            });
        </script>
        <br/>
        <div class="divider"></div>
        <div class="footerContent">
            <h2 class="page-title"><?php _e('Multilingual', 'thoughtfarmer'); ?></h2>
            <div class="row">
                <div class="col-sm-6">
                    <?php the_field('content_footer_left_col'); ?>
                </div>
                <div class="col-sm-6">
                    <?php the_field('content_footer_right_col'); ?>
                </div>
            </div>
            <div class="clear"></div>
            <br/>
            <div id="demo" class="divider"></div>
            <h2 class="page-title"><?php _e('Request a Live demo', 'thoughtfarmer'); ?></h2>
            <p class="form-intro"><?php _e('form_intro', 'thoughtfarmer'); ?></p>
            <?php echo do_shortcode(get_field('form_embed')); ?>
        </div>
    </div>
</div>

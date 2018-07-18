<?php
/**
 * @package ThoughtFarmer
 * @subpackage Default_Theme
 * Template Name: Cloud Pricing Page
 */
?>
<?php
use Roots\Sage\Extras;

if (have_posts()):
	while (have_posts()):the_post();
        Extras\output_pricing_page_intro('/User/Month* <small>BILLED ANNUALLY</small>');

        the_content();
    ?>
	    <div class="hr"></div>
	    <h3>User-based Pricing</h3>
	    <?php Extras\output_cloud_pricing_table($post->ID); ?>
	    <div class="hr"></div>
<?php
	    Extras\output_pricing_content_blocks();
	endwhile;
endif;
?>

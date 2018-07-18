<?php
/**
 * @package ThoughtFarmer
 * @subpackage Default_Theme
 * Template Name: Self-Hosted Pricing Page
 */
?>
<?php
use Roots\Sage\Extras;
?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php Extras\output_pricing_page_intro('One-Time Fee/User'); ?>
                        <?php
                        the_content();
                        ?>
                        <div class="hr"></div>
                        <h3>User-based Pricing</h3>
                        <?php Extras\output_self_hosted_pricing_table($post->ID); ?>
                        <div class="hr"></div>
                        <?php
                        Extras\output_pricing_content_blocks('self-hosted_pricing_content_blocks');
                        ?>
        <?php endwhile; endif; ?>

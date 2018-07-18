<?php
/**
 * @package Wordpress
 * @subpackage Thoughtfarmer
 * Template Name: Section Main
 **/
?>
<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php Extras\output_page_intro(); ?>
            <?php
                the_content();
                Extras\output_flexible_content_blocks(2, false);
            ?>
<?php endwhile; endif; ?>

<?php
/**
 * @package ThoughtFarmer
 * @subpackage Default_Theme
 * Template Name: Product Feature Page
 */
?>
<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php
        echo '<a href="'.get_permalink($post->post_parent).'" class="backLink">'.get_the_title($post->post_parent).' &gt;</a>';
        Extras\output_page_intro();
    ?>
            <?php
                the_content();
            ?>
            <?php
                Extras\output_flexible_content_blocks(2, false);

                Extras\output_content_footer();
            ?>
<?php endwhile; endif; ?>

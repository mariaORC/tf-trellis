<?php
/**
 * @package ThoughtFarmer
 * @subpackage Thoughtfarmer
 * Template Name: Fluid Width Page Layout w/SubNav
 */
?>
<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php
        the_content();

        //Output 1 column of blocks with no room for a sidebar with alternating content and a fluid layout
        Extras\output_flexible_content_blocks(1, false, true, false);
    ?>
<?php endwhile; endif; ?>
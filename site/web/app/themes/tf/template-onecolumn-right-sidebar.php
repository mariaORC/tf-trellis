<?php
/**
 * @package Wordpress
 * @subpackage Thoughtfarmer
 * Template Name: One column, Right Sidebar
 **/
?>
<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="row">
    <div class="col-sm-<?php echo (get_field('sidebar_size') == 'Large' ? '5' : '8'); ?>">
            <?php
                Extras\output_page_intro();
                the_content();
                Extras\output_flexible_content_blocks(2, false);
            ?>
    </div>
    <div class="right-sidebar col-sm-<?php echo (get_field('sidebar_size') == 'Large' ? '7' : '4'); ?>">
        <div class="inner">
            <?php the_field('sidebar_content'); ?>
        </div>
    </div>
</div>
<?php endwhile; endif; ?>

<?php
/**
 * @package Wordpress
 * @subpackage Thoughtfarmer
 * Template Name: Three column
 **/
?>
<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php Extras\output_page_intro(); ?>
    <div class="row">
        <div class="col-sm-3">
            <?php the_field('left_column'); ?>
        </div>
        <div class="col-sm-6">
                <?php the_content(); ?>
        </div>
        <div class="col-sm-3">
            <?php the_field('right_column'); ?>
        </div>
    </div>
<?php endwhile; endif; ?>

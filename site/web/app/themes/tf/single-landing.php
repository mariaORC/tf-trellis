<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="inner-content">
        <?php
	     Extras\output_page_intro();

        $contentClass = 'col-sm-8';
        $sidebarClass = 'sidebar col-sm-4';

        if (get_field('landing_page_layout') == 'left-sidebar') {
            $contentClass .= ' col-sm-push-4';
            $sidebarClass .= ' col-sm-pull-8';
        }
        ?>
        <div class="row layout-<?php echo get_field('landing_page_layout'); ?>">
            <div class="<?php echo $contentClass; ?>">
                <div class="entry-content">
                    <?php echo do_shortcode(get_field('page_content')); ?>
                </div>
            </div>
            <div class="<?php echo $sidebarClass; ?>">
                <?php echo do_shortcode(get_field('sidebar_content')); ?>
            </div>
        </div>
    </div>
<?php endwhile; endif; ?>

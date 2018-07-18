<?php
/**
 * @package Wordpress
 * @subpackage Thoughtfarmer
 * Template Name: One column, no sidebar
 */
?>
<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php Extras\output_page_intro(); ?>
    <?php
        //the_content();
    ?>
    <?php
        Extras\output_flexible_content_blocks(2, false);
    ?>
<?php endwhile; endif; ?>
<?php if (get_the_ID() == 4969): ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
        _gaq.push(['_trackEvent', 'Form', 'Submit', 'Demo Form: Live Demo']);
        });
    </script>
<?php endif; ?>

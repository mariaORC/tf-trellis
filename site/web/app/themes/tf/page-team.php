<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php Extras\output_page_intro(); ?>
    <?php
        the_content();
    ?>
    <?php Extras\output_people_grid('Leadership', true); ?>
    <br/> <br/>
    <?php Extras\output_people_grid('Team', false); ?>
<?php endwhile; endif; ?>

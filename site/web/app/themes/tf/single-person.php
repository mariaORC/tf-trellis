<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <?php
        $photoID = get_field('photo');

        if ($photoID):
            $thumbnail = wp_get_attachment_image_src($photoID, THUMB_PERSON);

            echo '<img src="'.$thumbnail[0].'" width="'.$thumbnail[1].'" height="'.$thumbnail[2].'" class="alignright thumb" />';
        endif;

    the_content();

    if (get_field('email_address') != ''):
        echo '<a href="mailto:'.get_field('email_address').'" class="button submit"><span>Email</span></a>';
    endif;
    ?>
<?php endwhile; endif; ?>

<?php use Roots\Sage\Extras; ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php Extras\output_page_intro(); ?>
            <?php
                echo '<div class="entry-content">';
                the_content();
                echo '</div>';

                //If we're on the professional services page, we'll output two columns
                Extras\output_flexible_content_blocks(($post->ID == 4608 ? 2 : 1), false);
            ?>
<?php endwhile; endif; ?>

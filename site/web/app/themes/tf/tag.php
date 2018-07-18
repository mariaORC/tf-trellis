<?php
use Roots\Sage\Extras;
?>

<div class="row">
  <div class="col-sm-8">
        <h2 class="entry-title">
            <?php
            printf(__('Posts with tag: &ldquo;%s&rdquo;', 'twentyten'), '<span>' . single_tag_title('', false) . '</span>');
            ?>
        </h4>
        <?php Extras\results_counter(); ?>
        <div class="results">
        <?php
        /* Run the loop for the tag archive to output the posts
         * If you want to overload this in a child theme then include a file
         * called loop-tag.php and that will be used instead.
         */
        get_template_part('loop', 'tag');
        ?>
        </div>
  </div>
  <div class="col-sm-4 right-sidebar">
    <div class="inner">
    <?php
      get_sidebar('blog');
    ?>
    </div>
  </div>
</div>

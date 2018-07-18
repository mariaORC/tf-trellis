<?php use Roots\Sage\Extras; ?>
<div class="row">
  <div class="col-sm-8">
        <h2 class="entry-title">
        <?php
        printf(__('Results for category: &ldquo;%s&rdquo;', 'twentyten'), '<span>' . single_cat_title('', false) . '</span>');
        ?>
        </h2>
        <?php Extras\results_counter(); ?>
        <div class="results">
        <?php
        $category_description = category_description();
        if (!empty($category_description))
            echo '<div class="archive-meta">' . $category_description . '</div>';

        /* Run the loop for the category page to output the posts.
         * If you want to overload this in a child theme then include a file
         * called loop-category.php and that will be used instead.
         */
        get_template_part('loop', 'category');
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

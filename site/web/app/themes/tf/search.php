<?php
use Roots\Sage\Extras;
?>

<!--Begin search.php-->
<div id="mainContent" class="shadowBox blog archive">
    <?php if (have_posts()) : ?>
    <h4 class="entry-title"><?php printf(__('Results for your search: &ldquo;%s&rdquo;', 'roots'), '<span>' . get_search_query() . '</span>'); ?></h4>
    <?php Extras\results_counter(); ?>
    <div class="results">
        <?php
            /* Run the loop for the search to output the results.
             * If you want to overload this in a child theme then include a file
             * called loop-search.php and that will be used instead.
             */
            get_template_part('loop', 'search');
            ?>
    </div>
    <?php else : ?>
    <div id="post-0" class="post no-results not-found">
        <h4 class="entry-title"><?php _e('Nothing Found', 'roots'); ?></h4>
        <div class="entry-content">
            <p>
                <?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'roots'); ?>
            </p>
            <?php get_search_form(); ?>
        </div>
        <!-- .entry-content -->
    </div>
    <!-- #post-0 -->
    <?php endif; ?>
</div>
<!--end Search.php-->

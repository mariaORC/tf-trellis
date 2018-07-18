<?php use Roots\Sage\Extras; ?>
<div class="row">
  <div class="col-sm-8">
    <?php
    /* Queue the first post, that way we know who
     * the author is when we try to get their name,
     * URL, description, avatar, etc.
     *
     * We reset this later so we can run the loop
     * properly with a call to rewind_posts().
     */
    if (have_posts())
        the_post();
    ?>

    <h2 class="entry-title"><?php printf(__('Posts by: &ldquo;%s&rdquo;', 'twentyten'), "<span class='vcard'><a class='url fn n' href='" . get_author_posts_url(get_the_author_meta('ID')) . "' title='" . esc_attr(get_the_author()) . "' rel='me'>" . get_the_author() . "</a></span>"); ?></h2>

    <?php Extras\results_counter(); ?>
    <div class="results">
    <?php
    /* Since we called the_post() above, we need to
     * rewind the loop back to the beginning that way
     * we can run the loop properly, in full.
     */
    rewind_posts();

    /* Run the loop for the author archive page to output the authors posts
     * If you want to overload this in a child theme then include a file
     * called loop-author.php and that will be used instead.
     */
    get_template_part('loop', 'author');
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
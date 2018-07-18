<?php use Roots\Sage\Extras; ?>
<article <?php post_class(); ?>>
  <header>
   <div class="post-category">In: <?php Extras\output_post_category(); ?></div>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php get_template_part('templates/entry-meta'); ?>
  </header>
  <div class="entry-summary">
    <div class="entry-content"><?php the_advanced_excerpt('length=250&no_custom=1&use_words=1&no_shortcode=0&allowed_tags=_all'); ?></div>
     <em><a href="<?php the_permalink(); ?>" class="more">Continue reading...</a></em>
  </div>
</article>

<?php use Roots\Sage\Extras; ?>

<?php while (have_posts()) : the_post(); ?>
   <?php Extras\output_page_intro(); ?>
   <div class="contentContainer clearfix">
      <div class="content twoCol">
         <?php
         the_content();
         ?>
         <?php
         Extras\output_flexible_content_blocks(2, false);

         Extras\output_content_footer();
         ?>
      </div>
   </div>
<?php endwhile; ?>

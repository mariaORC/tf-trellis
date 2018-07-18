<?php
use Roots\Sage\Extras;
?>
<div class="row">
  <div class="col-sm-8">
      <?php get_template_part('templates/content', 'single'); ?>
  </div>
  <div class="col-sm-4 right-sidebar">
    <div class="inner">
    <?php
      get_sidebar('blog');
    ?>
    </div>
  </div>
</div>

<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <script src="//fast.wistia.com/embed/medias/<?php the_field('anniversary_video'); ?>.jsonp" async></script>
    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
    <div class="inner text-center">
	<div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_<?php the_field('anniversary_video'); ?> seo=false videoFoam=true" style="height:100%;width:100%">&nbsp;</div></div></div>
    </div>
<?php endwhile; endif; ?>

<?php
use Roots\Sage\Extras;
?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 text-center">
			<h2 class="dark pad-lg"><?= get_sub_field('section_title'); ?></h2>
			<?php if (get_sub_field('intro')): ?>
				<div class="col-xs-12 col-sm-8 col-sm-offset-2">
					<?= get_sub_field('intro'); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="row featured-posts content-blocks posts-count-<?= count(get_sub_field('featured_posts')); ?>">
		<?php foreach (get_sub_field('featured_posts') as $featuredPost): ?>
		<div class="col col-xs-6 col-sm-4 col-md-3 item">
			<a href="<?= $featuredPost['post']; ?>"><img src="<?= $featuredPost['thumbnail']['url']; ?>" alt="<?= $featuredPost['thumbnail']['title']; ?>" /><span class="hidden-xs"><?= $featuredPost['description']; ?></span></a>
		</div>
		<?php endforeach; ?>
	</div>
</div>
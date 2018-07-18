<?php
use Roots\Sage\Extras;
?>
<div class="container gutter-lg">
	<div class="row">
		<div class="col col-xs-12 text-center">
			<h2 class="dark"><?= get_sub_field('section_title'); ?></h2>
		</div>
	</div>
	<div class="row featured-posts content-blocks">
		<?php
		$featuredPosts = Extras\get_featured_posts(2, 'featured_posts', 'post', get_sub_field('featured_posts'));

		$oldPost = $post;
		foreach ($featuredPosts as $featuredPost):
			setup_postdata($featuredPost);
			$categories = wp_get_post_categories($featuredPost->ID);
			$category = 'Blog';

			if ($categories):
				$category = get_term($categories[0], 'category', false);
				$category = $category->name;
			endif;
		?>
		<div class="col  col-xs-12 col-sm-6 item">
			<span class="label label-success-dark"><?php echo $category; ?></span>
			<h4><a href="<?php echo get_permalink($featuredPost->ID); ?>"><?php echo $featuredPost->post_title; ?></a></h4>
			<p><?php the_advanced_excerpt('length=100&no_custom=0&use_words=0&no_shortcode=1&allowed_tags='); ?></p>
		</div>
		<?php
		endforeach;

		$post = $oldPost;
		wp_reset_postdata();
		?>
		<div class="col col-xs-12 text-center view-more-wrap"><a href="/blog/" class="btn btn-success-dark btn-link">View more posts</a></div>
	</div>
	<div class="row">
	</div>
</div>
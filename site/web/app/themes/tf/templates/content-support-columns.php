<?php use Roots\Sage\Extras; ?>
<div class="wrap support-training" role="document">
	<div class="content-header valign-center support-intro">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 text-center page-intro">
					<?php
						Extras\output_page_intro();
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="content row">
		<main class="main col-sm-8" role="main">
			<?php
			the_content();

			if (get_field('output_cta')):
			?>
			<div class="training-cta">
				<h2><a href="<?php the_field('cta_link'); ?>"><?php the_field('cta_title'); ?></a></h2>
				<?php the_field('cta_content'); ?>
				<p><a class="btn btn-support btn-block" role="button" href="<?php the_field('cta_link'); ?>"><?php the_field('cta_button'); ?></a></p>
			</div>
			<?php endif; ?>
		</main>
		<aside class="sidebar col-sm-4" role="complementary">
			<?php the_field('sidebar_content'); ?>
			<!--after content before webinar-->
			<?php Extras\output_latest_webinar_support(); ?>
		</aside>
		</div>
	</div>
</div>


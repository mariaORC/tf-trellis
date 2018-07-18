<?php
use Roots\Sage\Extras;
?>

<!--start single-case_study.php-->
<?php
if (have_posts()) : while (have_posts()) : the_post();

    $heroStyles = 'min-height: 380px; background: transparent url('.get_field('hero_banner').') no-repeat center center; background-size: cover;';
?>

<div id="case-studies" class="home-feature valign-center" style="<?php echo $heroStyles; ?>">
	<div class="feature-caption text-center">
		<div class="absolute-center">
			<div class="inner">
			<!--start case studies hero-->
			<p class="case-studies-hero-logo"><img src="<?php the_field('logo'); ?>"></p>
			<?php
				if(get_field('intro_content') !='')
				{
					echo'<p class="case-studies-hero-intro hidden-xs hidden-sm">';
					the_field('intro_content');
					echo'</p>';
				}
			?>
			<?php
			if (get_field('intro_video_iframe_code')):
			?>
				<a data-type="iframe" data-fancybox href="https://fast.wistia.net/embed/iframe/<?php the_field('intro_video_iframe_code'); ?>?autoplay=true" class="full-videobox case-study-video-link interview-link">Watch Video</a><br/>
			<?php
			endif;

			if(get_field('case_study_pdf')): ?>
				<a href="<?php the_field('case_study_pdf'); ?>" class="pdf-link btn btn-white text-dark text-uppercase">Download PDF<i class="icon-file-pdf"></i></a>
			<?php
				endif;
			?>
			<?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>
			<!--end case studies hero-->
			</div>
		</div>
	</div>
</div>

<div class="container" role="document">
	<div class="row">
        <?php $mainColWidth = 12; ?>
        <div class="col-sm-12  hidden-xs">
			<div class="case-studies-stats">
		        <?php if( get_field('industry') ): ?><span class="case-studies-stats_item industry">Industry: <?php
					$field = get_field_object('industry');
					$value = get_field('industry')['value'];
					$label = $field['choices'][$value];
					echo($label);
				?></span><?php endif; ?>

				<?php if( get_field('number_of_locations') ): ?><span class="case-studies-stats_item locations">Locations: <?php the_field('number_of_locations'); ?></span><?php endif; ?>
		        <?php if( get_field('number_of_employees') ): ?><span class="case-studies-stats_item employees">Employees: <?php the_field('number_of_employees'); ?></span><?php endif; ?>
	        </div>
		</div>
        <div class="col-lg-8 col-md-9 col-md-offset-2 col-sm-12">

            <div class="entry-content"><?php the_content(); ?></div>
            <div class="related-studies row hidden-xs">

	            <?php

				$industry = get_field('industry')['value'];

				// args
				$args = array(
					'posts_per_page' => 2,
					'post__not_in' => array($post->ID),
					'post_type' => 'case_study',
					'meta_key' => 'industry',
					'meta_value' => $industry
				);

				// query
				$the_query = new WP_Query( $args );

				?>


				<div class="col-sm-12"><h2>Related Case Studies</h2></div>
				<?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<div class="element-item contentBlock col-sm-4">
					<a href="<?php the_permalink(); ?>">
					<div class="contentBlockInner" style="background-image: url(<?php if( get_field('tile_image')) {the_field('tile_image');} else {the_field('logo_feature_image');} ?>); background-size: cover;">
						<div class="absolute-center">
							<img src="<?php the_field('logo'); ?>">
			            </div>
		            </div>
		           	</a>
	            </div>
				<?php endwhile; ?>
				<?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>

            	<div class="element-item contentBlock col-sm-4">
	            	<a href="/demo/">
					<div class="contentBlockInner case-study-cta">
						<div class="absolute-center">
							<p>Your Brand Here</p>
			           	</div>
		            </div>
		            </a>
	            </div>
	            <div class="col-sm-12 prev-page"><a href="/case-studies/" class="btn btn-success-dark btn-outline">Back</a></div>
            </div>
        </div>
	</div>
</div>
<?php endwhile; endif; ?>
<!--end single-case_study.php-->

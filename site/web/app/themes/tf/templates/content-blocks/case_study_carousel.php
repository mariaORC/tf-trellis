<?php
use Roots\Sage\Extras;
?>
<div class="related-studies content-blocks equalize-item-heights">
	<div class="carousel" data-flickity='{ "cellAlign": "left", "wrapAround": true, "pageDots": false }'>
	<?php
        //Get three case studies. They'll either be user defined or automatically selected.
        $featuredCaseStudies = Extras\get_featured_posts(6, 'featured_case_studies', 'case_study', $block, get_sub_field('featured_case_studies'));

        $oldPost = $post;

        foreach ($featuredCaseStudies as $caseStudy):
            setup_postdata($caseStudy);
            $industry = get_field('industry', $caseStudy->ID)['label'];
		?>
			<div class="carousel-cell element-item contentBlock col-xs-12 col-sm-6 col-md-4 col-lg-3 <?php echo $industry ?>">
				<div class="cell-inner">
					<a href="<?php echo get_permalink($caseStudy->ID); ?>" class="item inner">
						<div class="contentBlockInner" style="background-image: url(<?php if( get_field('tile_image', $caseStudy->ID)) {the_field('tile_image', $caseStudy->ID);} else {the_field('logo_feature_image', $caseStudy->ID);} ?>); background-size: cover;">
							<div class="absolute-center">
								<img src="<?php the_field('logo', $caseStudy->ID); ?>" alt="<?php $post->post_title; ?> Logo" />
							</div>
						</div>
						<div class="title text-lite"><?= $caseStudy->post_title; ?></div>
						<?php echo $caseStudy->post_excerpt; ?>
					</a>
				</div>
            </div>
        <?php
        endforeach;

        $post = $oldPost;
        wp_reset_postdata();
	?>
	</div>
</div>
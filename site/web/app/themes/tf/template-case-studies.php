<?php
/**
 * @package Wordpress
 * @subpackage Thoughtfarmer
 * Template Name: Case Studies Page
 **/
?>
<?php
use Roots\Sage\Extras;
?>

<!--start template-case-studies-->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
// args
$args = array(
    'numberposts'   => '1',
    'post_type'     => 'case_study',
    'meta_key'      => 'case_studies_hero',
    'meta_value'    => '1'
);
// query
$the_query = new WP_Query( $args );
?>

<?php
$heroStyles = '';

if( $the_query->have_posts() ):
    while( $the_query->have_posts() ) : $the_query->the_post();
        $heroStyles = 'min-height: 440px; background: transparent url('.get_field('hero_banner').') no-repeat center center; background-size: cover;';
    endwhile;
endif;
?>

<div id="case-studies" class="home-feature valign-center" style="<?php echo $heroStyles; ?>">
	<div class="feature-caption text-center">
		<div class="absolute-center">
			<div class="inner">
			<!--start case studies hero-->
			<?php if( $the_query->have_posts() ): ?>
				<?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<p class="case-studies-hero-logo"><img src="<?php the_field('logo'); ?>"></p>
					<?php
						if( get_field('intro_content') !='')
						{
							echo'<p class="case-studies-hero-intro hidden-xs hidden-sm">';
							the_field('intro_content');
							echo'</p>';
						}
					?>
					<p class="case-studies-hero-button"><a href="<?php the_permalink(); ?>">See how we helped <?php the_title(); ?></a></p>
				<?php endwhile; ?>
			<?php endif; ?>
			<?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>
			<!--end case studies hero-->
			</div>
		</div>
	</div>
</div>
<div class="wrap container" role="document">
	<div class="content row">
		<main class="main col-sm-12" role="main">
		<div id="case-study-landing" class="row">
		<!--start industry select-->
	    	<div id="industry-select" class="col-sm-12">
    		      <h2 class="industry-select-title">Choose your industry:</h2>
		    <?php
			$field_key = "field_5654b70ee8db7"; //Case Study Industry Field ID
			$field = get_field_object($field_key);
			ksort($field['choices']);

			if($field)
			{
            ?>
			<!-- Single button -->
			<div class="btn-group industry-filter">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-thin-chevron-down"></i><span>All Industries</span></button>
				<ul class="dropdown-menu">
			<?php
			// echo '<select class="button-group sort-by-select-group" name="' . $field['key'] . '">';
			echo '<li class="option-all"><a href="#all">All Industries</a></li>';
			foreach( $field['choices'] as $k => $v )
			{
							echo '<li class="option-'.$k.'"><a href="#' . $k . '" value="' . $k . '">' . $v . '</a></li>';
			//echo '<option value="' . $k . '">' . $v . '</option>';
			}
			//echo '</select>';
			?>
				</ul>
			</div>
			<?php
			}
		    ?>
<?php //				<span class="industry-select-clear"><a href="#" class="clear-filter">Clear filter</a></span> ?>
			</p>
	    	</div>
			<!--end industry select-->
			<div class="col-sm-12">
            	<div class="section-intro">
				<?php
				the_field('case_studies_intro');
	            query_posts('post_type=case_study&orderby=menu_order&order=ASC&posts_per_page=99');
	            $count = 1;
	            $itemCount = 0;
	            echo '</div><div class="grid row content-blocks">';
	            while (have_posts()) : the_post();

	            if ($itemCount == 4):
	            	$industries = '';

	            	foreach( $field['choices'] as $k => $v ):
	            		$industries .= $k.' ';
	            	endforeach;
	            	?>
			<div class="element-item contentBlock sign-up col-xs-12 col-sm-4 col-md-3 placeholder">
				<a href="/demo/">
					<div class="contentBlockInner">
						<div class="absolute-center">Your Brand Here</div>
					</div>
				</a>
			</div>
			<?php
	            endif;
	            ?>
	            <?php $industry = get_field('industry')['value']; ?>
            	<div class="element-item contentBlock <?php if( get_field('double_wide') ) {echo "col-xs-12 col-sm-8 col-md-6";}  else {echo "col-xs-12 col-sm-4 col-md-3";} ?>  <?php echo $industry ?>">
	            	<a href="<?php the_permalink(); ?>">
		            <div class="contentBlockInner" style="background-image: url(<?php if( get_field('tile_image')) {the_field('tile_image');} else {the_field('logo_feature_image');} ?>); background-size: cover;">
			            <div class="absolute-center"><img src="<?php the_field('logo'); ?>">
		                <?php if( get_field('double_wide') ): ?> <?php {echo "<p class=\"hidden-xs\">"; the_advanced_excerpt('length=150&no_custom=0&use_words=0&no_shortcode=1&exclude_tags=_all'); echo "</p>";} ?><?php endif; ?>
			            </div>
		            </div>
		            </a>
	            </div>
	            <?php
			$count++;
			if ($count > 2):
				$count = 1;
			endif;

			$itemCount++;
	            endwhile;
	            ?>
			<div class="element-item contentBlock sign-up col-xs-12 col-sm-4 col-md-3 <?php echo $industries; ?> hide-initially">
				<a href="/demo/">
					<div class="contentBlockInner">
						<div class="absolute-center">Your Brand Here</div>
					</div>
				</a>
			</div>
		   <?php
	            echo '</div>';
	            wp_reset_query();
	            ?>
	            <div class="clearfix"></div>
				<?php get_template_part('templates/client', 'logos'); ?>
	</div>
        </div>
	<?php endwhile; endif; ?>
	</main><!-- /.main -->
</div><!-- /.content -->
</div><!-- /.wrap -->
<!--end template-case-studies-->




<?php use Roots\Sage\Extras; ?>
<div class="wrap" role="document">
	<div class="content-header valign-center">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 text-center">
					<?php Extras\output_page_intro(); ?>
					<form class="searchform" method="get" action="/support/search/">
						<div class="search-input">
							<button type="submit" name="search" value="" class="searchButton"><i class="icon-search"></i></button>
							<input type="text" name="addsearch" id="s" class="search-field form-control" placeholder="I need help with..." />
							<input type="hidden" name="site" value="documentation" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="container support-promise">
		<div class="content row">
    		<div class="col-sm-8 col-sm-offset-2 col-xs-12 support-intro">
        		<?php
        		the_content();
        		?>
    		</div>
		</div>
    </div>
    <div id="support-docs" class="support-documentation">
        <div class="container">
            <div class="content row">
                <div class="col-sm-12">
                    <h1><?php the_field('documentation_heading'); ?></h1>

                    <!-- Nav tabs -->
                    <?php $docs = get_field('documentation_sections'); ?>

                    <ul class="support-tabs" role="tablist">
                    <?php if( have_rows('documentation_sections') ): $iCount=0; ?>
                        <?php while( have_rows('documentation_sections') ): the_row(); ?>
                            <?php echo '<li class="'.($iCount == 0 ? 'active' : '').'"><a href="#'.sanitize_title(get_sub_field('documentation_title')).'" role="tab" data-key="'.$iCount.'" data-toggle="tab">'; ?> <?php the_sub_field('documentation_title'); ?> </a></li>
                        <?php $iCount++; ?>
                    	<?php endwhile; ?>
                    <?php endif; ?>
                    </ul>

                    <?php if( have_rows('documentation_sections') ): $iCount=0; ?>
                    	<div class="tab-content">
                    	<?php while( have_rows('documentation_sections') ): the_row(); ?>
                    		<?php echo '<div class="tab-pane '.($iCount == 0 ? 'active' : '').'" id="'.sanitize_title(get_sub_field('documentation_title')).'">'; ?>
                    		    <div class="col-sm-8 col-sm-offset-2 col-xs-12 support-intro">
            			<h2><?php the_sub_field('documentation_title'); ?></h2>
            			<p><?php the_sub_field('documentation_subtitle'); ?></p>
                    		    </div>
                    			<?php if( have_rows('documentation_tile') ): ?>
                    				<div class="support-wrapper">
                    					<?php while( have_rows('documentation_tile') ): the_row(); ?>
                    					<div class="support-tile-wrapper">
                    					    <a href="<?php the_sub_field('documentation_tile_link'); ?>">
                    						<div class="support-tile">
                        						<div class="support-tile-image"><img src="<?php the_sub_field('documentation_tile_image'); ?>" /></div>
                    							<h4><?php the_sub_field('documentation_tile_header'); ?></h4>
                    							<p><?php the_sub_field('documentation_tile_body'); ?></p>
                    						</div>
                    					    </a>
                    					</div>
                    					<?php endwhile; ?>
                    				</div>
                    				<a class="btn btn-support" role="button" href="<?php the_sub_field('documentation_learn_more_link'); ?>">Learn More</a>
                    			<?php endif; ?>
                    		</div>
                    		<?php $iCount++; ?>
                    	<?php endwhile; ?>
                    	</div>

                    <?php endif; ?>



                </div>
            </div>
            <hr id="support-helpdesk" />
            <div class="content row">
                <div class="col-sm-8 col-sm-offset-2 col-xs-12 support-intro">
                    <h3><?php the_field('helpdesk_header'); ?></h3>
                    <p><?php the_field('helpdesk_intro'); ?></p>
                </div>


                <?php if( have_rows('helpdesk_section') ): $iCount=10; ?>
                <div class="helpdesk-wrapper">
                    <?php while( have_rows('helpdesk_section') ): the_row(); ?>
                        <?php echo '<div class="helpdesk-tile-wrapper '.($iCount == 0 ? 'active' : '').'">  <a href="#tab'.$iCount.'" role="tab" data-key="'.$iCount.'" data-toggle="tab">'; ?>
                            <div class="support-tile-image"><img src="<?php the_sub_field('helpdesk_section_image'); ?>" /></div>
                            <h4><?php the_sub_field('helpdesk_section_header'); ?> </h4>
                            <p><?php the_sub_field('helpdesk_section_body'); ?> </p>
                        </a></div>

                    <?php $iCount++; ?>
                	<?php endwhile; ?>
                </div>
                <?php endif; ?>

                <?php if( have_rows('helpdesk_section') ): $iCount=10; ?>
                	<div class="tab-content helpdesk-tab-content">
                	<?php while( have_rows('helpdesk_section') ): the_row(); ?>
                		<?php echo '<div class="helpdesk-pane tab-pane '.($iCount == 0 ? 'active' : '').'" id="tab'.$iCount.'">'; ?>
                            <p><?php the_sub_field('helpdesk_section_tile'); ?></p>
                		</div>
                		<?php $iCount++; ?>
                	<?php endwhile; ?>
                	</div>
                <?php endif; ?>

                <script>
                jQuery(document).ready(function($) {
                    $('.helpdesk-tile-wrapper  a').click(function() {
                        $('div.helpdesk-tile-wrapper').removeClass('active').addClass('not-active');
                        $(this).closest('div').removeClass('not-active').addClass('active');
                    });
                });
                </script>
                <script>
                //smooth scroll for sub
                jQuery(document).ready(function($) {
                	$('a[href^="/support/#"]').on('click',function (e) {
                	    e.preventDefault();

                	    var target = this.hash;
                	    var $target = $(target);

                	    $('html, body').stop().animate({
                	        'scrollTop': $target.offset().top
                	    }, 500, 'swing', function () {
                	        window.location.hash = target;
                	    });
                	});
                });
                </script>

            </div>
        </div>
    </div>
    <div id="support-training">
        <div class="container">
            <div class="content row">
                <div class="col-sm-8 col-sm-offset-2 col-xs-12 support-intro">
                    <h3><?php the_field('training_header'); ?></h3>
                    <p><?php the_field('training_body'); ?></p>
                    <a class="btn btn-support" role="button" href="<?php the_field('training_learn_more_link'); ?>">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</div>



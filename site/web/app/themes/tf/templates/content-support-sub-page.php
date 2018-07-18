<div class="wrap" role="document">
	<div class="content-header valign-center support-intro">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 text-center page-intro">
					<h1><?php the_title(); ?></h1>
					<?php
					the_content();
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="container support-promise">
        <div class="content row help-desk-section text-left">
           <div class="col-sm-3 col-sm-offset-1 col-xs-12">
               <img src="<?php echo get_field('header_icon')['url']; ?>" alt="<?php the_field('header_title'); ?>" />
           </div>
           <div class="col-sm-8 col-xs-12">
                <h2><?php the_field('header_title'); ?></h2>
                <?php the_field('header_body'); ?>
           </div>
        </div>
    </div>
    <div id="support-docs" class="support-documentation">
        <div class="container">
            <div class="content row get-in-touch-intro">
                <div class="col-sm-8 col-sm-offset-2 col-xs-12">
                    <img src="<?php echo get_field('get_in_touch_icon')['url']; ?>" alt="<?php the_field('get_in_touch_title'); ?>" />
                    <h2><?php the_field('get_in_touch_title'); ?></h2>
                    <?php the_field('get_in_touch_intro'); ?>
                </div>
            </div>
            <div class="content row">
                <?php if( have_rows('get_in_touch_section') ): $iCount=10; ?>
                <div class="helpdesk-wrapper">
                    <?php while( have_rows('get_in_touch_section') ): the_row(); ?>
                        <?php echo '<div class="helpdesk-tile-wrapper '.($iCount == 0 ? 'active' : '').'"> '; ?>
                            <div class="support-tile-image"><img src="<?php the_sub_field('section_image'); ?>" alt="<?php the_sub_field('section_header'); ?>" /></div>
                            <h4><?php the_sub_field('section_header'); ?> </h4>
                            <?php the_sub_field('section_body'); ?>
                        </div>

                    <?php $iCount++; ?>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
        <div class="container support-promise">
            <div class="content row help-desk-section text-left">
               <div class="col-sm-3 col-sm-offset-1 col-xs-12">
                   <img src="<?php echo get_field('footer_icon')['url']; ?>" alt="<?php the_field('footer_title'); ?>" />
               </div>
               <div class="col-sm-8 col-xs-12">
                    <h2><?php the_field('footer_title'); ?></h2>
                    <?php the_field('footer_body'); ?>
               </div>
            </div>
        </div>
</div>



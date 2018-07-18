<?php
/**
 * @package Wordpress
 * @subpackage Thoughtfarmer
 * Template Name: Support Home Page
 **/
?>
<?php
use Roots\Sage\Extras;
?>
<div class="wrap" role="document">
	<div class="content-header valign-center">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 text-center">
					<h1 class="mainHeading "><?php the_title(); ?></h1>
					<form class="searchform" method="get" action="/support/search/">
						<div class="search-input">
							<button type="submit" name="search" value="" class="searchButton"><i class="icon-search"></i></button>
							<input type="text" name="addsearch" id="s" class="search-field form-control" placeholder="I need help with..." />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    <div id="support-docs" class="support-documentation">
        <div class="container">
            <div class="content row">
                <?php if( have_rows('helpdesk_section') ): $iCount=10; ?>
                <div class="helpdesk-wrapper">
                    <?php while( have_rows('helpdesk_section') ): the_row(); ?>
                        <?php echo '<div class="helpdesk-tile-wrapper '.($iCount == 0 ? 'active' : '').'">  <a href="'.get_sub_field('link_to').'">'; ?>
                            <div class="support-tile-image"><img src="<?php the_sub_field('helpdesk_section_image'); ?>" /></div>
                            <h4><?php the_sub_field('helpdesk_section_header'); ?> </h4>
                            <p><?php the_sub_field('helpdesk_section_body'); ?> </p>
                        </a></div>

                    <?php $iCount++; ?>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container support-promise">
        <div class="content row">
                <div class="col-sm-8 col-sm-offset-2 col-xs-12 support-intro">
                    <?php the_content(); ?>
                </div>
        </div>
    </div>
</div>

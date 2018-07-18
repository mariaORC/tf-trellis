<!--begin support-footer-->
<?php
use Roots\Sage\Extras;

if (!Extras\post_is_landing_page() && !get_field('hide_footer_ctas')):
?>
<?php
    //ensure this is the page id of the support page
    $support_page = (get_current_blog_id() == 8 ? 2 : 17702);
?>
<div class="support-section">
    <div class="footer_wrap clearfix">
    	<footer class="container">
    		<div class="row">
    			<div class="col-sm-8 clearfix footer-left-nav">
        			<h2>ThoughtFarmer Support </h2>
        			<div class="col-sm-6">
						<?php if( have_rows('documentation_sections', $support_page) ): ?>
						<h5><a href="<?= get_site_url(8); ?>">Documentation</a></h5>
						<ul class="footer-left-links">
							<li><a href="<?= get_site_url(8); ?>/documentation/15653/using-thoughtfarmer/">Using ThoughtFarmer</a></li>
							<li><a href="<?= get_site_url(8); ?>/documentation/15450/administration/">Administration</a></li>
							<li><a href="<?= get_site_url(2); ?>/blog/social-intranet-superstar/">Adoption and Engagement</a></li>
							<li><a href="<?= get_site_url(8); ?>/documentation/15745/extending-thoughtfarmer/">Versions &amp; Extending</a></li>
						</ul>
						<?php endif; ?>
        			</div>
        			<div class="col-sm-6">
            			<h5><a href="https://thoughtfarmer.zendesk.com">Helpdesk</a></h5>
            			<ul class="footer-left-links">
            			<li><a href="mailto:helpdesk@thoughtfarmer.com">Contact Support Team</a></li>
                        <li><a href="<?= get_site_url(8); ?>/documentation/15434/emergency-troubleshooting-tips/">Emergency Troubleshooting Guide</a></li>
            			</ul>
                        <h5><a href="<?= get_site_url(2); ?>/support/training/">Training</a></h5>
                        <h5><a href="<?= get_site_url(2); ?>/support/versions/">Version History</a></h5>
        			</div>

    			</div>
    			<div class="col-sm-4 footer-right">
    				<?php
    					if (has_nav_menu('primary')) :
    						wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'support-nav', 'depth' => 1));
    					endif;

						if (has_nav_menu('support')) :
							wp_nav_menu(array('theme_location' => 'support', 'menu_class' => 'support-nav', 'depth' => 1));
						endif;
    				?>
    				<?php
    				// $menu_items = wp_get_nav_menu_items(136);

        //                                         if ($menu_items):
        //                                             $navItems = array();

        //                                             echo '<ul class="support-nav">';
        //     				foreach ($menu_items as $menuItem):
        //     					$navItems[] = '<li><a href="'.$menuItem->url.'">'.$menuItem->title.'</a></li>';

        //     				endforeach;

        //     				echo implode($navItems);
        //     				echo '</ul">';
        //                                         endif;
        			         ?>
    			</div>
    		</div>
    	</footer>
    </div>
    <?php endif; ?>
    <div class="copyright_wrap clearfix">
    	<div class="container">
    		<div class="row">
    			<div class="col-sm-12 copyright">
        			<p><?php echo	'<a href="'.home_url('/').'" class="logo"><img src="'.Roots\Sage\Assets\asset_path('images/thoughtfarmer-logo-footer-support.png').'" alt="'.get_bloginfo('name').'"  /></a>' ?></p>
    				<p><?php _e('ThoughtFarmer, a product of <a href="https://www.openroad.ca">OpenRoad</a>.', 'thoughtfarmer'); ?></p> <p>&copy;<?php echo date('Y'); ?> <?php _e('OpenRoad Communications Ltd. All rights reserved.', 'thoughtfarmer'); ?></p>
    			</div>
    		</div>
    	</div>
    </div>
</div>
<?php
if (get_current_blog_id() == 2):
?>
<div class="wistia-video-modal demo-video-modal">
	<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js" async></script>
	<div class="wistia_responsive_padding" style="padding:0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;">
	<div class="wistia_embed wistia_async_384njyhp2o videoFoam=true" style="height:100%;width:100%">&nbsp;</div>
	</div></div>
	<button class="close_video btn btn-link btn-lg glyphicon glyphicon-remove-circle"></button>
</div>
<script>
	jQuery(document).ready(function($) {
		//Get a handle to the wistia video.
		window._wq = window._wq || [];
		_wq.push({ "384njyhp2o": function(video) {
			$('.home-feature .tour-button, .play-demo').click(function(e) {
				video.width(640);
				video.width($(window).width(), { constrain: true });
				video.play();
				$('.demo-video-modal').addClass('video-play');
				$('body').addClass('modal-open');
				$('.close_video').show();
				window.location.hash = 'demo';
				e.preventDefault();
			});

			$('.wistia_responsive_wrapper, .demo-video-modal, .demo-video-modal .close_video').click(function(e) {
				if(e.target == this) {
					video.pause();
					$('.demo-video-modal').removeClass('video-play');
					$('body').removeClass('modal-open');
					$('.close_video').hide();
					e.preventDefault();
				}
			});

			if(window.location.hash === '#demo') {
				$('.play-demo').trigger('click');
			}

		}});
	});
</script>
<!--end support-footer-->
<?php endif; ?>
<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/2980774.js"></script>
<!-- End of HubSpot Embed Code -->
<?php wp_footer(); ?>

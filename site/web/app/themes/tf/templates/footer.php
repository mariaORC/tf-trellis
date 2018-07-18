<?php
use Roots\Sage\Extras;
use Roots\Sage\Assets;

if (!Extras\post_is_landing_page() && !get_field('hide_footer_ctas')):
    if (!get_field('hide_cta_block')):
        ?>
        <div class="cta_wrap text-center">
        	<?php //if (!get_field('hide_ctas') && !is_page_template('template-cloud-pricing.php') && !is_page_template('template-self-hosted-pricing.php' ) && !in_array($post->ID, array(557)) && !in_array($post->parent, array(557)) && strpos($_SERVER['REQUEST_URI'], 'documentation') === false): ?>
        		<div id="ctas" class="<?php echo $ctaClass; ?>">
					<a href="/demo/" id="request-demo-footer-cta" class="btn btn-success-dark btn-outline">Request Demo</a>
					<a href="/engage/free-trial/" id="free-trial-footer-cta" class="btn btn-danger play-demo">Free Trial</a>
					<?php
					$contactCTALabel = 'Not ready? Learn more';

					if (get_field('footer_ctas_more_help_link_label')):
						$contactCTALabel = get_field('footer_ctas_more_help_link_label');
					endif;
					?>
					<a href="/about/contact-us/" id="contact-us-footer-cta" class="btn btn-default btn-link"><?= $contactCTALabel; ?></a>
        		</div>
        </div>
    <?php endif; ?>
<div class="footer_wrap clearfix">
	<footer class="container-fluid limit">
		<div class="row">
         <div class="col-xs-12 col-sm-3 footer-left text-center-xs">
            <p><img src="<?= Assets\asset_path('images/where-teams-ideas-grow.png'); ?>" alt="Where Teams Ideas Grow" width="260" /></p>
            <p class="illustration"><img src="<?= Assets\asset_path('images/flower-and-bees.png'); ?>" alt="Flowers & Bees" width="174" /></p>
            <p>Intranet software designed &amp; built with <i class="icon-heart text-danger"></i> in Vancouver</p>
         </div>
			<div class="col-xs-12 col-sm-6 footer-middle clearfix">
				<?php
					$nav = wp_nav_menu( array('container' => '', 'menu_class' => 'footer-nav', 'depth' => '2', 'theme_location' => 'footer'));
				?>
			</div>
			<div class="col-xs-12 col-sm-3 footer-right">
				<div class="social">
					<h6>Keep In Touch</h6>
					<div class="row phone-numbers visible-xs">
						<div class="col-xs-6">
							<p><span class="phoneNumbers"><strong><?php _e('North America', 'thoughtfarmer'); ?></strong><br/>1-888-694-3999</span></p>
						</div>
						<div class="col-xs-6">
							<p><span class="phoneNumbers"><strong><?php _e('International', 'thoughtfarmer'); ?></strong><br/>+1 604-566-8300</span></p>
						</div>
					</div>
					<a href="https://www.facebook.com/thoughtfarmer" class="sprite social-sprite facebook"><i class="icon-facebook"></i></a>
					<a href="http://www.twitter.com/thoughtfarmer/" class="sprite social-sprite twitter"><i class="icon-twitter"></i></a>
					<a href="http://www.linkedin.com/company/thoughtfarmer" class="sprite social-sprite linkedin"><i class="icon-linkedin"></i></a>
					<a href="http://www.youtube.com/thoughtfarmer" class="sprite social-sprite youtube"><i class="icon-youtube"></i></a>
				</div>
				<div id="newsletterSignup">
					<div class="content">
						<p>
                     <strong>Straight into your inbox</strong><br/>
                     Sign up to receive a newsletter on how to engage employees and improve communications with your intranet.
                  </p>
						<div class="hubspot-form">
							<?php echo do_shortcode('[HubspotForm id="65a3588f-0d97-45b7-892b-021e4e8d097e"]'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>
<?php endif; ?>
<div class="copyright_wrap clearfix">
	<div class="container-fluid limit">
		<div class="row">
         <div class="col-xs-12"><hr /></div>
			<div class="col-xs-12 col-md-6 col-md-push-3 copyright text-center">
				<?php _e('ThoughtFarmer, a product of <a href="http://www.openroad.ca">OpenRoad</a> &copy;'.date('Y').' OpenRoad Communications Ltd. All rights reserved.', 'thoughtfarmer'); ?>
			</div>
         <div class="col-xs-12 col-sm-7 col-md-3 col-md-pull-6 copyright-nav text-center-xs">
            <?php _e('<a href="/de/">Deutsch</a> <a href="/nl/">Nederlands</a> <a href="/fr/">Français</a>', 'thoughtfarmer'); ?>
         </div>
			<div class="col-xs-12 col-sm-5 col-md-3 copyright-nav text-right text-center-xs">
				<a href="/privacy-policy/"><?php _e('Privacy policy', 'thoughtfarmer'); ?></a> <a href="/about/contact-us/"><?php _e('Contact us', 'thoughtfarmer'); ?></a>
			</div>
		</div>
	</div>
</div>
<a data-type="iframe" href="https://fast.wistia.net/embed/iframe/384njyhp2o?autoplay=true" data-fancybox class="full-videobox demo-video-modal hidden"></a>

<?php if (get_the_ID() == 4969): ?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        _gaq.push(['_trackEvent', 'Form', 'Submit', 'Demo Form: Live Demo']);
    });
</script>
<?php
endif;

if ($post->ID == 557):
	echo '<script src="https://www.surveymonkey.com/jsPop.aspx?sm=S4M6reU_2b6UNhWkRb_2fA2Lpw_3d_3d"></script>';
endif;
?>
<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/2980774.js"></script>
<!-- End of HubSpot Embed Code -->
<?php wp_footer(); ?>

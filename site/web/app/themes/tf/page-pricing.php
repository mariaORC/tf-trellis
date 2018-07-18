<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php Extras\output_page_intro(); ?>
<?php
    the_content();
?>
<div id="pricingOptions" class="clearfix">
    <div class="col-sm-6 pricing-intro text-center">
        <h2><a href="/pricing/us-cloud-pricing">Cloud</a></h2>
        <div class="text-center"><a href="/pricing/us-cloud-pricing"><img src="<?php echo Roots\Sage\Assets\asset_path('images/illustrations/pricing-cloud.png'); ?>" /></a></div>
        <p><?php the_field('cloud_pricing_intro'); ?></p>
        <a href="/pricing/us-cloud-pricing" class="btn btn-success-dark btn-outline cloud"><span>Cloud Details</span></a>
    </div>
    <div class="col-sm-6 pricing-intro text-center">
        <h2><a href="/pricing/us-on-premise-pricing">On-Premise</a></h2>
        <div class="text-center"><a href="/pricing/us-on-premise-pricing"><img src="<?php echo Roots\Sage\Assets\asset_path('images/illustrations/pricing-on-premise.png'); ?>" /></a></div>
        <p><?php the_field('self-hosted_pricing_intro'); ?></p>
        <a href="/pricing/us-on-premise-pricing" class="btn btn-success-dark btn-outline selfHosted"><span>On-Premise Details</span></a>
    </div>
</div>

<?php
    Extras\output_flexible_content_blocks(2, false);
?>
<?php endwhile; endif; ?>

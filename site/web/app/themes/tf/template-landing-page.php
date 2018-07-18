<?php
/**
 * @package Wordpress
 * @subpackage Thoughtfarmer
 * Template Name: Landing Page
 **/
?>
<?php
use Roots\Sage\Extras;
?>

        <div class="featureWrapper">
            <div class="container">
                <div class="feature home">
                    <h1><?php the_field('intro_title'); ?></h1>
                    <p class="intro"><?php the_field('intro_content'); ?></p>
                    <div class="landing-form alignright">
                        <?php echo do_shortcode('[wufoo username="thoughtfarmer" formhash="q7p0k5" autoresize="true" height="262" header="show" ssl="false"]'); ?>
                    </div>
                    <?php
                        //Un-comment when we enable the video again.
                        $image = wp_get_attachment_image_src(get_field('intro_page_illustration'), 'full');
                        $gallery = get_field('header_photo_gallery');
                        $illustrationURL = $image[0];
                        $illustrationTitle = get_field('intro_video_lightbox_caption');

                        if (!empty($gallery)):
                            $illustrationURL = $gallery[0]['image'];
                            $illustrationTitle = $gallery[0]['description'];
                        endif;

                        echo '<a href="'.$illustrationURL.'" class="lightbox" onClick="_gaq.push([\'_trackEvent\', \'CPC Landing Page\', \'Click\', \'Screenshots\'])" rel="gallery" title=\''.$illustrationTitle.'\'><img src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" class="big" /></a>';

                        if (count($gallery) > 1):
                            for ($i=1; $i < count($gallery); $i++):
                                echo '<a href="'.$gallery[$i]['image'].'" class="lightbox" rel="gallery" title="'.$gallery[$i]['description'].'"></a>';
                            endfor;
                        endif;
                    ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php Extras\output_homepage_client_logos(); ?>
        <div id="landingContent" class="shadowBox container sub oneCol noNav">
            <div id="mainContent">
                <div class="contentContainer clearfix">
                    <div class="content oneCol">
                        <?php Extras\output_flexible_content_blocks(3, false); ?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php Extras\output_homepage_quotes(); ?>
        <div class="clear"></div>
        <div class="container clearfix">
            <?php /*<div id="publications">
                <?php the_field('publication_logos'); ?>
            </div>*/ ?>
            <div class="footer divider top"></div>
            <div id="footerNav" class="grid_21">
                <ul class="styledList">
                    <li><a href="/product/">Product</a></li>
                    <li><a href="/clients/">Clients</a></li>
                    <li><a href="/pricing/">Pricing</a></li>
                    <li><a href="/intranets-101/">Intranets 101</a></li>
                    <li><a href="/demo/">Demo</a></li>
                </ul>
            </div>
            <div id="socialLinks" class="grid_3">
                <a href="https://www.facebook.com/thoughtfarmer" class="sprite social-sprite facebook">Like us on Facebook</a>
                <a href="http://www.twitter.com/thoughtfarmer/" class="sprite social-sprite twitter">Follow us on Twitter</a>
                <a href="http://www.linkedin.com/company/thoughtfarmer" class="sprite social-sprite linkedin">Connect on LinkedIn</a>
                <a href="http://www.youtube.com/thoughtfarmer" class="sprite social-sprite youtube">Watch us on Youtube</a>
            </div>
            <div class="clear"></div>
            <div class="footer divider bottom"></div>
            <div id="copyright" class="grid_20">ThoughtFarmer, a product of <a href="http://www.openroad.ca">OpenRoad</a>. &copy; <?php echo date('Y'); ?> OpenRoad Communications Ltd. All right reserved.</div>
            <div class="copyright-nav grid_4"><a href="/privacy-policy/">Privacy</a> &nbsp; | &nbsp; <a href="/about/contact-us/">Contact</a></div>
        </div>
        <div class="clear"></div>
    </div>
    <?php wp_footer(); ?>
    <?php /*if (is_front_page()): ?>
        <script type="text/javascript" src="<?php bloginfo("stylesheet_directory"); ?>/_js/easySlider1.7.js"></script>
    <?php endif;*/ ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.lightbox .zoom').on('click', function() {
            _gaq.push(['_trackEvent', 'CPC Landing Page', 'Click', 'Screenshots']);
        });
    });
    </script>
</body>
</html>

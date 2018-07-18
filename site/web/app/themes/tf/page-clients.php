<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php Extras\output_page_intro(); ?>
    <div class="row">
        <div class="col-sm-8">
            <?php
                the_content();
                echo '<div class="client-logos clearfix">'.str_replace('/>', ' class="alignleft small pad"/>', strip_tags(get_field('client_logos'), '<img>')).'</div>';
            ?>
            <div class="hr clearfix"></div>
            <div id="casestudies" class="section-intro">
            <?php
            the_field('case_studies_intro');

            query_posts('post_type=case_study&orderby=menu_order&order=ASC');

            $count = 1;

            echo '</div><div class="row content-blocks cols2">';

            while (have_posts()) : the_post();
            ?>
            <div class="contentBlock col-sm-6">
                <a href="<?php the_permalink(); ?>">
                    <?php
                        $photoID = get_field('logo_feature_image');

                        if ($photoID):
                            $thumbnail = wp_get_attachment_image_src($photoID, THUMB_TWO_COL_CONTENT_BLOCK_WITH_SIDEBAR);
                            echo '<img src="'.$thumbnail[0].'" height="'.$thumbnail[2].'" width="'.$thumbnail[1].'" alt="'.get_the_title().' Logo" />';
                        endif;
                    ?>
                </a>
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?> Case Study</a></h3>
                <p><?php the_advanced_excerpt('length=150&no_custom=0&use_words=0&no_shortcode=1&exclude_tags=_all'); ?></p>
                <?php
                    if (get_field('short_client_name') != '')
                        $linkName = get_field('short_client_name');
                    else
                        $linkName = get_the_title();
                ?>
                <a href="<?php the_permalink(); ?>" class="more">See how we helped <?php echo $linkName; ?></a>
            </div>
            <?php
                $count++;

                if ($count > 2)
                	$count = 1;
            endwhile;

            echo '</div>';

            wp_reset_query();
            ?>
        </div>
        <div class="right-sidebar col-sm-4">
            <div class="inner">
                <h4><?php the_field('sidebar_title'); ?></h4>
                <?php
                $count = 0;

    	while (the_repeater_field('sidebar_quotes')):
    		echo '<div class="quote '.($count == 0 ? 'first' : '' ).'">';
    		echo '	<span class="remark">&ldquo;' . get_sub_field('quote') . '&rdquo;</span><br/>';
    		echo '	<div class="author">' . get_sub_field('author_name') . ', ' . get_sub_field('author_position/company') .'</div>';
    		echo '</div>';
    		$count++;
    	endwhile;
            ?>
            </div>
        </div>
    </div>
<?php endwhile; endif; ?>

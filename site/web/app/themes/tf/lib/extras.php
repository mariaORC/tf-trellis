<?php
namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

function get_featured_posts($numFeaturedPosts = 3, $customFeaturedPostsField, $postType = 'post', $customPosts = []) {
    //Output features posts for this article. Users can custom select the related posts or optionally we will find
    //featured posts that match the post type ordered by date.
    $posts = [];
    $customFeaturedPostIDs = [];
	$customFeaturedPosts = $customPosts;

	if (empty($customFeaturedPosts)):
		get_field($customFeaturedPostsField);
	endif;

    if (!empty($customFeaturedPosts)):
        foreach ($customFeaturedPosts as $featuredPost):
            $posts[] = $featuredPost;
            $customFeaturedPostIDs[] = $featuredPost->ID;
        endforeach;
    endif;

    if (count($customFeaturedPostIDs) < $numFeaturedPosts):
        $featuredPosts = get_posts(
            array(
                'post_type' => $postType,
                'numberposts' => ($numFeaturedPosts-count($customFeaturedPostIDs)),
                'post__not_in' => $customFeaturedPostIDs,
                'orderby' => ($postType == 'post' ? 'date' : 'rand'),
                'order' => 'desc'
            )
        );

        if($featuredPosts):
            foreach($featuredPosts as $featuredPost):
                $posts[] = $featuredPost;
            endforeach;
        endif;
    endif;

    //We always need one featured financial case study so let's see if we got one.
    if ($postType == 'case_study'):
        $haveFinancialCaseStudy = false;

        foreach ($posts as $caseStudy):
            $industry = get_field('industry', $caseStudy->ID);

            if ($industry['value'] == 'financial'):
                $haveFinancialCaseStudy = true;
                break;
            endif;
        endforeach;

        if (!$haveFinancialCaseStudy):
            $featuredPosts = get_posts(
                array(
                    'post_type' => 'case_study',
                    'numberposts' => 1,
                    'meta_key' => 'industry',
                    'meta_value' => 'financial',
                    'orderby' => 'rand'
                )
            );

            if($featuredPosts):
                array_pop($posts);

                $posts[] = $featuredPosts[0];
            endif;
        endif;
    endif;

    return $posts;
}

function output_page_intro($pageID = '', $illustrationAsBackground = false, $fluidLayout = false, $location = 'body') {
    global $post;

	if (!$pageID && $post):
		$pageID = $post->ID;
	endif;

	$outputTitleInHeader = get_field('show_intro_title_in_header_band', $pageID);
	$outputInHeader = get_field('show_full_intro_in_header_band', $pageID);
	$introTitle = get_field('intro_title', $pageID);
	$introContent = get_field('intro_content', $pageID);

	if (($location == 'header' && $outputInHeader) || ($location == 'body' && !$outputInHeader)):
		$illustrationAlignment = get_field('illustration_alignment', $pageID);

		if ($introTitle):
			$leftColSize = get_intro_left_col_size($pageID, $illustrationAsBackground);
			$illustration = get_field('intro_page_illustration', $pageID);

			if ($illustrationAsBackground):
				$image_url = wp_get_attachment_image_src($illustration, THUMB_PAGE_ILLUSTRATION);
				echo '<div class="row page-intro bg-illustration" style="background-image: url('.$image_url[0].');">';
			else:
				$introClass = '';

				if (!$illustration && !get_field('intro_video_iframe_code')) {
					$introClass .= ' no-image ';
				} else {
					$introClass .= ' with-image ';
				}

				echo '<div class="row page-intro '.$introClass.'">';
			endif;

			if (!$outputTitleInHeader && $illustration && $illustrationAlignment == 'right_of_content'):
				echo '<div class="col-sm-12"><h1 class="mainHeading '.($introContent ? 'with-sub-heading' : '').'">'.do_shortcode($introTitle).'</h1></div>';
			endif;

			echo '<div class="col-sm-'.$leftColSize.'">';

			if (!$outputTitleInHeader && (!$illustration || ($illustration && $illustrationAlignment != 'right_of_content'))):
				echo '  <h1 class="mainHeading '.($introContent ? 'with-sub-heading' : '').'">'.do_shortcode($introTitle).'</h1>';
			endif;

			//If we're on the demo page we'll just output the content
			if ($post->ID == 11):
				echo do_shortcode($introContent);
			elseif ($introContent):
				echo '  <p class="intro">'.do_shortcode($introContent).'</p>';
			endif;

			if ($leftColSize != 12):
				echo '</div>';
				echo '<div class="col-sm-'.(12-$leftColSize).' '.($post->post_type == 'landing' ? '' : 'text-right').'">';

				if ($illustration):
					$image_url = wp_get_attachment_image_src($illustration, THUMB_PAGE_ILLUSTRATION);

					$imageStyle = '';

					if (get_field('image_margin')) {
						$imageStyle = ' style="margin: '.get_field('image_margin').'; display: block;"';
					}

					echo '<div '.$imageStyle.'><img src="'.$image_url[0].'" height="'.$image_url[2].'" width="'.$image_url[1].'" class="'.($post->post_type == 'landing' ? '' : 'alignright').'" /></div>';
				elseif (get_field('intro_video_iframe_code')):
					echo '<iframe width="410" height="231" src="'.get_field('intro_video_iframe_code').'" frameborder="0" allowfullscreen class="alignright"></iframe>';
				endif;
			endif;

			echo '</div></div>';
		else:
			if (strpos(get_the_content(), '<h1') === false)
				get_template_part('templates/page', 'header');
		endif;
	endif;
}

function get_intro_left_col_size($pageID = '', $illustrationAsBackground = false) {
    global $post;

    $illustration = get_field('intro_page_illustration', ($pageID ? $pageID : $post->ID));

    $leftColSize = 12;

    if ($post->post_type == 'landing')
        $leftColSize = 8;
    elseif (is_page_template('template-section-main.php') && $illustration)
        $leftColSize = 6;
    elseif ($illustration && !$illustrationAsBackground)
        $leftColSize = 8;
    elseif (get_field('intro_video_iframe_code'))
        $leftColSize = 6;

    return $leftColSize;
}

function output_pricing_page_intro($introTitle) {
    global $post;

    $tier1Price = get_field('tier_1_price');

    if($tier1Price > 99):
        $pricingCSS = ' threeDigit';
    elseif($tier1Price > 9):
        $pricingCSS = ' twoDigit';
    endif;

    if (strpos((string)$tier1Price, '1') !== false):
        $pricingCSS .= ' hasOnes';

        if (substr_count((string)$tier1Price, '1') > 1):
            $pricingCSS .= ' twoOnes';
        endif;
    endif;


    echo '<div class="row price-intro page-intro">';
        if (!get_field('show_intro_title_in_header_band', $post->ID)):
            echo '  <div class="col-sm-12"><h1 class="mainHeading">'.get_field('intro_title').'</h1></div>';
        endif;

        echo '  <div class="col-sm-5 text-center"><div class="price"><em>'.get_pricing_currency_symbol($post->ID).'</em><span>'.$tier1Price.'</span></div></div>';
        echo '  <div class="intro col-sm-7"><h3>'.$introTitle.'</h3>'.get_field('intro_content').'</div>';
    echo '</div>';

}

function output_content_footer() {
    //Output a next page link if the user selected one for this page.
    if (get_field('next_page_link') != ''):
        echo '<div class="divider"></div>';
        echo '<div class="nextPage"><span>Next:</span> <em><a href="'.get_field('next_page_link').'">'.get_field('next_page_link_text').'</a></em></div>';
    endif;
}

function output_pricing_content_blocks($repeaterField = 'pricing_content_blocks') {
   global $post;
    $counter = 0;
    $hasModalBox = false;

    echo '<div class="content-blocks pricing-blocks row clearfix">';

    while(the_repeater_field($repeaterField, 'options')):
      if (get_sub_field('description') != ''):
         $counter++;

            $linkURL = get_sub_field('link_url');

         echo '<div class="contentBlock col-sm-6 text-center">';

            if (substr($linkURL, 0, 1) == '#'):
                $hasModalBox = true;
                $linkCSS = ' class="form" ';
            else:
                $linkCSS = '';
            endif;

         if (get_sub_field('illustration') != ''):
            $image_url = wp_get_attachment_image_src(get_sub_field('illustration'));

            echo '  <a href="'.$linkURL.'"'.$linkCSS.'><img src="'.$image_url[0].'" width="'.$image_url[1].'" height="'.$image_url[2].'" /></a>';
         endif;

         echo '    <h3><a href="'.$linkURL.'"'.$linkCSS.'>'.get_sub_field('title').'</a></h3>';
         echo '    <p>'.get_sub_field('description').'</p>';

         if (get_sub_field('link_text') != '' && $linkURL != '')
            echo '    <a href="'.$linkURL.'"'.$linkCSS.'>'.get_sub_field('link_text').'</a>';

         echo '</div>';
      endif;
    endwhile;

    echo '</div>';

    if ($hasModalBox):
        echo do_shortcode('<div style="display: none;"><div  id="callbackform"><h2>Request Callback</h2> [MarketoForm url="http://info.thoughtfarmer.com/ContactUsiFrameform.html" height="460" width="420"]</div></div>');
        echo '<script type="text/javascript">jQuery(document).ready(function($) { enableFormModal(); }); </script>';
    endif;
}

function output_cloud_pricing_table($postID = '') {
    global $post;

    if (empty($postID))
        $postID = $post->ID;
?>
    <div class="pricingContainer">
        <table class="table pricing mobile" cellspacing="0" cellpadding="0" border="0">
            <thead>
                <tr>
                    <th class="rh"><div><?php _e('# Users', 'thoughtfarmer'); ?></div></th>
                    <th class="rh"><?php _e('Monthly Fee Per User*', 'thoughtfarmer'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="first">50-99</th>
                    <td class="last"><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_1_price', $postID); ?></span></td>
                </tr>
                <tr>
                    <th class="first">100-199</th>
                    <td class="last"><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_2_price', $postID); ?></span></td>
                </tr>
                <tr>
                    <th class="first">200-499</th>
                    <td class="last"><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_3_price', $postID); ?></span></td>
                </tr>
                <tr>
                    <th class="first">500-999</th>
                    <td class="last"><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_4_price', $postID); ?></span></td>
                </tr>
                <tr>
                    <th class="first">1000+</th>
                    <td class="last"><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_5_price', $postID); ?></span></td>
                </tr>
            </tbody>
        </table>
        <table class="table pricing desktop" cellspacing="0" cellpadding="0" border="0">
            <thead>
                <tr>
                    <th class="rh"><div><?php _e('# Users', 'thoughtfarmer'); ?></div></th>
                    <th class="first">50-99</th>
                    <th>100-199</th>
                    <th>200-499</th>
                    <th>500-999</th>
                    <th class="last">1000+</th>
                </tr>
            </thead>
            <tbody>
                <tr class="last">
                    <th class="rh"><div><?php _e('Monthly Fee Per User*', 'thoughtfarmer'); ?></div></th>
                    <td class="first"><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_1_price', $postID); ?></span></td>
                    <td><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_2_price', $postID); ?></span></td>
                    <td><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_3_price', $postID); ?></span></td>
                    <td><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_4_price', $postID); ?></span></td>
                    <td class="last"><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_5_price', $postID); ?></span></td>
                </tr>
            </tbody>
        </table>
        <p><small class="disclaimer"><?php _e('*All per-user products require an annual contract and are billed annually in advance.', 'thoughtfarmer'); ?></small></p>
        <p><a href="/services/support/"><?php _e('Our Cloud service includes maintenance &amp; support', 'thoughtfarmer'); ?></a></p>
    </div>
<?php
}

function output_self_hosted_pricing_table($postID = '') {
    global $post;

    if (empty($postID))
        $postID = $post->ID;
?>
    <div class="pricingContainer">
        <table class="table pricing mobile" cellspacing="0" cellpadding="0" border="0">
            <thead>
                <tr>
                    <th class="rh"><div><?php _e('# Users', 'thoughtfarmer'); ?></div></th>
                    <th class="rh"><?php _e('One-Time Fee Per User', 'thoughtfarmer'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="first">100-249</th>
                    <td class="last"><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_1_price', $postID); ?></span></td>
                </tr>
                <tr>
                    <th class="first">250-499</th>
                    <td class="last"><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_2_price', $postID); ?></span></td>
                </tr>
                <tr>
                    <th class="first">500+</th>
                    <td class="last"><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_3_price', $postID); ?></span></td>
                </tr>
                <tr>
                    <th class="first">1000+</th>
                    <td class="enterprise last"><?php _e('Enterprise License.', 'thoughtfarmer'); ?> <a href="/pricing/request-on-premise-pricing/"><?php _e('Contact Us', 'thoughtfarmer'); ?></a></td>
                </tr>
            </tbody>
        </table>
        <table class="table pricing desktop" cellspacing="0" cellpadding="0" border="0">
            <thead>
                <tr>
                    <th class="rh"><div><?php _e('# Users', 'thoughtfarmer'); ?></div></th>
                    <th class="first">100-249</th>
                    <th>250-499</th>
                    <th>500+</th>
                    <th class="last">1000+</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="rh"><div><?php _e('One-Time Fee Per User', 'thoughtfarmer'); ?></div></th>
                    <td class="first"><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_1_price', $postID); ?></span></td>
                    <td><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_2_price', $postID); ?></span></td>
                    <td><em><sup><?php echo get_pricing_currency_symbol($postID); ?></sup></em><span><?php the_field('tier_3_price', $postID); ?></span></td>
                    <td class="enterprise last"><?php _e('Enterprise License.', 'thoughtfarmer'); ?> <a href="/pricing/request-on-premise-pricing/"><?php _e('Contact Us', 'thoughtfarmer'); ?></a></td>
                </tr>
            </tbody>
        </table>
        <p><a href="/services/support/"><?php _e('User fee includes first 12 months of maintenance &amp; support', 'thoughtfarmer'); ?></a></p>
    </div>
<?php
}

/*
* Most pages on the site are built up using a Flexible Content - Advanced Custom Field called "content_blocks". These can be anything from a piece of text on the left with an image on the right. Or it can be a full width video feature, or just a simple WYSIWYG text output. It can be output into multiple columns, or just be one column by default. And you can alternate the content left and right similar to the homepage.
*
* Update Feb 10, 2016: The site is moving towards a more fluid layout on the pages with full width content blocks with background images. Some of these will go completely edge to edge, while others will be constrained to a max width. For this we have added a new $fluidLayout property. If this is added our content blocks will be wrapped in a fluid Bootstrap container.
*/
function output_flexible_content_blocks($numCols = 1, $pageHasSidebar = false, $alternatingContent = true, $fluidLayout = false) {
    global $post;
    $sidebarContent = "";
    $counter = 0;
    $blockCounter = 0;

    //For the partners page, we want to use a three column layout.
    if($post->ID == 23):
        $numCols = 3;
    elseif (is_page_template('template-version-landing-page.php') || is_page_template('template-professional-services.php')):
        $numCols = 2;
    endif;

    if (get_field('content_blocks')):
        //If we're using a fluid layout, we'll wrap each block in its own container. We will also force the block column size to be the full 12 column grid width.
        if ($fluidLayout) {
            $numCols = 1;
            echo '<div class="container-fluid">';
        }

        echo '<div class="content-blocks cols'.$numCols.' row">';

        $currentImgHAlign = 'left';

        while(the_flexible_field('content_blocks')):
            $counter++;

            //Get the image alignment setting for the block. If nothing was set, we'll assume it's a top aligned image.
            $imageAlign = get_sub_field('image_alignment') ? get_sub_field('image_alignment') : 'top'; //Aligned top by default

            //We use a standard 12 column Bootstrap Grid for a full width block
            $blockColSize = 12;

            //If we're outputting multiple columns, we'll calculate the width for each block.
            if ($numCols > 1 && ($imageAlign == 'top' || $imageAlign == 'bottom' || $imageAlign == 'bottom-center') && get_row_layout()  != 'wysiwyg_block'):
                $blockColSize = 12/$numCols;
            endif;

            $backgroundImage = get_sub_field('background_image');
            $backgroundColour = get_sub_field('background_colour');
            $blockStyle = '';
            $blockCSSClass = '';

            if ($backgroundImage && get_sub_field('image_style') != 'standard'):
                $blockStyle = ' style="background: #CCC url('.$backgroundImage.') no-repeat center center; background-size: cover;" ';
                $blockCSSClass = ' with-background ';
            endif;

			if ($backgroundColour):
				$blockStyle = ' style="background: '.$backgroundColour.';" ';
				$blockCSSClass .= ' with-background ';
			endif;

			if (!get_sub_field('thumbnail')):
				$blockCSSClass .= ' no-thumb ';
			endif;

            if (get_row_layout() != 'featured_webinar' || get_field('feature_latest_webinar_post', 'options')):
                //Start by outputting the column for the block.
                echo '<div class="contentBlock col-xs-12 col-sm-'.$blockColSize.' block'.$counter.' '.$imageAlign.' '.get_row_layout().' '.$blockCSSClass.'" '.$blockStyle.'><div class="block-inner">';

                //Reset block info
                $fullSizeImage = '';
                $linkURL = '';
                $linkClass = '';
                $linkTitle = '';
                $linkTag = '';

                //Our default block layout consists of an image and a piece of text. In the case of something like the WYSIWYG block, it's just text so we only need to output the post content.
                include(dirname(__FILE__) . '/../templates/content-blocks/'.get_row_layout().'.php');

                echo '</div></div>'; //End of the content block wrapper
            endif;

            $blockCounter++;
        endwhile;

        echo '</div>'; //End of the content-blocks row

        //If we're using a fluid layout, we'll wrap each block in its own container.
        if ($fluidLayout) {
            echo '</div>'; //End of the block container
        }
    endif;
}


function get_pricing_currency_symbol($postID) {
    $currencySymbol = '$';

    switch (get_field('currency', $postID)) {
        case 'GBP':
            $currencySymbol = '£';
            break;
        case 'EUR':
            $currencySymbol = '€';
            break;
    }

    return $currencySymbol;
}

function get_blog_users( $id = '' ) {
   global $wpdb, $blog_id;
   if ( empty($id) )
      $id = (int) $blog_id;
   $blog_prefix = $wpdb->get_blog_prefix($id);
   $users = $wpdb->get_results( "SELECT user_id, user_id AS ID, user_login, display_name, user_email, meta_value FROM $wpdb->users, $wpdb->usermeta WHERE {$wpdb->users}.ID = {$wpdb->usermeta}.user_id AND meta_key = '{$blog_prefix}capabilities' ORDER BY display_name" );
   return $users;
}

function output_people_grid($title, $leadership)
{
    $leadershipValue = '0';

    if ($leadership)
        $leadershipValue = '1';

    // get blog posts in PERSON category
    $args = array(
        'post_type' => array(TYPE_PERSON),
        'order'  => 'ASC',
        'orderby' => 'title',
        'posts_per_page' => -1,
        'meta_key' => 'leadership',
        'meta_value' => $leadershipValue
        );

    query_posts($args);

    $count = 0;
?>
    <h4><?php echo $title; ?></h4>
    <div class="col-sm-12"><div class="people-grid row clearfix">
        <?php while (have_posts()) : the_post(); ?>
        <?php
            $count++;
            show_person_box($count, 3, $leadership);
        ?>
        <?php endwhile; ?>
    </div></div>
<?php
    //Reset Query
    wp_reset_query();
}

function show_person_box($count, $cols = 3, $leader = false)
{
    global $post;

    $photoID = get_field('photo');

    if ($photoID):
        $thumbnail = wp_get_attachment_image_src($photoID, THUMB_PERSON);
        $thumbnail = $thumbnail[0];
    endif;

    $cssClass = '';

    if ($count % 3 == 1)
        $cssClass = 'first';

    if ($leader)
        $cssClass .= 'leader';
?>
    <a class="col-xs-<?php echo ($leader ? '4' : '3'); ?> people thumb <?php echo $cssClass; ?>" href="#personmodal<?php echo $post->ID; ?>" id="person<?php echo $post->ID; ?>" name="person<?php echo $post->ID; ?>">
        <div class="name"><?php the_field('first_name'); ?></div>
        <img src="<?php echo $thumbnail; ?>" alt="<?php the_field('first_name'); ?>" />
    </a>
    <div id="personmodal<?php echo $post->ID; ?>" style="display: none;">
        <?php //<a href="javascript:$.fancybox.close();" class="sprite close">Close</a> ?>
        <?php
        if ($photoID):
            $thumbnail = wp_get_attachment_image_src($photoID, THUMB_PERSON_ZOOM);
            echo '<img src="'.$thumbnail[0].'" class="photo" />';
        endif;
        echo '<h3>'.get_the_title().'</h3>';
        the_content();

        if (get_field('email_address') != ''):
            echo '<a href="mailto:'.get_field('email_address').'" class="btn btn-success-dark btn-outline"><span>Email</span></a>';
        endif;

        edit_post_link('Edit Profile');
        ?>
    </div>
<?php
}

function output_post_category() {
    global $post;

    $post_categories = wp_get_post_categories($post->ID);
    $category = '';
    $categoryID = '';

    if (count($post_categories) > 0):
        $cat = get_category($post_categories[0]);
        $category = $cat->name;
        $categoryID = $cat->cat_ID;
    endif;

    echo '<a href="'.get_category_link($categoryID).'">'.$category.'</a>';
}

function entry_social_links() {
    global $post;
?>
    <div class="entry-social">
    <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink() ?>" data-text="<?php the_title() ?>" data-count="none" data-via="thoughtfarmer">Tweet</a>
     <?php
        $numComments = get_comments_number();

        if ($numComments > 0):
            echo '<a href="'.get_permalink().'#comments" class="comments">Comments<span class="badge">'.$numComments.'</span></a>';
        endif;
     ?>
</div>
<?php
}

function tf_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;
?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-meta">
        <span class="comment-date"><?php printf(__('%1$s / %2$s'), get_comment_date(),  get_comment_time()) ?></span><br/>
        <strong><?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?></strong><br/>
        <?php edit_comment_link(__('(Edit)'),'  ','') ?>
      </div>

      <div class="comment-entry">
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>
      <?php comment_text() ?>
      </div>
     <div class="clear"></div>
     </div>
     <div class="clear"></div>
<?php
}


function twentyten_posted_on() {
	printf( __( '<span class="%1$s">By</span> %3$s<span class="meta-sep">,</span> %2$s', 'twentyten' ),
		  'meta-prep meta-prep-author',
		get_the_date(),
			  sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
		get_author_posts_url( get_the_author_meta( 'ID' ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
		get_the_author()
	  )
	);
}

function results_counter() {
    global $wp_query;
    global $query_string;

    $totalResults = $wp_query->found_posts;
    $resultsOnPage = $wp_query->post_count;

    $resultsPageNum = 1;
    $query_args = explode("&", $query_string);
    foreach($query_args as $key => $string):
        $query_split = explode("=", $string);

        if ($query_split[0] == 'paged'):
            $resultsPageNum = urldecode($query_split[1]);
        endif;
    endforeach;

    if ($totalResults > 0):
        $firstPageResult = (($resultsPageNum-1) * 10) + 1;
        $lastPageResult = (($resultsPageNum-1) * 10) + $resultsOnPage;
        echo 'Results '.$firstPageResult.' - '.$lastPageResult.' (of '.$totalResults.')';
    endif;
}

function results_numeric_pager() {
    global $wp_query;
    global $query_string;

    $totalResults = $wp_query->found_posts;

//echo $query_string.'<br/>';

    $resultsPageNum = 1;

    //Set the default permalink structure to the search structure
    $permalinkFormat = '/page/%1$s/?search&s=video&page=%1$s';

    $query_args = explode("&", $query_string);
    foreach($query_args as $key => $string) {
        $query_split = explode("=", $string);

        //var_dump($query_split);

        if ($query_split[0] == 'paged'):
            $resultsPageNum = urldecode($query_split[1]);
        elseif($query_split[0] == 'category_name'):
            $permalinkFormat = '/blog/category/'.$query_split[1].'/page/%1$s';
        elseif($query_split[0] == 'tag'):
            $permalinkFormat = '/blog/tag/'.$query_split[1].'/page/%1$s';
        elseif($query_split[0] == 'author_name'):
            $permalinkFormat = '/blog/author/'.$query_split[1].'/page/%1$s';
        elseif($query_split[0] == 'year'):
            $permalinkFormat = '/blog/'.$query_split[1].'/page/%1$s';
        endif;
    } // foreach

    if ($totalResults > 10):
        $totalPages = ceil($totalResults / 10);


        if ($resultsPageNum > 1)
            $navLinks = '<a href="'.sprintf($permalinkFormat, $resultsPageNum-1).'" class="prev-next pager-prev"><i class="icon-angle-left"></i>Prev</a>';

        for ($i=1; $i <= $totalPages ; $i++):
            $navLinks .= '<a href="'.sprintf($permalinkFormat, $i).'" class="num '.($i == $resultsPageNum ? 'current' : '').'">'.$i.'</a> ';
        endfor;

        if ($resultsPageNum < $totalPages)
            $navLinks .= '<a href="'.sprintf($permalinkFormat, $resultsPageNum+1).'" class="prev-next pager-next">Next<i class="icon-angle-right"></i></a>';

        echo '<div class="text-center">'.$navLinks.'</div>';
    endif;
}

function output_contact_info_block($content, $blockLabel) {
//<div class="col-sm-2 text-right"><h3>'.$blockLabel.'</h3></div>
    echo '<div class="contactBlock row">

            <div class="col-sm-8">'.$content.'</div>
            </div>
    ';
}

function get_latest_webinar() {
	$featuredWebinar = '';

	if (get_field('feature_latest_webinar_post', 'options')):
        $args = array('numberposts' => 1, 'category' => 145);
		$featuredWebinar = get_posts($args);

		if (count($featuredWebinar) > 0):
			$featuredWebinar = $featuredWebinar[0];
		endif;
	endif;

	return $featuredWebinar;
}

function output_latest_webinar($outputThumbnail = true, $outputHeading = true, $echo = true) {
    if (get_field('feature_latest_webinar_post', 'options')):
        global $post;
        $tmp_post = $post;
        $args = array('numberposts' => 1, 'category' => 145);
        $myposts = get_posts($args);
        $webinar = '';

        foreach( $myposts as $post ) : setup_postdata($post);
            if ($outputThumbnail && has_post_thumbnail()):
                $thumbnail = get_the_post_thumbnail($post->ID, THUMB_CONTENT_BLOCK);
            else:
                $thumbnail = get_post_first_attachment(get_the_ID(),THUMB_CONTENT_BLOCK);
            endif;

            $webinar = '<div class="contentBlock fullWidth first">';

            if ($outputHeading)
                $webinar .= '<h3>Upcoming Webinar</h3>';

            $webinar .= '<p>';

            if ($outputThumbnail && $thumbnail != ''):
                $thumbnail = str_replace('class="', 'class="alignright pad ', $thumbnail);
                $webinar .= '<a href="'.get_permalink().'">'.$thumbnail.'</a>';
            endif;
            $webinar .= '<a href="'.get_permalink().'">'.get_the_title().'</a><br/>';
            $webinar .= get_the_excerpt();
            $webinar .= '</p><div class="clear"></div></div>';
        endforeach;

        $post = $tmp_post;

        if ($echo)
            echo $webinar;

        return $webinar;
    endif;
}

function output_latest_webinar_support($outputHeading = true, $echo = true) {
    if (get_field('feature_latest_webinar_post', 'options')):
		global $post;
		$tmp_post = $post;
		$args = array('numberposts' => 1, 'category' => 145);
		$myposts = get_posts($args);
		$webinar = '';

		foreach( $myposts as $post ) : setup_postdata($post);

			if ($outputHeading) {
				$webinar .= '<p><img class="alignnone size-full wp-image-17732" src="https://www.thoughtfarmer.com/files/2016/03/illu_TrainingNext.png" alt="illu_TrainingNext" width="69" height="64"></p>';
				$webinar .= '<p class="webinar_support">Next Webinar:</p>';
			}

			$webinar .= '<h6><a href="'.get_permalink().'">'.get_the_title().'</a></h6><p>';
			$webinar .= get_the_excerpt();
			$webinar .= '</p>';
		endforeach;

		$post = $tmp_post;

		if ($echo)
			echo $webinar;

		return $webinar;
	endif;
}

function get_post_first_attachment($postID, $size) {
    global $posts, $post;

    $files = get_children('post_parent='.$postID.'&numberposts=1&post_type=attachment&post_mime_type=image');

    if($files) :
        $keys = array_reverse(array_keys($files));
        $j=0;
        $num = $keys[$j];
        $image=wp_get_attachment_image($num, $size, false);
    endif;

    return $image;
}

function output_homepage_quotes($postID = 3) {
?>
    <div id="homeQuote" class="container">
        <div class="grid_16 push_4">
            <ul class="styledList">
            <?php
                while (the_repeater_field('quotes', $postID)):
                echo '<li><span class="quote">'.__('&ldquo;', 'thoughtfarmer').get_sub_field('quote').__('&rdquo;', 'thoughtfarmer').'</span>';
                echo '<span class="author">'.get_sub_field('quote_author').'</span></li>';
                endwhile;
            ?>
            </ul>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    setMaxQuoteHeight();
                    homepageQuoteRotator();
                });
            </script>
        </div>
    </div>
<?php
}

function output_homepage_client_logos() {
    echo '<div id="clientLogos">';
    $counter = 0;
    while(the_repeater_field('client_logos', 3)):
        $image = wp_get_attachment_image_src(get_sub_field('logo'), 'full');

        $logoURL = get_sub_field('logo_url');

        if ($logoURL != ''):
            echo '<a href="'.$logoURL.'">';
        endif;

        echo '<img src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" class="'.($counter == 0 ? 'first' : '').'" />';

        if ($logoURL != ''):
            echo '</a>';
        endif;

        $counter++;
    endwhile;
    echo '</div>';

}
function post_is_landing_page() {
    global $post;

    return (is_page_template('template-landing-page.php') || is_page_template('template-multilingual-landing-page.php') || $post->post_type == 'landing');
}

// add custom feed content
function email_compatible_styles_feed_content($content) {
    global $post;

    if(is_feed()):
        include_once('simple_html_dom.php');
        include_once('simple_html_dom_utility.php');

        $contentHTML = str_get_html(do_shortcode($content));

        foreach($contentHTML->find('img.alignright') as $element):
            $element->style = 'float: right; margin: 0 0 15px 15px;'.$element->style;
        endforeach;

        foreach($contentHTML->find('img.alignleft') as $element):
            $element->style = 'float: left; margin: 0 15px 15px 0;'.$element->style;
        endforeach;

        foreach($contentHTML->find('div.wp-caption') as $element):
            $element->style = 'background: #fff; border: 1px solid #C7C7BE; border-radius: 6px; font-style: italic; padding: 7px; max-width: 570px; margin: 20px 0; padding: 10px; width: 100%; ';
        endforeach;

        foreach($contentHTML->find('img') as $element):
            $element->style = 'max-width: 570px; width: 100%; height: auto!important; width: 100%!important;'.$element->style;
            $element->height = '';
            $element->width = '';
        endforeach;

        foreach($contentHTML->find('p.wp-caption-text') as $element):
            $element->style = 'margin: 7px 0 0 0;';
        endforeach;

        foreach($contentHTML->find('table.common') as $table):
            $table->style = 'background: #efedde;border: 0;border-radius: 6px;width: 100%;border-spacing: 0;';

            foreach($table->find('th') as $th):
                $th->style = 'color: #27313e;text-transform: uppercase;font-weight: bold; font-family: Arial; margin: 0; padding: 8px 15px; text-align: left;border-bottom: dashed 1px #b5b5ac;';
            endforeach;

            foreach($table->find('td') as $td):
                $td->style = 'font-family: Arial;padding: 8px 15px; text-align: left;border-bottom: dashed 1px #b5b5ac;';
            endforeach;

            $rowCounter = 1;

            foreach($table->find('tr') as $tr):
                //Highlight every other row.
                if ($rowCounter % 2)
                    $tr->style = 'background: #f4f2e6;';

                $colCounter = 1;

                foreach($tr->find('th') as $trth):
                    if ($colCounter > 1)
                        $trth->style .= 'border-left: dashed 1px #b5b5ac;';

                    $colCounter++;
                endforeach;

                $colCounter = 1;

                foreach($tr->find('td') as $trtd):
                    if ($colCounter > 1)
                        $trtd->style .= 'border-left: dashed 1px #b5b5ac;';

                    $colCounter++;
                endforeach;

                $rowCounter++;
            endforeach;
        endforeach;

        foreach($contentHTML->find('h1') as $element):
            $element->style = 'font-size: 24px; line-height: 28px; font-weight: bold!important; text-transform: none; font-family: Arial; margin-top: 5px;';
        endforeach;

        foreach($contentHTML->find('h2') as $element):
            $element->style = 'font-size: 22px; line-height: 24px; font-weight: bold!important; text-transform: none; font-family: Arial; margin-top: 5px;padding-top: 20px;';
        endforeach;

        foreach($contentHTML->find('h3') as $element):
            $element->style = 'font-size: 22px; line-height: 24px; font-weight: bold!important; text-transform: none; font-family: Arial; margin-top: 5px;padding-top: 20px;';
        endforeach;

        foreach($contentHTML->find('.marketing-snipplet') as $element):
            $element->style = 'border: solid 1px #efe3ae!important; background: #fef6d2!important; border-radius: 7px; color: #6c4b04!important; display: block; margin-bottom: 15px; padding: 7px 12px!important;';
        endforeach;

        foreach($contentHTML->find('a') as $element):
            $element->style = 'color:#A23D00;'.$element->style;
        endforeach;

        $content = $contentHTML;
    endif;

    return $content;
}
add_filter('the_excerpt_rss', __NAMESPACE__ . '\\email_compatible_styles_feed_content');
add_filter('the_content', __NAMESPACE__ . '\\email_compatible_styles_feed_content');

add_shortcode('cookie_cuttr_buttons',__NAMESPACE__ . '\\CookieCuttrButtonsShortCode');

function CookieCuttrButtonsShortCode($params = null, $content = null) {
    $output .= '<p><a href="#decline" class="tf-cookie-set">Delete non-essential cookies and don\'t set them again</a></p><p>Use the buttons above to <span class="cookie-message">disable</span> non-essential cookies for this web site.</p>';
    $output .= '
        <script type="text/javascript">
            setCookieLinkText();

            $(".tf-cookie-set").click(function(e) {
                e.preventDefault();
                if ($(this).is("[href$=#decline]")) {
                    $.cookieCuttr.accepted = false;
                    $.cookieCuttr.declined = true;
                    $.cookieCuttr.SetCookie("cc_cookie_accept", null, "/");
                    $.cookieCuttr.SetCookie("cc_cookie_decline", "cc_cookie_decline", "/");

                    // clear down known google analytics and marketo cookies
                    if(cookieDomain) {
                        var deniedCookies = ["__utma", "_mkto_trk", "__utmb", "__utmc", "__utmz", "__utmx", "__utmxx"];

                        for (var i = 0; i < deniedCookies.length; i++) {
                            $.cookieCuttr.SetCookie(deniedCookies[i], null, "/");
                        }
                    }
                } else {
                    $.cookieCuttr.accepted = true;
                    $.cookieCuttr.declined = false;
                    $.cookieCuttr.SetCookie("cc_cookie_decline", null, "/");
                    $.cookieCuttr.SetCookie("cc_cookie_accept", "cc_cookie_accept", "/");
                }

                setCookieLinkText();
            });

            function setCookieLinkText() {
                var cookieLink = $(".tf-cookie-set");
                var cookieMessage = $(".cookie-message");

                if ((!$.cookieCuttr.accepted && !$.cookieCuttr.declined) || $.cookieCuttr.accepted) {
                    cookieLink.addClass("decline");
                    cookieLink.attr("href", "#decline");
                    cookieLink.html("Delete non-essential cookies and don\'t set them again");
                    cookieMessage.html("enable");
                }
                else {
                    cookieLink.removeClass("decline");
                    cookieLink.attr("href", "#accept");
                    cookieLink.html("Allow all cookies set by this site");
                    cookieMessage.html("disable");
                }
            }
        </script>
    ';

    return $output;
}

function output_related_blog_post($relatedPost, $postThumbnail, $postIndex = 1) {
    global $post;
    $post = $relatedPost;

    setup_postdata($post);

    $thumbnailURL = '';

    if (!empty($postThumbnail)) {
        //The post has a custom thumbnail defined for display that image.
        $thumbnailURL = $postThumbnail['sizes'][THUMB_BLOG_RELATED_POST];
    } elseif (has_post_thumbnail()) {
        //The post has a feature image so display that one.
        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), THUMB_BLOG_RELATED_POST);
        $thumbnailURL = $thumb['0'];
    } else {
        //Find the first image attached to the post and display that one.
        $attachments = get_children(array('post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order'));

        if (is_array($attachments)) {
            $thumb = array_shift($attachments);
            $thumb = wp_get_attachment_image_src($thumb->ID, THUMB_BLOG_RELATED_POST);
            $thumbnailURL = $thumb['0'];
        }
    }
?>
    <div class="related-post contentBlock col-sm-6"><div class="well">
        <a href="<?php the_permalink(); ?>">
        <?php if (!empty($thumbnailURL)) { ?><img src="<?php echo $thumbnailURL; ?>" alt="<?php the_title(); ?>"></a><?php } ?>
        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <?php
        $excerpt = get_the_excerpt();
        $excerpt = strip_tags($excerpt);
        $excerpt = substr($excerpt, 0, 110);
        echo '<p>'.$excerpt.'&hellip;</p>';
        ?>
    </div></div>
<?php
    wp_reset_postdata();
}

function is_canadian_holiday($date) {

   $year = date('Y', $date);
   $holiday = false;

   switch(date('Y-m-d', $date)) {
        case $year.'-01-01': //New Years Day
        case '2013-03-31': //Good Friday
        case '2014-04-20': //Good Friday
        case '2015-04-05': //Good Friday
        case date("Y-m-d", strtotime($year.'-05-25, last monday')): //Victoria Day
        case $year.'-07-01': //Canada Day
        case date("Y-m-d", strtotime($year.'-08-00, first monday')): //Civic Holiday
        case date("Y-m-d", strtotime($year.'-09-00, first monday')): //Labour Day
        case date("Y-m-d", strtotime($year.'-10-00, second monday')): //Thanksgiving Day
        case $year.'-12-25': //Christmas
        case $year.'-12-26': //Boxing Day
            $holiday = true;
            break;
        default:
            $holiday = false;
    }

    return $holiday;
}

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');


function add_filters($tags, $function) {
  foreach($tags as $tag) {
    add_filter($tag, $function);
  }
}

function hex2rgba($color, $opacity = false) {
   $default = 'rgb(0,0,0)';

   //Return default if no color provided
   if(empty($color))
          return $default;

   //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
         $color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
         if(abs($opacity) > 1)
            $opacity = 1.0;
         $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
         $output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}

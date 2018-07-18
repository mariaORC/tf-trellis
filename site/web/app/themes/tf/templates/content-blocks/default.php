<?php
$rowStyle = '';

if (is_front_page() || is_page_template('template-section-main.php') || in_array($imageAlign, array('left', 'right'))) {
	$rowStyle .= 'valign-center-sm';
}

echo '<div class="row '.$rowStyle.'">';

$imageColCSSClass = 'col-sm-12';
$contentColCSSClass = 'col-sm-12';

//If we're alternating the content left and right we need to figure out wh
if ($alternatingContent):
    $currentImgHAlign = ($currentImgHAlign == 'right' ? 'left' : 'right');
else:
    $currentImgHAlign = 'left';
endif;

//If the image is left or right aligned we need to set what width the content and the image will be. If it's top or bottom aligned we always want the content and image container full width with a 1 column offset on either side.
if (!in_array($imageAlign, array('bottom', 'bottom-center', 'top', 'float-side'))):
    $imageColCSSClass = 'col-sm-6 image-col';
    $contentColCSSClass = 'col-sm-6';

    if (is_front_page() || is_page_template('template-section-main.php')) {
        $contentColCSSClass = 'col-sm-5 col-sm-offset-1 col-sm-pull-1';
    }

    if ($currentImgHAlign == 'left'):
        $imageColCSSClass .= ' col-sm-pull-6';
        $contentColCSSClass .= '  col-sm-push-6';
    endif;
else:
    if (is_page_template('template-section-main.php') || is_front_page()) {
        $contentColCSSClass = 'col-sm-10 col-sm-offset-1';
        $imageColCSSClass = 'col-sm-10 col-sm-offset-1';
    }
endif;


if ($post->post_type == 'industry' || is_page_template('template-version-landing-page.php') || is_page_template('template-professional-services.php')):
    $imageColCSSClass = 'col-sm-4';
    $contentColCSSClass = 'col-sm-'.(get_sub_field('thumbnail') ? '8' : '12');
endif;


//Now let's set up the block properties
switch (get_row_layout()):
    case 'standard_block':
        $linkURL = get_sub_field('block_url');
        $linkTitle = get_sub_field('title');
        break;
    case 'screenshot_block':
        if (get_sub_field('full_size')):
            $fullSizeImage = wp_get_attachment_image_src(get_sub_field('full_size'), 'full');
            $linkURL = $fullSizeImage[0];
            $linkClass = 'lightbox';
            $linkTitle = str_replace('"', '\'', get_sub_field('modal_description'));
        endif;
        break;
    case 'video_block':
        $linkURL = get_sub_field('video_embed_url');
        $linkClass = 'videobox fancybox.iframe';
        $linkTitle = str_replace('"', '\'', get_sub_field('modal_description'));
        break;
endswitch;

if ($linkURL == 'PRICINGBUTTONS'):
    $linkURL = '/pricing/';
endif;

//Define and build the block image.
$blockImage = '';

if (get_sub_field('thumbnail')):
    $imageURL = wp_get_attachment_image_src(get_sub_field('thumbnail'), THUMB_CONTENT_BLOCK);
    $imageCSSClass = '';

    if ($imageAlign == 'float-side'):
        $imageCSSClass .= ($currentImgHAlign == 'right' ? ' bigpad alignright' : ' bigpad alignleft');
    endif;

    //Users can override the image margins to pull it in any direction. This is a developer customization usually. If the value is set, we'll define a style for the image.
    $imageStyle = '';

    if (get_sub_field('image_margin')):
        $imageStyle = ' style="margin: '.get_sub_field('image_margin').'; display: block;"';
    endif;

    $blockImage = '<img src="'.$imageURL[0].'" class="'.$imageCSSClass.' " />';

    //If we have a link URL we'll wrap the image in the link. Otherwise wrap it in the URL.
    if ($linkURL):
        $blockImage = '<a id="'.sanitize_title(basename($linkURL)).'" href="'.$linkURL.'" class="'.$linkClass.'" title="'.$linkTitle.'" '.$imageStyle.'><div class="clearfix">'.$blockImage.'</div></a>';
    else:
        $blockImage = '<div '.$imageStyle.' class="clearfix">'.$blockImage.'</div>';
    endif;

endif;

$blockContent = '';

if ($imageAlign == 'float-side'):
    $blockContent .= $blockImage;
endif;

if (trim(get_sub_field('title'))):
	if ($linkURL != '' && get_row_layout() == 'standard_block'):
		$blockContent .= '<h3><a id="'.sanitize_title(basename($linkURL)).'" href="'.$linkURL.'" class="'.$linkClass.'" title="'.$linkTitle.'">'.get_sub_field('title').'</a></h3>';
	else:
		$blockContent .= '<h3>'.get_sub_field('title').'<a name="'.sanitize_title(get_sub_field('title')).'"></a></h3>';
	endif;
endif;

//If the image is top aligned we'll put it after the title, but before the content.
if ($imageAlign == 'top'):
    $blockContent .= $blockImage;
endif;

$blockContent .= get_sub_field('content');

if (get_sub_field('block_url') == 'PRICINGBUTTONS') {
	$blockContent .= '<div class="pricing-button">';
	$blockContent .= '<a href="/pricing/us-cloud-pricing/" class="btn btn-success-dark btn-outline">Cloud Pricing</a> <a href="/pricing/us-on-premise-pricing/" class="btn btn-success-dark btn-outline">On-Premise Pricing</a>';
	$blockContent .= '</div>';
}

if (get_sub_field('button_label')) :
    $blockContent .= '<a href="'.$linkURL.'" class="btn btn-success-dark btn-outline">'.get_sub_field('button_label').'</a>';
endif;

//If the image is bottom aligned we'll put it after the  content.
if ($blockImage && ($imageAlign == 'bottom' || $imageAlign == 'bottom-center')):
    $blockContent .= '<div class="align-'.$imageAlign.'">'.$blockImage.'</div>';
endif;

//Let's output the content.
echo '<div class="'.$contentColCSSClass.'">';
echo $blockContent;
echo '</div>';

if ($blockImage && !in_array($imageAlign, array('bottom', 'bottom-center', 'top', 'float-side'))):
    echo '<div class="'.$imageColCSSClass.' text-center">';
    echo $blockImage;
    echo '</div>';
endif;

echo '</div>'; //End of the block inner row

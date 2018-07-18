<?php
namespace Roots\Sage\Shortcodes;

use Roots\Sage\Extras;

add_shortcode('zendeskrating',__NAMESPACE__ . '\\ZenDeskRatingShortCode');
function ZenDeskRatingShortCode($params = null, $content = null) {
    $ch = curl_init('https://thoughtfarmer.zendesk.com/satisfaction.json');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_POSTFIELDS, '');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERPWD, 'carolien@thoughtfarmer.com/token:aXGZxdMDGxgQD7WXCALS8Q31YYbcdyHHsQrrGrpE');

    $results = curl_exec($ch);
    curl_close($ch);

    $results = json_decode($results);
    $satisfactionPercent = 0;

    if (!isset($results->error) && is_array($results) && count($results) > 0 && is_numeric($results[0])) {

        foreach ($results as $rating) {
            if ($rating == 1)
                $satisfactionPercent++;
        }

        update_option('zendesk_rating', $satisfactionPercent);
    } else {
        $satisfactionPercent = get_blog_option(get_current_blog_id(), 'zendesk_rating', 99);
    }

    return '<span class="zendeskRating">'.$satisfactionPercent.'%</span>';
}

add_shortcode('latestwebinar',__NAMESPACE__ . '\\LatestWebinarShortCode');
function LatestWebinarShortCode($params = null, $content = null) {
    return Extras\output_latest_webinar(false, false, false);
}

add_shortcode('button',__NAMESPACE__ . '\\ButtonShortCode');
function ButtonShortCode($params, $content = null) {
    // default parameters
    extract(shortcode_atts(array(
        'url' => '',
        'width' => '',
        'type' => 'outline'
    ), $params));

    if ($width != ''):
        $style = 'style="width:'.$width.';"';
    endif;

    $class = 'btn btn-success-dark';

    if ($type != 'solid')
        $class .= ' btn-outline';

    return '<a href="'.$url.'" class="button '.$class.'" '.$style.'><span>'.$content.'</span></a>';
}

add_shortcode('HubspotForm',__NAMESPACE__ . '\\HubspotFormShortCode');
function HubspotFormShortCode($params, $content = null) {
    global $loadedHubspotForms;

    // default parameters
    extract(shortcode_atts(array(
        'id' => '',
        'portalId' => '2980774',
        'width' => 700,
        'position' => 'left',
        'form_button_id' => ''
    ), $params));

    $formEmbed = '';

    //Don't output our intranet tips form on the blog page.
    if (is_home() && $id == 1183):
        return '';
    endif;

    if (!$loadedHubspotForms): // || !in_array($id, $loadedHubspotForms)):
        $formEmbed = '<!--[if lte IE 8]>
            <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
        <![endif]-->
        <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>';

		$formPlaceholderID = 'form'.$formid.'0';
	else:
		$formPlaceholderID = 'form'.$formid.count($loadedHubspotForms);
	endif;

    $formWrapperClass = 'hubspot-form';

    if (in_array($id, array(1183))):
        $formWrapperClass .= ' inline-form ';
    endif;


    $formStyle = 'max-width: '.$width.'px;';

    if ($position == 'center'):
        $formStyle .= ' margin: 0 auto; ';
    endif;

    $formEmbed .= '<div id="'.$formPlaceholderID.'" class="'.$formWrapperClass.'" style="'.$formStyle.'"></div>';


// <script>
//   hbspt.forms.create({
//     css: '',
//     portalId: '2980774',
//     formId: '65a3588f-0d97-45b7-892b-021e4e8d097e'
//   });
// </script>

    $formEmbed .= "<script>
        jQuery(document).ready(function($) {
            var form = hbspt.forms.create({
                css: '',
                portalId: '".$portalId."',
                formId: '".$id."',
                target: '#".$formPlaceholderID."',
                onFormReady: function() {";

        if ($form_button_id) {
            $formEmbed .= "$('#".$formPlaceholderID." .hs_submit .hs-button').attr('id', '".str_replace(' ', '-', $form_button_id)."');";
        }

        $formEmbed .= "
            var \$referringPageField = $('input[name=\"referring_page\"]');
            console.log($referringPageField);

            if (\$referringPageField.length && document.referrer) {
                console.log('here');
                \$referringPageField.val(document.referrer);
            }
        }";

    $formEmbed .= "
            });
        });
		</script>";

    $loadedHubspotForms[] = $id;

    return $formEmbed;
}

add_shortcode('formbutton',__NAMESPACE__ . '\\FormButtonShortCode');
function FormButtonShortCode($params, $content = null) {
    // default parameters
    extract(shortcode_atts(array(
        'class' => '',
        'width' => '',
        'formid' => ''
    ), $params));

    if ($width != ''):
        $style = 'style="width:'.$width.';"';
    endif;

    $formModalID = 'gformModal'.$formid;

    $output = '<script type="text/javascript">jQuery(document).ready(function($) { enableFormModal(); }); </script>';
    $output .= '<a href="#'.$formModalID.'" class="button gform modal '.$class.'" '.$style.'><span>'.$content.'</span></a>';
    ob_start();
    gravity_form_enqueue_scripts($formid, true);
    $output .= ob_get_contents();
    ob_end_clean();
    $output .= '<div id="'.$formModalID.'" class="hidden">';


    //Gravity forms will always echo the form output so we want to buffer the form echo and then store it to a variable.
    ob_start();
    //gravity_form($id, $display_title=true, $display_description=true, $display_inactive=false, $field_values=null, $ajax=false, $tabindex);
    gravity_form($formid, true, true, false, null, true);
    $output .= ob_get_contents();

    $output = str_replace('</iframe>', '</iframe></div>', $output);
    //$output = str_replace('</script></div>', '</script>', $output);
    ob_end_clean();

    return $output;
}


add_shortcode('tf_demo_steps',__NAMESPACE__ . '\\tf_demo_steps_shortcode');
function tf_demo_steps_shortcode($params, $content = null) {
    $output = '<div class="demo-steps">';

    $demoSteps = get_field('demo_steps');
    $iCount = 0;

    foreach ($demoSteps as $step):
        if ($iCount > 0):
            $output .= '<div class="divider"><div class="dot"></div></div>';
        endif;

        $output .= '<div class="step"><i class="icon icon-'.$step['step_icon'].'"></i><p>'.$step['step'].'</p></div>';
        $iCount++;
    endforeach;

    $output .= '</div>';

    return $output;
}
?>

<?php
foreach (get_sub_field('calls_to_action') as $cta):
    echo '<p class="cta-title">'.$cta['title'].'</p>';

    if ($cta['icon']):
        echo '<p><img src="'.$cta['icon'].'" /></p>';
    endif;

    echo '<p><a href="'.$cta['button_url'].'" class="btn btn-danger btn-lg">'.$cta['button_label'].'</a></p>';
endforeach;

if (get_sub_field('block_footer_description')):
    echo '<p class="block-footer-description">'.get_sub_field('block_footer_description').'</p>';
endif;

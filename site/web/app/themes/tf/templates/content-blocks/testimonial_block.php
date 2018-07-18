<?php
echo '<p class="quote-title">'.get_sub_field('customer').'</p>';

echo '<p class="quote-content">&ldquo;'.get_sub_field('quote').'&rdquo;</p>';

if (get_sub_field('customer_logo')):
    echo '<img src="'.get_sub_field('customer_logo').'" />';
endif;

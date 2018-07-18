<?php
use Roots\Sage\Extras;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php Extras\output_page_intro(); ?>
    <?php
        the_content();

        Extras\output_contact_info_block(get_field('phone_info'), 'Phone');
        Extras\output_contact_info_block(get_field('email_info'), 'Email');
        Extras\output_contact_info_block(do_shortcode(get_field('wufoo_form_code')), 'Form');
        Extras\output_contact_info_block(get_field('address_info'), 'Address');
    ?>
<?php endwhile; endif; ?>

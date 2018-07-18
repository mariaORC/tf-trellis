<?php
$contentOffsetClass = '';
$thumbOffsetClass = '';

if ($counter & 1) {
    $contentOffsetClass = 'col-sm-push-6';
    $thumbOffsetClass = 'col-sm-pull-6';
}
?>
<div class="block-content-wrapper">
    <div class="row">
        <div class="col-xs-12 <?php echo $contentOffsetClass; ?> col-sm-5 col-sm-offset-1 feature-content">
            <div class="inner">
                <h2><?php the_sub_field('title'); ?></h2>
                <p><?php the_sub_field('content'); ?></p>
            </div>
        </div>
        <div class="col-xs-12 <?php echo $thumbOffsetClass; ?> col-sm-6 feature-thumb">
            <?php
            if (get_sub_field('image_style') == 'standard'):
                echo '<img src="'.get_sub_field('background_image').'" />';
            endif;
            ?>
        </div>
    </div>
</div>

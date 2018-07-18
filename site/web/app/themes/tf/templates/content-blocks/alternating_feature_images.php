<?php
use Roots\Sage\Assets;

$contentClass = 'col-sm-5';
$thumbClass = 'col-sm-7';
$containerClass = '';

if (get_sub_field('content_alignment') == 'right') {
    $contentClass .= ' col-sm-push-7';
    $thumbClass .= ' col-sm-pull-5';
}

if (get_sub_field('stretch_image')) {
	$containerClass .= ' stretch-thumb';

	if (get_sub_field('stretch_amount')) {
		$containerClass .= ' stretch-thumb-'.get_sub_field('stretch_amount');
	}
}

//the_sub_field('thumbnail');
//the_sub_field('image_margin');
?>
<div class="container block-content-wrapper <?= $containerClass; ?> content-<?php the_sub_field('content_alignment'); ?>">
    <div class="row valign-center-sm">
        <div class="col-xs-12 <?php echo $contentClass; ?> feature-content">
            <div class="inner">
                <h3><?php the_sub_field('title'); ?></h3>
				<?php the_sub_field('content'); ?>
				<strong><a href="<?= get_sub_field('cta')['block_url']; ?>" class="no-underline link-dark"><?= get_sub_field('cta')['button_label']; ?></a></strong>
            </div>
        </div>
        <div class="col-xs-12 <?php echo $thumbClass; ?> feature-thumb">
			<?php //echo '<img src="'.get_sub_field('thumbnail').'" alt="'.get_sub_field('title').'" />'; ?>
			<?php echo  Assets\get_responsive_image(get_sub_field('thumbnail'), get_sub_field('title'), '', THUMB_CONTENT_BLOCK, 'full', THUMB_CONTENT_BLOCK, 'full', THUMB_PAGE_ILLUSTRATION, THUMB_CONTENT_BLOCK, THUMB_PAGE_ILLUSTRATION_1x, THUMB_PAGE_ILLUSTRATION); ?>
        </div>
	</div>
	<?php if (get_sub_field('block_footer')): ?>
	<div class="block-footer text-center row">
		<?php the_sub_field('block_footer'); ?>
	</div>
	<?php endif; ?>
</div>
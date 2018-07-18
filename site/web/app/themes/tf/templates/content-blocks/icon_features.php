<?php
	$iconPosition = (get_sub_field('icon_position') ? get_sub_field('icon_position') : 'left');
	$thumbClass = 'col col-xs-12 feature-thumb';
	$contentClass = 'col col-xs-12 feature-content';
	$titleTag = ($iconPosition == 'left' ? 'h5' : 'h4');
	$titleClass = 'pad-lg';
	$containerClass = 'gutter-lg';

	if ($iconPosition == 'left'):
		$thumbClass .= ' col-sm-3 col-md-2';
		$contentClass .= ' col-sm-9 col-md-10';
		$titleClass = '';
		$containerClass = '';
	endif;
?>
<div class="container block-content-wrapper <?= $containerClass; ?>">
	<div class="row icons-<?= $iconPosition; ?>">
	<?php
	foreach (get_sub_field('features') as $feature):
	?>
		<div class="col col-xs-12 col-sm-6 icon-feature">
			<div class="row">
				<div class="<?= $thumbClass; ?>">
					<img src="<?= $feature['icon']; ?>" alt="<?= $feature['title']; ?>" />
				</div>
				<div class="<?= $contentClass; ?>">
					<<?= $titleTag; ?> class="<?= $titleClass; ?>"><?= $feature['title']; ?></<?= $titleTag; ?>>
					<?= $feature['content']; ?>
				</div>
			</div>
		</div>
	<?php
		$iCount++;
	endforeach;
	?>
	</div>
</div>
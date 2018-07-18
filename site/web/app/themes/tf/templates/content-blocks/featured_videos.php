<div class="container gutter-lg block-content-wrapper">
	<div class="row">
		<div class="col col-xs-12 text-center">
			<h2 class="dark"><?= get_sub_field('section_title'); ?></h3>
		</div>
	</div>
    <div class="row featured-posts">
	<?php
//	$iCount = 0;

	foreach (get_sub_field('featured_videos') as $feature):
	?>
		<div class="col col-xs-12 col-sm-6 item">
			<a href="<?= $feature['video_url']; ?>&mode=opaque&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;wmode=transparent" class="full-videobox video-play-thumb"><img src="<?= $feature['thumbnail']['url']; ?>" alt="<?= $feature['title']; ?>" /></a>
			<h4 class="pad-lg"><?= $feature['title']; ?></h4>
			<p><?= $feature['description']; ?></p>
		</div>
	<?php
		$iCount++;
	endforeach;
	?>
	</div>
</div>
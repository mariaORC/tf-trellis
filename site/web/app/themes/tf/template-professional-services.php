<?php
/**
 * @package Wordpress
 * @subpackage Thoughtfarmer
 * Template Name: Professional Services Page
 **/
?>
<?php
use Roots\Sage\Extras;
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php Extras\output_flexible_content_blocks(1, false, false, false, true); ?>
        </div>
    </div>
</div>
<br/>

<?php get_template_part('templates/content-part', 'testimonials'); ?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<?php
			if (get_field('consulting_streams_title')):
				echo '<h3 class="section-title">'.get_field('consulting_streams_title').'</h3>';
			endif;
			if (get_field('consulting_streams_intro')):
				echo '<p class="section-intro">'.get_field('consulting_streams_intro').'</p>';
			endif;

			if (get_field('consulting_streams')):
			?>
			<div class="row">
				<?php
				$itemCount = 0;
				$streamCount = 0;
				foreach (get_field('consulting_streams') as $stream):
				?>
				<div class="col-sm-12 stream">
					<div class="row">
						<div class="col-sm-4 stream-description">
							<h3><?php echo $stream['title']; ?></h3>
							<p><strong>What it is:</strong> <?php echo $stream['what_it_is']; ?></p>
							<p><strong>Our goal:</strong> <?php echo $stream['our_goal']; ?></p>
						</div>
						<div class="col-sm-8 stream-items">
							<strong>Activities</strong>
							<?php
							echo '<div class="panel-group" id="accordion'.$streamCount.'">';

							foreach ($stream['stream_details'] as $item):
							?>
							  <div class="panel panel-default">
							    <div class="panel-heading">
							        <a data-toggle="collapse" href="#collapse<?php echo $itemCount; ?>" class="collapsed">
							          <?php echo $item['title']; ?>
							        </a>
							    </div>
							    <div id="collapse<?php echo $itemCount; ?>" class="panel-collapse collapse">
							      <div class="panel-body">
							        <?php echo do_shortcode($item['description']); ?>
							      </div>
							    </div>
							  </div>
							<?php
								$itemCount++;
							endforeach;

							echo '</div>';
							?>
						</div>
					</div>
				</div>
				<?php
					$streamCount++;
				endforeach
				?>
			</div>
			<?php
			endif;

			foreach (get_field('footer_key_features') as $feature):
				echo '<h3 class="section-title">'.$feature['title'].'</h3>';
				echo '<div class="section-intro">'.$feature['content'].'</div>';
			endforeach;
			?>
		</div>
	</div>
</div>

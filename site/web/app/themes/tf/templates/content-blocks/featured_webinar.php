<?php
use Roots\Sage\Extras;

$webinar = Extras\get_latest_webinar();

if ($webinar):
?>
<div class="container-fluid limit block-content-wrapper">
	<div class="row">
		<div class="webinar-details-inline">
			<?php
			echo '<div class="webinar-title item">'.ltrim($webinar->post_title, 'Webinar: ').'</div>';

			echo '<div class="webinar-time-details">';

			if (get_field('webinar_date_&_time', $webinar->ID)):
				echo '<div class="webinar-date item d-inline-block"><i class="icon-calendar"></i> '.get_field('webinar_date_&_time', $webinar->ID).'</div>';
			endif;

			if (get_field('location', $webinar->ID)):
				echo '<div class="webinar-location item d-inline-block"><i class="icon-location-arrow"></i> '.get_field('location', $webinar->ID).'</div>';
			endif;

			echo '</div>';

			echo '<div class="webinar-cta item"><a href="'.get_permalink($webinar->ID).'" class="btn btn-success-dark btn-outline btn-short">Learn More</a></div>';
			?>
		</div>
	</div>
</div>
<?php endif; ?>
<div id="case-studies-clients">
	<h3 style="text-align: center;" class="section-title"><?php the_field('client_logos_title'); ?></h3>
	<div class="image-grid">
		<?php
		if (get_field('client_logos')):
			foreach (get_field('client_logos') as $clientLogo):
				echo '<div><img src="'.$clientLogo['url'].'" alt="'.$clientLogo['title'].'" /></div>';
			endforeach;
		endif;
		?>
	</div>
</div>
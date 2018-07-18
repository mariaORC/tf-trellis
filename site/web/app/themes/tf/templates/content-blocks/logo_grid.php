<div class="client-logos-wrap container">
	<div class="row">
		<div class="col-xs-12">
			<h3 style="text-align: center;" class="section-title"><?= get_sub_field('section_title'); ?></h3>
			<div class="image-grid">
				<?php
				foreach (get_sub_field('logos') as $clientLogo):
					echo '<div><img src="'.$clientLogo['url'].'" alt="'.$clientLogo['title'].'" /></div>';
				endforeach;
				?>
			</div>
		</div>
	</div>
</div>
<?php
use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

get_template_part('templates/head');
?>
<!--begin base-template-case-studies-->
<body <?php body_class(); ?>>
  <div class="page-container">
	<?php
		$_SERVER['QUICK_CACHE_ALLOWED'] = FALSE;
		do_action('get_header');
		get_template_part('templates/header');
	?>

	<?php include Wrapper\template_path(); ?>

	</div>
	<?php get_template_part('templates/footer'); ?>
</body>
<!--end base-template-case-studies-->
</html>

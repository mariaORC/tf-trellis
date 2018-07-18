<?php
use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

get_template_part('templates/head');
?>
<body <?php body_class(); ?>>
    <!--begin base-template-support-->
  <div class="page-container support-section">
	<?php
		$_SERVER['QUICK_CACHE_ALLOWED'] = FALSE;
		do_action('get_header');
		get_template_part('templates/header-support');
	?>

	<?php include Wrapper\template_path(); ?>

	</div>
	<?php get_template_part('templates/footer-support'); ?>
</body>
<!--end base-template-support-->
</html>

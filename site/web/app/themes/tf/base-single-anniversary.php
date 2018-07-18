<?php
use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

get_template_part('templates/head');
?>
<body <?php body_class(); ?>>
  <div class="page-container">
	<?php include Wrapper\template_path(); ?>
	<?php wp_footer(); ?>
</body>
</html>

<?php
/**
 * @package Wordpress
 * @subpackage Thoughtfarmer
 * Template Name: Support Search Page
 **/
?>
<?php
use Roots\Sage\Extras;
?>
<div class="wrap" role="document">
	<div class="content-header valign-center">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 text-center">
					<h1>ThoughtFarmer Support</h1>
					<?php
					if (!$_GET["addsearch"] || $_GET["addsearch"] == ''):
					echo '<h4 class="entry-title">What would you like to search for?</h4>';
					endif;
					?>
				</div>
				<div class="col-sm-10 col-sm-offset-1 col-xs-12 support-intro">
					<input type="text" class="addsearch form-control" placeholder="Search..." />

				<?php
//				$searchSite = 'www.thoughtfarmer.com';

//				if ((array_key_exists('site', $_GET) && $_GET['site'] == 'documentation') || get_current_blog_id() == 8):
					$searchSite = 'documentation.thoughtfarmer.com';
//				endif;
				?>

				<script src="https://addsearch.com/js/?key=5af80926e7841f194bff5df88ea229b6&type=resultpage&categories=0x<?php echo $searchSite; ?>"></script>
				</div>
			</div>
		</div>
	</div>
	<div class="container support-promise">
		<div class="content row">
			<div class="col-sm-10 col-sm-offset-1 col-xs-12 support-intro">
				<div id="addsearch-results"></div>
			</div>
		</div>
	</div>
</div>

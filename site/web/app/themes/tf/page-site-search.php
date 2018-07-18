<?php
use Roots\Sage\Extras;
?>

<?php /*
<h1 class="text-center">
  <?php
    if ($_GET["addsearch"] && $_GET["addsearch"] != ''):
      echo 'Results for your search: &ldquo;'.trim(str_replace('"', '', strip_tags($_GET["addsearch"]))).'&rdquo;';
    else:
      echo 'What would you like to search for?';
    endif;
  ?>
</h1>
<br/><br/>
*/ ?>
<?php the_content(); ?>

<input type="text" class="addsearch form-control" placeholder="Search..." />

<div id="addsearch-results"></div>

<?php
$searchSite = 'www.thoughtfarmer.com';

if ((array_key_exists('site', $_GET) && $_GET['site'] == 'documentation') || get_current_blog_id() == 8):
	$searchSite = 'documentation.thoughtfarmer.com';
endif;
?>

<script src="https://addsearch.com/js/?key=5af80926e7841f194bff5df88ea229b6&type=resultpage&categories=0x<?php echo $searchSite; ?>"></script>

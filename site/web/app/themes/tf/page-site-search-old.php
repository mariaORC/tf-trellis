<?php
use Roots\Sage\Extras;
?>

<?php
if (!$_GET["q"] || $_GET["q"] == ''):
  echo '<h4 class="entry-title">What would you like to search for?</h4>';
endif;
?>
<?php /*
<h4 class="entry-title">
  <?php
    if ($_GET["q"] && $_GET["q"] != ''):
      echo 'Results for your search: &ldquo;'.trim(str_replace('"', '', strip_tags($_GET["q"]))).'&rdquo;';
    else:
      echo 'What would you like to search for?';
    endif;
  ?>
</h4>
*/ ?>
   <script>
    (function() {
      var cx = '018079336436963464435:gv9fbd0sv-u';
      var gcse = document.createElement('script');
      gcse.type = 'text/javascript';
      gcse.async = true;
      gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(gcse, s);
    })();
  </script>
  <div id="cse">
    <?php if (array_key_exists('site', $_GET) && $_GET['site'] == 'documentation'): ?>
      <gcse:search as_sitesearch="documentation.thoughtfarmer.com"></gcse:search>
    <?php else: ?>
      <gcse:search></gcse:search>
    <?php endif; ?>
  </div>

<?php /*
  <div id="cse" style="width: 100%;">Loading</div>
  <script src="//www.google.com/jsapi" type="text/javascript"></script>
  <script type="text/javascript">
    google.load('search', '1', {language : 'en', style : google.loader.themes.ESPRESSO});

    google.setOnLoadCallback(function() {
      var customSearchOptions = {};

      <?php if (array_key_exists('site', $_GET) && $_GET['site'] == 'documentation'): ?>
        customSearchOptions[google.search.Search.RESTRICT_EXTENDED_ARGS] = {'as_sitesearch' : 'www.thoughtfarmer.com/documentation'};
      <?php endif; ?>

      var customSearchControl = new google.search.CustomSearchControl(
        '018079336436963464435:gv9fbd0sv-u', customSearchOptions);

      google.search.Csedr.addOverride("mysite_");
      customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);

      customSearchControl.draw('cse');

      customSearchControl.execute("<?php echo str_replace('"', '', strip_tags($_GET["q"])); ?>");
    }, true);
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('#gsc-i-id1').live('focus',function() {this.value = '';});

      $('#gsc-i-id1').live('change', function(){
          setSearchTitle();
      });

      $('#gsc-i-id1').live('keyup', function(e){
        var code= (e.keyCode ? e.keyCode : e.which);
        if (code == 10 || code == 13) {
          setSearchTitle();
        }
      });

      function setSearchTitle() {
          var query = $('#gsc-i-id1').val();

          //if (query != '')
          //  $('h4.entry-title').html("Results for your search: &ldquo;"+query+"&rdquo;");
          //else
          //  $('h4.entry-title').html("  What would you like to search for?");
      }
    });
  </script>
*/ ?>

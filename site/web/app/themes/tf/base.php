<?php
use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

get_template_part('templates/head');
?>
<body <?php body_class(); ?>>
  <div class="page-container">
  <?php
    do_action('get_header');
    get_template_part('templates/header');
  ?>
  <div class="wrap" role="document">
    <div class="container">
      <div class="content row">
        <main class="main <?php echo Wrapper\roots_main_class(); ?>" role="main">
          <?php include Wrapper\template_path(); ?>
          <?php
          $nextPage = get_field('next_page');

          if ($nextPage):
            echo '<div class="next-page text-right"><a href="'.get_permalink($nextPage->ID).'">Next : '.$nextPage->post_title.'</a></div>';
          endif;
          ?>
        </main><!-- /.main -->
        <?php if (Setup\display_sidebar()) : ?>
          <aside class="sidebar <?php echo Wrapper\roots_sidebar_class(); ?>" role="complementary">
            <?php include Wrapper\sidebar_path(); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
      </div><!-- /.content -->
    </div>

    <?php if ($post->ID == 11): //Demo Page ?>
        <script type="text/javascript">
          var player;
          function onYouTubeIframeAPIReady() {
            //this is the id of your video
            player = new YT.Player('demo-video-embed');
          }
          //call this function from your links onclick
          function demoPlayVideo() {
            if(player) {
              player.playVideo();
            }
          }
          //this loads the youtube api
          var tag = document.createElement('script');
          tag.src = "https://www.youtube.com/iframe_api";
          var firstScriptTag = document.getElementsByTagName('script')[0];
          firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

          jQuery(document).ready(function($) {
            $('#demo-video a').click(function(e) {
              $(this).hide();
              $('#demo-video-embed').show();

              demoPlayVideo();
              e.preventDefault();
            });
          });
        </script>
        <div id="demo-video" class="container-fluid">
          <a href="#" class="jumbotron text-center" style="background-image: url(<?php the_field('video_thumbnail'); ?>);">
            <h1><?php the_field('video_title'); ?></h1>

            <p><?php the_field('video_description'); ?></p>
          </a>
          <div class="embed-responsive embed-responsive-16by9">
            <iframe id="demo-video-embed" style="display: none;" class="embed-responsive-item" width="1200" height="675" src="https://www.youtube.com/embed/<?php the_field('demo_video_youtube_id'); ?>?enablejsapi=1" frameborder="0" allowfullscreen></iframe>
          </div>
        </div>
    <?php endif; ?>

  </div><!-- /.wrap -->
  </div>
  <?php get_template_part('templates/footer'); ?>
</body>
</html>

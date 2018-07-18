<?php use Roots\Sage\Extras; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <?php Extras\output_flexible_content_blocks(1, false, false, false, true); ?>
        </div>
    </div>
</div>

<?php
if (have_posts()) : while (have_posts()) : the_post();

$screenshots = get_field('screenshots');

if ($screenshots && get_field('screenshot_style') != 'tabs'):
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div id="screenshot-carousel" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
            <?php
              $iCount = 0;

              foreach ($screenshots as $screenshot):
                $screenshot['caption'];

                echo '<div class="item '.($iCount == 0 ? 'active' : '').'">
                  <img src="'.$screenshot['url'].'" alt="'.$screenshot['caption'].'">
                  <div class="carousel-caption">'.$screenshot['caption'].'</div>
                </div>';

                $iCount++;
              endforeach;

            ?>
              </div>
              <a class="left carousel-control" href="#screenshot-carousel" role="button" data-slide="prev">
                <span class="icon-angle-left"></span>
              </a>
              <a class="right carousel-control" href="#screenshot-carousel" role="button" data-slide="next">
                <span class="icon-angle-right"></span>
              </a>
            </div>
        </div>
    </div>
</div>
<?php
endif;

$testimonials = get_field('client_testimonials');

if ($testimonials):
?>
<div class="testimonial-wrap testimonial-<?php the_field('testimonial_style'); ?>">
    <div class="container<?php if (get_field('testimonial_style') == 'carousel'): echo '-fluid'; endif; ?>">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="section-title text-center"><?php the_field('testimonial_heading'); ?></h2>
                <?php
                  if (get_field('testimonial_intro')):
                       echo '<p class="section-intro text-center">'.get_field('testimonial_intro').'</p>';
                  endif;
                ?>
            </div>
            <div class="col-xs-12">
                <?php if (get_field('testimonial_style') != 'carousel'): ?>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs testimonials-tabs" role="tablist">
                      <?php
                      $iCount = 0;

                      foreach ($testimonials as $testimonial):
                        echo '<li class="'.($iCount == 0 ? 'active' : '').'"><a href="#tab'.$iCount.'" role="tab" data-key="'.$iCount.'" data-toggle="tab">'.$testimonial['company'].'</a></li>';
                      ?>
                      <?php
                        $iCount++;
                      endforeach; ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <?php
                      $iCount = 0;

                      foreach ($testimonials as $testimonial):
                        echo '<div class="tab-pane testimonial '.($iCount == 0 ? 'active' : '').'" id="tab'.$iCount.'">';

                        if ($testimonial['feature_image']):
                          echo '<div class="row"><div class="col-sm-5">';

                           echo '<img src="'.$testimonial['feature_image'].'" width="390" alt="'.get_the_title().'" />';

                          echo '</div><div class="col-sm-6 col-md-push-1"><div class="quote-wrapper">';
                        endif;

                        echo '<div class="quotation"><p>'.$testimonial['quote'].'</p></div>';
                        echo '<p><span class="author">'.$testimonial['author'].'</span><br/><span class="position">'.$testimonial['job_title'].'</span></p>';

                        if ($testimonial['article_link_url'])
                          echo '<a href="'.$testimonial['article_link_url'].'">'.$testimonial['article_link_label'].'</a>';

                        if ($testimonial['feature_image'])
                          echo '</div></div></div>';

                        echo '</div>';
                        $iCount++;
                      endforeach; ?>

                      <script>
                        jQuery(document).ready(function($) {
                          $('.testimonials-tabs a').hover(function(){
                            $(this).tab('show');
                          });
                        });
                      </script>
                    </div>
                <?php else: ?>
                    <div id="testimonial-carousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <?php
                            $iCount = 0;

                            foreach ($testimonials as $testimonial):
                            ?>
                                <li data-target="#testimonial-carousel" data-slide-to="<?php echo $iCount; ?>" class="<?php echo ($iCount == 0 ? 'active' : ''); ?>"></li>
                            <?php
                                $iCount++;
                            endforeach;
                            ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php
                            $iCount = 0;

                            foreach ($testimonials as $testimonial):
                            ?>
                                <div class="item <?php echo ($iCount == 0 ? 'active' : ''); ?>">
                                    <div class="quote-wrapper col-xs-12 col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 text-center">
                                        <?php
                                            if ($testimonial['feature_image']):
                                                echo '<img src="'.$testimonial['feature_image'].'" alt="'.get_the_title().'" />';
                                            endif;

                                            echo '<p class="author">'.$testimonial['company'].', '.$testimonial['author'].'</p>';
                                            echo '<div class="quotation"><p>'.$testimonial['quote'].'</p></div>';

                                            if ($testimonial['article_link_url']):
                                                echo '<a href="'.$testimonial['article_link_url'].'">'.$testimonial['article_link_label'].'</a>';
                                            endif;
                                        ?>
                                    </div>
                                </div>
                            <?php
                                $iCount++;
                            endforeach;
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
$featuredResources = get_field('featured_resource');

if ((get_field('more_resources') || $featuredResources) && get_field('resource_style') == 'list'):
?>
<div class="resource-wrap resource-<?php the_field('resource_style'); ?>">
    <div class="container">
        <div class="row">
            <div class="col-xs-12"><h3 class="section-title text-center"><?php the_field('more_resources_heading'); ?></h3></div>
            <div class="col-sm-6 more-resources">
              <div class="inner">
                <?php the_field('more_resources'); ?>
              </div>
            </div>
            <div class="col-sm-6 paint-splash more-resources">
              <div class="inner">
                <?php
                  if ($featuredResources):
                    $featuredResource = $featuredResources[0];
                    $featuredImage = get_field('featured_resource_image');

                    if ($featuredImage):
                      echo '<div class="row"><div class="col-xs-4"><img src="'.$featuredImage['url'].'" title="'.get_the_title($featuredResource->ID).'" /></div><div class="col-xs-8">';
                    endif;

                    echo '<p class="title"><a href="'.get_permalink($featuredResource->ID).'">'.get_the_title($featuredResource->ID).'</a></p>';
                    echo '<p>'.get_field('featured_resource_summary').'</p>';

                    if ($featuredImage):
                      echo '</div></div>';
                    endif;
                  endif;
                ?>
              </div>
            </div>
        </div>
    </div>
</div>
<?php
elseif (get_field('featured_resources') && get_field('resource_style') == 'tiles'):
    $featuredResources = get_field('featured_resources');
    $colWidth = 12 / count($featuredResources);
?>
<div class="resource-wrap equalize-heights resource-<?php the_field('resource_style'); ?>">
    <div class="container-fluid limit">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <h2 class="section-title text-center"><?php the_field('more_resources_heading'); ?></h2>
            </div>
        </div>
        <div class="row">
    <?php

        foreach($featuredResources as $resource):
            $featuredImage = ($resource['image'] ? $resource['image'] : get_the_post_thumbnail_url($resource['resource']->ID, 'full'));

            echo '<div class="col-xs-12 col-sm-'.$colWidth.'"><div class="resource-tile">';

            $resourceTitle = ($resource['title_override'] ? $resource['title_override'] : $resource['resource']->post_title);

            $resourceDescription = ($resource['resource_description'] ? $resource['resource_description'] : get_the_excerpt($resource['resource']->ID));


            if ($featuredImage):
              echo '<div class="icon height-target valign-center"><a href="'.get_permalink($resource['resource']->ID).'"><img src="'.$featuredImage.'" title="'.$resourceTitle.'" /></a></div>';
            endif;

            echo '<h4 class="title"><a href="'.get_permalink($resource['resource']->ID).'">'.$resourceTitle.'</a></h4><p>'.$resourceDescription.'</p>';

            echo '</div></div>';
        endforeach;
    ?>
        </div>
    </div>
</div>
<?php
endif;
?>
<?php endwhile; endif; ?>

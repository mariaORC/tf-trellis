<?php
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
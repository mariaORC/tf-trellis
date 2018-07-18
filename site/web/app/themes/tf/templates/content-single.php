<?php use Roots\Sage\Extras; ?>
<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <?php Extras\entry_social_links(); ?>
    <div class="entry-content">
        <?php

        if (is_user_logged_in() && 1 == 2):
            //Apply inline styles for the tags in the blog post in order to utilize the Mailchimp-to-RSS funcionality.
            require_once(get_template_directory().'/lib/simple_html_dom.php');
            require_once(get_template_directory().'/lib/simple_html_dom_utility.php');

            $content = apply_filters('the_content',get_the_content());

            $contentHTML = str_get_html($content);

            foreach($contentHTML->find('img.alignright') as $element):
                $element->style = 'float: right; margin: 0 0 15px 15px;'.$element->style;
            endforeach;

            foreach($contentHTML->find('img.alignleft') as $element):
                $element->style = 'float: left; margin: 0 15px 15px 0;'.$element->style;
            endforeach;

            foreach($contentHTML->find('div.wp-caption') as $element):
                $element->style = 'background: #fff; border: 1px solid #C7C7BE; border-radius: 6px; font-style: italic; padding: 7px; max-width: 570px; margin: 20px 0; padding: 10px;';
            endforeach;

            foreach($contentHTML->find('div.wp-caption img') as $element):
                $element->style = 'max-width: 570px; height: auto;';
            endforeach;

            foreach($contentHTML->find('div.wp-caption-text') as $element):
                $element->style = 'margin: 7px 0 0 0;';
            endforeach;

            foreach($contentHTML->find('h2') as $element):
                $element->style = 'font-size: 22px; line-height: 24px; font-weight: bold!important; text-transform: none; font-family: Georgia, Serif, Times; margin-top: 5px;';
            endforeach;

            foreach($contentHTML->find('.marketing-snipplet') as $element):
                $element->style = 'border: solid 1px #efe3ae!important; background: #fef6d2!important; border-radius: 7px; color: #6c4b04!important; display: block; margin-bottom: 15px; padding: 7px 12px!important;';
            endforeach;

            foreach($contentHTML->find('a') as $element):
                $element->style = 'color:#A23D00;';
            endforeach;

            echo $contentHTML;
        else:
            the_content('<p class="serif">Read the rest of this entry &raquo;</p>');
        endif;
        ?>
        </div>

        <?php Extras\entry_social_links(); ?>

        <div class="related-posts row">
            <div class="col-sm-12"><h3 class="title">Recommended Reading</h3></div>
        <?php
        //Output two related posts for this article. Users can custom select the related posts or optionally we will find
        //related posts that match this posts category.
        $customRelatedPosts = get_field('related_posts');
        $numCustomDefinedPosts = 0;
        $relatedPostIndex = 1;

        if (!empty($customRelatedPosts)) {
            $numCustomDefinedPosts = count($customRelatedPosts);

            foreach ($customRelatedPosts as $relatedPost) {
                Extras\output_related_blog_post($relatedPost['related_post'], $relatedPost['alternate_feature_image'], $relatedPostIndex);
                $relatedPostIndex++;
            }
        }

        if ($numCustomDefinedPosts < 2) {
            $customRelatedPosts = get_posts(
                array(
                    'category__in' => wp_get_post_categories($post->ID),
                    'numberposts' => (2-$numCustomDefinedPosts),
                    'post__not_in' => array($post->ID)
                )
            );

            if($customRelatedPosts) {
                foreach($customRelatedPosts as $relatedPost) {
                    Extras\output_related_blog_post($relatedPost, '', $relatedPostIndex);
                    $relatedPostIndex++;
                }
            }

            wp_reset_postdata();
        }
        ?>
    </div>
    <script>
        jQuery(window).load(function() {
            if ($(this).width() > 650) {
                equalizeRowHeights(".related-posts .related-post .well");
            }

            $(window).resize(function() {
                if ($(this).width() > 650)
                    equalizeRowHeights(".related-posts .related-post .well");
                else
                    $(".related-posts .related-post .well").height('auto');
            });
        });
    </script>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

    <footer>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>

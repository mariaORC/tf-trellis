<?php
use Roots\Sage\Extras;
?>

<dl class="widget featuredPosts">
    <dt class="heading"><h5><a href="/blog/">Featured</a></h5></dt>
    <dd>
        <ul class="styledList posts">
            <!-- Show x Featured Posts -->
            <?php
            query_posts('showposts=5&category_name=Featured&order=DESC&orderby=date');

            $counter = 0;

            while (have_posts()) : the_post();
                ?>
                <li class="<?php echo ($counter == 0 ? 'first' : ''); ?>">
                    <span class="date"><?php the_time('l, F j, Y'); ?></span><br/>
                    <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </li>
            <?php
                $counter++;
            endwhile;
            ?>
        </ul>
        <div class="clear"></div>
    </dd>
</dl>
<?php /*
<dl class="widget">
    <dt class="heading"><a href="/about/team/">Contributors</a></dt>
    <dd>
        <ul class="styledList userList clearfix">
            <?php
            global $wpdb;
            $authors = array();

            foreach ( (array) $wpdb->get_results("SELECT DISTINCT p.post_author FROM $wpdb->posts p inner join $wpdb->users u on p.post_author = u.ID WHERE post_type = 'post' AND u.ID <> 1 AND " . get_private_posts_cap_sql( 'post' ). " order by u.display_name") as $row):
                $author = get_userdata( $row->post_author );

                $name = $author->display_name;

                if ($author->first_name != '' && $author->last_name != '')
                    $name = "$author->first_name $author->last_name";

                $userQueryArgs = array(
                    'post_type' => array(TYPE_PERSON),
                    'posts_per_page' => '-1',
                    'suppress_filters' => true,
                    'meta_key' => 'page_user_id',
                    'meta_value' => $author->ID,
                );

                $authorURL = '';

                global $post;
                $tmp_post = $post;

                // get blog posts in PORTFOLIO category
                $userProfilePage = get_posts($userQueryArgs);

                if ($userProfilePage):
                    $authorURL = '/about/team/#person'.$userProfilePage[0]->ID;
                else:
                    $authorURL = get_author_posts_url($author->ID, $name);
                endif;

                if ($userProfilePage):
                    $post = $userProfilePage[0];
                    setup_postdata($post);

                    $photoID = get_field('photo');
                    $thumbnail = '';

                    if ($photoID):
                        $thumbnail = wp_get_attachment_image_src($photoID, THUMB_BLOG_AUTHOR);
                        $thumbnail = '<img src="'.$thumbnail[0].'" class="photo" />';
                    endif;

                    array_push($authors, array(
                            'url' => $authorURL,
                            'thumbnail' => $thumbnail,
                            'position' => get_field('position'),
                            'order' => $post->menu_order,
                            'name' => $name
                        ));
                else:
                    array_push($authors, array(
                            'url' => $authorURL,
                            'thumbnail' => '',
                            'position' => '',
                            'order' => '10',
                            'name' => $name
                        ));
                endif;

                $post = $tmp_post;
            endforeach;

            //Sort the authors based on their page order.
            usort($authors, "custom_sort");
            function custom_sort($a,$b) { return $a['order']>$b['order']; }

            foreach ($authors as $author):
                echo '<li>';

                if ($userProfilePage):
                    echo '<a href="'.$author['url'].'">'.$author['thumbnail'].'</a>';
                    echo '<div class="desc">
                            <h3><a href="'.$author['url'].'">'.$author['name'].'</a></h3>
                            <p>'.$author['position'].'</p>
                        </div>';
                else:
                    echo '<a href="'.$author['url'].'">'.$author['name'].'</a>';
                endif;

                echo '</li>';
            endforeach;
            ?>
        </ul>
        <div class="clear"></div>
    </dd>
</dl>
*/ ?>
<dl class="widget categoriesList">
    <dt class="heading"><h5>Categories</h5></dt>
    <dd>
        <ul class="styledList categories">
            <?php wp_list_categories('orderby=name&title_li='); ?>
        </ul>
        <div class="clear"></div>
    </dd>
</dl>
<dl class="widget twitterWidget">
    <dt class="heading"><h5><a href="http://www.twitter.com/thoughtfarmer/">Twitter</a></h5></dt>
    <dd>
        <?php echo do_shortcode('[twitter-widget username="thoughtfarmer" title="" items="3" showintents="false" showfollow="false" hidefrom="true" showts="432000" hidereplies="false" hiderss="true"]'); ?>
        <div class="clear"></div>
    </dd>
</dl>

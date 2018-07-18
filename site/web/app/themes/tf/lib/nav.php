<?php
/**
 * Cleaner walker for wp_nav_menu()
 *
 * Walker_Nav_Menu (WordPress default) example output:
 *   <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8"><a href="/">Home</a></li>
 *   <li id="menu-item-9" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9"><a href="/sample-page/">Sample Page</a></l
 *
 * Roots_Nav_Walker example output:
 *   <li class="menu-home"><a href="/">Home</a></li>
 *   <li class="menu-sample-page"><a href="/sample-page/">Sample Page</a></li>
 */
class Roots_Nav_Walker extends Walker_Nav_Menu {
  function check_current($classes) {
    return preg_match('/(current[-_])|active|dropdown/', $classes);
  }

  function start_lvl(&$output, $depth = 0, $args = array()) {
    $output .= "\n<ul class=\"dropdown-menu\">\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $item_html = '';
    parent::start_el($item_html, $item, $depth, $args);

    if ($item->is_dropdown && ($depth === 0)) {
      //$item_html = str_replace('<a', '<a class="dropdown-toggle" data-toggle="dropdown" data-target="#"', $item_html);
//      $item_html = str_replace('</a>', ' <b class="caret"></b></a>', $item_html);
    }
    elseif (stristr($item_html, 'li class="divider')) {
      $item_html = preg_replace('/<a[^>]*>.*?<\/a>/iU', '', $item_html);
    }
    elseif (stristr($item_html, 'li class="dropdown-header')) {
      $item_html = preg_replace('/<a[^>]*>(.*)<\/a>/iU', '$1', $item_html);
    }

    $item_html = apply_filters('roots_wp_nav_menu_item', $item_html);
    $output .= $item_html;
  }

  function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
    $element->is_dropdown = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));

    if ($element->is_dropdown) {
      $element->classes[] = 'dropdown';
    }

    parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
  }
}

/**
 * Remove the id="" on nav menu items
 * Return 'menu-slug' for nav menu classes
 */
function roots_nav_menu_css_class($classes, $item) {
  $slug = sanitize_title($item->title);
  $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|ancestor))/', 'active', $classes);
  $classes = preg_replace('/^((depth|menu|page)[-_\w+]+)+/', '', $classes);

  $classes[] = 'menu-' . $slug;

  $classes = array_unique($classes);

  return array_filter($classes, 'is_element_empty');
}
add_filter('nav_menu_css_class', 'roots_nav_menu_css_class', 10, 2);
add_filter('nav_menu_item_id', '__return_null');

function is_element_empty($element) {
  $element = trim($element);
  return !empty($element);
}

function get_top_parent($postid){
   $currentPost = get_page($postid);

   if ($currentPost->post_parent == 0) {
      return $currentPost;
   }
   else {
      return get_top_parent($currentPost->post_parent);
   }
}

/**
 * Clean up wp_nav_menu_args
 *
 * Remove the container
 * Use Roots_Nav_Walker() by default
 */
function roots_nav_menu_args($args = '') {
  $roots_nav_menu_args['container'] = false;

  if (!$args['items_wrap']) {
    $roots_nav_menu_args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
  }

  if (current_theme_supports('bootstrap-top-navbar') && !$args['depth']) {
    $roots_nav_menu_args['depth'] = 2;
  }

  if (!$args['walker']) {
    $roots_nav_menu_args['walker'] = new Roots_Nav_Walker();
  }

  return array_merge($args, $roots_nav_menu_args);
}
add_filter('wp_nav_menu_args', 'roots_nav_menu_args');

function get_sub_nav($post) {
    if ($post->post_parent):
        $postParent = get_top_parent($post->ID);
        $topParentURL = get_permalink($postParent);
        $topParentID = $postParent->ID;
        $topParentCSSClass = '';
        $subParent = get_top_menu_sub_parent($post->ID);
    else:
        $topParentURL = get_permalink($post->ID);
        $topParentID = $post->ID;
        $topParentCSSClass = 'current-menu-item';
    endif;

    if ($topParentID == 17702 && strpos($post->post_name, 'version') !== false):
        $menu = wp_nav_menu(array('menu' => 'Versions', 'echo' => false, 'menu_class' => 'custom-menu'));
    elseif ($post->ID == 468 || $topParentID == 468 || $post->post_parent == 468):
        $menu = wp_nav_menu(array('menu' => 'About Menu', 'echo' => false, 'menu_class' => 'custom-menu'));
    else:
        $menu = wp_nav_menu(array('theme_location' => 'primary', 'walker'=>new Selective_Walker(), 'echo' => false));
    endif;

   $menu = (string)str_replace(array("\r", "\r\n", "\n", "\t", '<ul class="sub-menu"><ul class="sub-menu"></ul></ul>'), '', $menu);
   $menu = str_replace('<ul class="sub-menu"></ul>', '', $menu);
   $menu = str_replace('<ul class="sub-menu"></ul>', '', $menu);

   $topParent = get_post($topParentID);

   if ($post->post_parent && $topParentID != $post->post_parent)
    $menu = str_replace('menu-'.$topParent->post_name, 'menu-'.$topParent->post_name.' current-page-grandparent', $menu);

   if (strpos($menu, '<li') !== false):
        $menu = '<div id="subNav">'.preg_replace('/menu-item /', 'first menu-item ', $menu, 1).'</div>';
   else:
        $menu = '';
   endif;

   return $menu;
}

function output_case_study_nav($currentPagePostID) {
    output_post_type_nav($currentPagePostID, TYPE_CASE_STUDY);
}

function output_post_type_nav($currentPagePostID, $postType) {
    // left sidebar menu: blog posts in 'service' category
    $args = array(
        'post_type' => array($postType),
        'order' => 'ASC',
        'orderby' => 'title',
        'posts_per_page' => '-1',
        'suppress_filters' => true
    );

    // get blog posts in category
    query_posts($args);

    $count = 0;
    echo '<div id="subNav">';
    echo '<ul id="'.$postType.'-sub-nav" class="menu"><ul class="sub-menu">';

    if (have_posts()):
        while (have_posts()) : the_post();
            $cssClass = '';

            if ($count == 0)
                $cssClass = 'first ';

            if (get_the_ID() == $currentPagePostID)
                $cssClass .= 'active';

            echo '<li class="' . $cssClass . '"><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            $count++;
        endwhile;
    endif;

    echo '</ul></ul></div>';
    //Reset Query
    wp_reset_query();
}

class Selective_Walker extends Walker_Nav_Menu {
    /**
     * @see Walker::$tree_type
     * @since 3.0.0
     * @var string
     */
    var $tree_type = array('post_type', 'taxonomy', 'custom');
    /**
     * @see Walker::$db_fields
     * @since 3.0.0
     * @todo Decouple this.
     * @var array
     */
    var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');

    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    /**
     * @see Walker::end_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function end_lvl(&$output, $depth = 0, $args = array()) {
        global $current_branch;
        if ($depth == 0)
            $current_branch = false;
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param int $current_page Menu item ID.
     * @param object $args
     */
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $wp_query;
        global $current_branch;



        if ($current_branch && $depth > 0) {
            $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
            $class_names = ' class="' . esc_attr($class_names) . ' subdepth'.$depth.'"';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . '>';

            $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
            $attributes .= ! empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '><div>';

            $item_output .= $args->link_before . ($depth == 1 ? 'Overview' : apply_filters('the_title', $item->title, $item->ID)) . $args->link_after;
            $item_output .= '</div></a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }

    /**
     * @see Walker::end_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Page data object. Not used.
     * @param int $depth Depth of page. Not Used.
     */
    function end_el(&$output, $item, $depth = 0, $args = array()) {
        global $current_branch;
        if ($current_branch && $depth > 0)
            $output .= "</li>\n";
        if ($depth == 0)
            $current_branch = 0;
    }

}


function page_in_menu($menu = null, $object_id = null) {
    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object($locations['primary']);
    $menu_object = wp_get_nav_menu_items($menu->term_id);

    if(!$menu_object)
        return false;

    $menu_items = wp_list_pluck( $menu_object, 'object_id' );

    if( !$object_id ) {
        global $post;
        $object_id = get_queried_object_id();
    }

    return in_array((int) $object_id, $menu_items);
}

function main_nav_dropdown_visible() {
    global $post;

    $dropDownVisible = false;

    if (!is_front_page() && !in_array($post->ID, array(9, 3489))) {
        if (page_in_menu('primary',$post->ID))
            $dropDownVisible = true;
    }

    return $dropDownVisible;
}

function getTopParent($myid){
  $mypage = get_page($myid);

  if ($mypage->post_parent == 0) {
    return $mypage;
  }
  else {
    return getTopParent($mypage->post_parent);
  }
}

function get_top_parent_id($postid)
{
    $currentPost = get_page($postid);

    if ($currentPost->post_type == 'people'):
        return 54;
    elseif ($currentPost->post_parent == 0):
        return $currentPost->ID;
    else:
        return get_top_parent_id($currentPost->post_parent);
    endif;
}

function get_top_menu_parent($menu_name)
{
    global $post;

    //Loop through the nav menu items and see if we can find the parent item in the structure. If we can, then we'll grab the pages menu title since the
    //main page title could be longer than the menus.
    if (($locations = get_nav_menu_locations() ) && isset( $locations[$menu_name])):
    $menu = wp_get_nav_menu_object($locations[$menu_name]);
    $menu_items = wp_get_nav_menu_items($menu);

        foreach ((array)$menu_items as $key => $menu_item ):
            if ($menu_item->menu_item_parent == '0'):
              $parentMenuItem = $menu_item;
            endif;

            if ($menu_item->object_id == $post->ID)
                break;
        endforeach;
    endif;

    return $parentMenuItem;
}

function get_top_menu_sub_parent($menu_name)
{
    global $post;
    $parentMenuItem = '';

    //Loop through the nav menu items and see if we can find the parent item in the structure. If we can, then we'll grab the pages menu title since the
    //main page title could be longer than the menus.
    if (($locations = get_nav_menu_locations() ) && isset( $locations[$menu_name])):
       $menu = wp_get_nav_menu_object($locations[$menu_name]);
       $menu_items = wp_get_nav_menu_items($menu);
       $last_menu_item = '';

       foreach ((array)$menu_items as $key => $menu_item ):
           if ($menu_item->menu_item_parent == '0'):
             $parentMenuItem = $last_menu_item;
           endif;

           if ($menu_item->object_id == $post->ID)
               break;

           $last_menu_item = $menu_item;
       endforeach;
    endif;

    return $parentMenuItem;
}

function get_top_parent_menu_link($menu_name)
{
  global $post;
  $parentMenuItem = get_top_menu_parent($menu_name);

  if ($parentMenuItem):
    $parentTitle = $parentMenuItem->title;

    return '<a href="'.$parentMenuItem->url.'" class="sub-nav-heading '.((get_top_parent_id($post->ID) == $post->ID) ? 'active' : '').'">'.$parentTitle.'</a>';
  endif;

  return '';
}

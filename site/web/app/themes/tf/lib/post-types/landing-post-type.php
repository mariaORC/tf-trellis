<?php
   namespace Roots\Sage\PostTypes\Landing;

	//Add the landing Post Type
	add_action('init', __NAMESPACE__ . '\\create_landing_page');

	function create_landing_page() {
		$label = 'Landing Pages';
		$singularLabel = 'Landing Page';

		$labels = array(
			'name' => __($label),
			'singular_name' => __($singularLabel),
			'add_new' => _x('Add New '.$singularLabel, 'landing'),
			'add_new_item' => __('Add New '.$singularLabel),
			'edit_item' => __('Edit '.$singularLabel),
			'new_item' => __('New '.$singularLabel),
			'view_item' => __('View '.$singularLabel),
			'search_items' => __('Search '.$label),
			'not_found' =>  __('No '.strtolower($label).' found'),
			'not_found_in_trash' => __('No '.strtolower($label).' found in Trash'),
			'parent_item_colon' => ''
		);

    	$landing_args = array(
        	'labels' => $labels,
        	'public' => true,
	'publicly_queryable' => true,
        	'show_ui' => true,
	'_builtin' => false,
	'menu_icon' => 'dashicons-megaphone',
        	'capability_type' => 'post',
        	'hierarchical' => false,
	'rewrite' => array("slug" => "engage", "with_front" => false),
	'menu_position' => 5,
        	'supports' => array('title', 'editor', 'excerpt')
        );

    	register_post_type('landing',$landing_args);
	}

	//Define Person Edit Grid Fields
	add_filter('manage_edit-landing_columns', __NAMESPACE__ . '\\landing_edit_columns');
	add_action('manage_posts_custom_column',  __NAMESPACE__ . '\\landing_columns_display');

	function landing_edit_columns($custom_columns){
		$custom_columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title",
			'layout_type' => 'Layout'
		);
		return $custom_columns;
	}

	function landing_columns_display($custom_columns){
		switch ($custom_columns)
		{
			case 'layout_type':
				echo get_field('landing_page_layout');
				break;
		}
	}

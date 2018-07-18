<?php
   namespace Roots\Sage\PostTypes\Industry;

	//Add the industry Post Type
	add_action('init', __NAMESPACE__ . '\\create_industry_post_type');

	function create_industry_post_type() {
		$label = 'Industry Pages';
		$singularLabel = 'Industry Page';

		$labels = array(
			'name' => __($label),
			'singular_name' => __($singularLabel),
			'add_new' => _x('Add New '.$singularLabel, 'industry'),
			'add_new_item' => __('Add New '.$singularLabel),
			'edit_item' => __('Edit '.$singularLabel),
			'new_item' => __('New '.$singularLabel),
			'view_item' => __('View '.$singularLabel),
			'search_items' => __('Search '.$label),
			'not_found' =>  __('No '.strtolower($label).' found'),
			'not_found_in_trash' => __('No '.strtolower($label).' found in Trash'),
			'parent_item_colon' => ''
		);

    	$industry_args = array(
        	'labels' => $labels,
        	'public' => true,
	'publicly_queryable' => true,
        	'show_ui' => true,
	'_builtin' => false,
	'menu_icon' => 'dashicons-welcome-widgets-menus',
        	'capability_type' => 'post',
        	'hierarchical' => false,
	'rewrite' => array("slug" => "industry", "with_front" => false),
	'menu_position' => 5,
        	'supports' => array('title', 'excerpt')
        );

    	register_post_type('industry',$industry_args);
	}

	//Define Person Edit Grid Fields
	add_filter('manage_edit-industry_columns', __NAMESPACE__ . '\\industry_edit_columns');
	add_action('manage_posts_custom_column',  __NAMESPACE__ . '\\industry_columns_display');

	function industry_edit_columns($custom_columns){
		$custom_columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title",
			'layout_type' => 'Layout'
		);
		return $custom_columns;
	}

	function industry_columns_display($custom_columns){
		switch ($custom_columns)
		{
			case 'layout_type':
				echo get_field('industry_page_layout');
				break;
		}
	}

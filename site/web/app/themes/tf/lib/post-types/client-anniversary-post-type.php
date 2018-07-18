<?php
   namespace Roots\Sage\PostTypes\ClientAnniversary;

	//Add the Client Anniversary Video Post Type
	add_action('init', __NAMESPACE__ . '\\create_anniversary');

	function create_anniversary() {
		$label = 'Client Anniversaries';
		$singularLabel = 'Client Anniversary';

		$labels = array(
			'name' => 'Client Anniversaries',
			'singular_name' => __($singularLabel),
			'add_new' => _x('Add New Client Anniversary', 'caseStudy'),
			'add_new_item' => __('Add New '.$singularLabel),
			'edit_item' => __('Edit '.$singularLabel),
			'new_item' => __('New '.$singularLabel),
			'view_item' => __('View '.$singularLabel),
			'search_items' => __('Search '.$label),
			'not_found' =>  __('No '.strtolower($label).' found'),
			'not_found_in_trash' => __('No '.strtolower($label).' found in Trash'),
			'parent_item_colon' => ''
		);

		$anniversary_args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'_builtin' => false,
			'menu_icon' => 'dashicons-heart',
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array("slug" => "anniversary", "with_front" => false),
			'menu_position' => 5,
			'supports' => array('title', 'editor', 'excerpt', 'author', 'revisions', 'page-attributes')
		);
		register_post_type('anniversary',$anniversary_args);
	}

	//Define slide Edit Grid Fields
	add_filter('manage_edit-anniversary_columns', __NAMESPACE__ . '\\anniversary_edit_columns');

	function anniversary_edit_columns($custom_columns){
		$custom_columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title"
		);
		return $custom_columns;
	}

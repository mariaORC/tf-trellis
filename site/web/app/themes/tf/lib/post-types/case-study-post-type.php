<?php
   namespace Roots\Sage\PostTypes\CaseStudy;

	//Add the slider Post Type
	add_action('init', __NAMESPACE__ . '\\create_case_study');

	function create_case_study() {
		$label = 'Case Studies';
		$singularLabel = 'Case Study';

		$labels = array(
			'name' => 'Case Studies',
			'singular_name' => __($singularLabel),
			'add_new' => _x('Add New Case Study', 'caseStudy'),
			'add_new_item' => __('Add New '.$singularLabel),
			'edit_item' => __('Edit '.$singularLabel),
			'new_item' => __('New '.$singularLabel),
			'view_item' => __('View '.$singularLabel),
			'search_items' => __('Search '.$label),
			'not_found' =>  __('No '.strtolower($label).' found'),
			'not_found_in_trash' => __('No '.strtolower($label).' found in Trash'),
			'parent_item_colon' => ''
		);

		$case_study_args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'_builtin' => false,
			'menu_icon' => 'dashicons-analytics',
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array("slug" => "case-studies", "with_front" => false),
			'menu_position' => 5,
			'supports' => array('title', 'editor', 'excerpt', 'author', 'revisions', 'page-attributes')
		);

		register_post_type('case_study',$case_study_args);
	}

	//Define slide Edit Grid Fields
	add_filter('manage_edit-case_study_columns', __NAMESPACE__ . '\\case_study_edit_columns');
	add_action('manage_case_study_posts_custom_column',  __NAMESPACE__ . '\\case_study_columns_display', 10, 2);

	function case_study_edit_columns($custom_columns){
		$custom_columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title",
			'descriptions' => "Description",
			'date' => 'Date',
            'feature_on_homepage' => 'Featured?',
            'feature_on_intranet_101' => 'Featured on Intranets 101?'
		);
		return $custom_columns;
	}

	function case_study_columns_display($column, $post_id){
		switch ($column)
		{
			case "feature_on_homepage":
				/* Get the post meta. */
                                $featured = get_post_meta( $post_id, 'feature_on_homepage', true );
                                echo $featured ? 'Yes' : 'No';
                        break;
			case "feature_on_intranet_101":
				/* Get the post meta. */
                                $featured = get_post_meta( $post_id, 'feature_on_intranet_101', true );
                                echo $featured ? 'Yes' : 'No';
                        break;
		}
	}

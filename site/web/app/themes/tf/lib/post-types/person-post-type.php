<?php
   namespace Roots\Sage\PostTypes\Person;

   use Roots\Sage\Extras;

	//Add the person Post Type
	add_action('init', __NAMESPACE__ . '\\create_person');

	function create_person() {
		$label = 'People';
		$singularLabel = 'Person';

		$labels = array(
			'name' => __($label),
			'singular_name' => __($singularLabel),
			'add_new' => _x('Add New '.$singularLabel, 'person'),
			'add_new_item' => __('Add New '.$singularLabel),
			'edit_item' => __('Edit '.$singularLabel),
			'new_item' => __('New '.$singularLabel),
			'view_item' => __('View '.$singularLabel),
			'search_items' => __('Search '.$label),
			'not_found' =>  __('No '.strtolower($label).' found'),
			'not_found_in_trash' => __('No '.strtolower($label).' found in Trash'),
			'parent_item_colon' => ''
		);

    	$person_args = array(
        	'labels' => $labels,
        	'public' => true,
		'publicly_queryable' => true,
        	'show_ui' => true,
		'_builtin' => false,
        	'capability_type' => 'post',
        	'menu_icon' => 'dashicons-groups',
        	'hierarchical' => false,
		'rewrite' => array("slug" => "about/team", "with_front" => false),
		'menu_position' => 5,
        	'supports' => array('title', 'editor', 'excerpt', 'author', 'revisions', 'page-attributes')
        );

    	register_post_type('person',$person_args);
	}

	//Define Person Edit Grid Fields
	add_filter('manage_edit-person_columns', __NAMESPACE__ . '\\person_edit_columns');
	add_action('manage_posts_custom_column',  __NAMESPACE__ . '\\person_columns_display');

	function person_edit_columns($custom_columns){
		$custom_columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title",
			"email" => "Email",
			"leader" => "Leader",
			'date' => 'Date'
		);
		return $custom_columns;
	}

	function person_columns_display($custom_columns){
		switch ($custom_columns)
		{
			case "email":
				echo get_field('email_address');
				break;
			case "leader":
				echo (get_field('leadership') == 1 ? 'yes' : 'no');
				break;
		}
	}

	//Add the Person Custom Fields
	add_action('admin_init', __NAMESPACE__ . '\\setup_person_custom_fields');
	add_action('save_post', __NAMESPACE__ . '\\save_person_custom_fields');

	function setup_person_custom_fields(){
		add_meta_box("person_details", "Which Wordpress User does this Person Profile belong to?", "output_person_custom_fields", "person", "advanced", "high");
	}

	function output_person_custom_fields(){
		global $post;
		$custom = get_post_custom($post->ID);
		$page_user_id = $custom["page_user_id"][0];
		$blogUsers = Extras\get_blog_users();

		echo '<select name="page_user_id">';
		echo '<option></option>';

		foreach ($blogUsers as $blogUser)
		{
			$user = get_userdata($blogUser->user_id);

			echo '<option value="'.$blogUser->user_id.'" ';

			if ($blogUser->user_id == $page_user_id)
					echo 'selected';

			echo '>';

			if ($user->first_name != "") :
				echo $user->first_name.' '.$user->last_name;
			else :
				echo $blogUser->user_login;
			endif;
			echo '</option>';
		}

		echo '</select>';
	}

	function save_person_custom_fields($post_id){
		global $post;

		// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return $post->ID;

		if ($_POST['page_user_id'] != '')
			update_post_meta($post->ID, 'page_user_id', $_POST['page_user_id']);
	}

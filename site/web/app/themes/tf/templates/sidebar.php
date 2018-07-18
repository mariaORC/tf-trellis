<?php
if ($post->post_type == TYPE_CASE_STUDY) {
	output_case_study_nav($post->ID);
} else {
	echo get_sub_nav($post);
}
?>

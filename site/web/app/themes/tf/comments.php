<?php
/**
 * @package ThoughtFarmer
 * @subpackage Default_Theme
 */

use Roots\Sage\Extras;

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<h6 id="comments"><?php echo get_comments_number(); ?> <?php comments_number('No Responses', 'Comment', 'Comments' );?></h6>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<ul class="styledList commentlist">
	<?php
		wp_list_comments('callback=Roots\Sage\Extras\tf_comment');
	?>
	</ul>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>
<div class="clear"></div>


<?php if ('open' == $post->comment_status) : ?>

<div id="respond">

<h6>Join the Discussion</h6>

<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p class="loggedInAs">You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/_js/jquery.validate.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		jQuery.validator.addMethod("notEqual", function(value, element, param) {
		  return this.optional(element) || value !== param;
		}, "This field is required");

		$('#commentform').validate({
			rules: {
				author: {
					required: true,
					notEqual: 'Name'
				},
				email: {
					required: true,
					notEqual: 'Email',
					email: true
				},
				comment: {
					required: true,
					notEqual: 'Comment'
				},
			}
		});
	});
</script>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>

<?php else : ?>

<div class="comment-form-user-fields">
<p><input type="text" name="author" id="author" class="required autohide text-input" value="<?php echo ($comment_author != '' ? $comment_author : 'Name'); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> /></p>
<p><input type="text" name="email" id="email" class="required autohide text-input" value="<?php echo ($comment_author_email != '' ? $comment_author_email : 'Email'); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> /></p>
<p><input type="text" name="url" id="url" class="autohide text-input" value="<?php echo ($comment_author_url != '' ? $comment_author_url : 'Website'); ?>" size="22" tabindex="3" /></p>
</div>
<?php endif; ?>
<div class="comment-form-comment-field">
	<textarea name="comment" id="comment" class="required autohide" cols="100%" rows="10" tabindex="4">Comment</textarea>
	<button type="submit" name="submit" id="submit" tabindex="5" class="button"><span>Submit Comment</span></button>
</div>
<?php comment_id_fields(); ?>
<?php do_action('comment_form', $post->ID); ?>
</form>
<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>

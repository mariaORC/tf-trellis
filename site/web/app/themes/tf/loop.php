<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

use Roots\Sage\Extras;
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h4 class="entry-title"><?php _e( 'Not Found', 'twentyten' ); ?></h4>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyten' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>

<div class="articles">
<?php
	/* Start the Loop.
	 *
	 * In Twenty Ten we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>
<?php while ( have_posts() ) : the_post(); ?>
	<?php /* How to display posts of the Gallery format. The gallery category is the old way. */ ?>
	<?php if ( is_archive() || is_search() ) : // Display excerpts for archives and search. ?>
		<article class="post simple">
			<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
			<em class="lite"><a href="<?php the_permalink(); ?>"><?php echo str_replace('http://', '', get_permalink()); ?></a></em>
		</article>
	<?php else: ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="post-category">In: <?php Extras\output_post_category(); ?></div>
			<h4 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
			<div class="entry-meta">
				<?php twentyten_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php Extras\entry_social_links(); ?>
			<div class="clear"></div>
			<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			<?php else : ?>
				<div class="entry-content">
					<?php the_advanced_excerpt('length=250&no_custom=1&use_words=1&no_shortcode=0&allowed_tags=_all'); ?>
				</div><!-- .entry-content -->
			<?php endif; ?>
			<a href="<?php the_permalink(); ?>" class="more nounderline">Continue reading...</a>
		</div><!-- #post-## -->
		<?php comments_template( '', true ); ?>
	</article>
	<?php endif; ?>
	<?php endwhile; // End the loop. Whew. ?>
</div>
<?php /* Display navigation to next/previous pages when applicable */ ?>
	<div id="nav-below" class="navigation">
<?php
	if ( is_archive() || is_search() ) :
    	Extras\results_numeric_pager();
   	elseif(  $wp_query->max_num_pages > 1 ): ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyten' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
<?php endif; ?>
	</div><!-- #nav-below -->

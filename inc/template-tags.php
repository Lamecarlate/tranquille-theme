<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package tranquille
 */

if ( ! function_exists( 'tranquille_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function tranquille_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'tranquille' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'tranquille' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'tranquille' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'tranquille_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function tranquille_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'tranquille' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'tranquille' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link',     'tranquille' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'tranquille_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function tranquille_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">
		<span class="entry-date-day">%2$s</span>
		<span class="entry-date-month">%3$s</span>
		<span class="entry-date-year">%4$s</span>
	</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		//esc_html( get_the_date() )
		esc_html( get_the_date('d') ),
		esc_html( get_the_date('F') ),
		esc_html( get_the_date('Y') )
	);

	printf( __( '<span class="posted-on">Posted on %1$s</span>', 'tranquille' ),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		)
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function tranquille_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'tranquille_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'tranquille_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so tranquille_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so tranquille_categorized_blog should return false.
		return false;
	}
}

function tranquille_get_post_footer($name = NULL) {
	
	$name = (string) $name;
	if ( '' !== $name ) {
		require get_template_directory() . '/template-bits/post-footer-' . $name . '.php';
	}
	else {
		require get_template_directory() . '/template-bits/post-footer.php';
	}
	
}

/**
 * 
 */
function tranquille_get_post_aside($args = NULL) {

	if(!isset($args["format"]) || $args['format'] === TRUE) {
		$format = get_post_format();
	}
	if(!isset($args["category"]) || $args['category'] === TRUE) {
		$categories = get_the_category();
	}
	if(!isset($args["tags"]) || $args['tags'] !== TRUE) {
		$tags = get_the_tags();
	}

	require get_template_directory() . '/template-bits/post-aside.php';
}

function tranquille_get_widgets() {

	require get_template_directory() . '/template-bits/widgets.php';

}

/**
 * Flush out the transients used in tranquille_categorized_blog.
 */
function tranquille_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'tranquille_categories' );
}
add_action( 'edit_category', 'tranquille_category_transient_flusher' );
add_action( 'save_post',     'tranquille_category_transient_flusher' );

 
if ( ! function_exists( 'tranquille_handcraftedwp_comment' ) ) {
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own handcraftedwp_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since HandcraftedWP 0.4
	 */
	function tranquille_handcraftedwp_comment( $comment, $args, $depth ) {

		//$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment-content clearfix" role="article">
				<footer class="comment-side">
					<div class="comment-author vcard">
						<div class="comment-author-avatar">
							<?php echo get_avatar( $comment, 96 ); ?>
						</div>
						<?php printf( sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</div><!-- .comment-author .vcard -->
					
					<div class="comment-meta commentmetadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
							<?php
								/* translators: 1: date, 2: time */
								printf( __( '%1$s at %2$s', 'tranquille' ), get_comment_date(),  get_comment_time() ); ?>
							</time>
						</a>
						<?php edit_comment_link( __( '(Edit)', 'tranquille' ), ' ' );
						?>
					</div><!-- .comment-meta .commentmetadata -->
				</footer>

				<div class="comment-body">
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<div class="waiting"><?php _e( 'Your comment is awaiting moderation.', 'tranquille' ); ?></div>
					<?php endif; ?>
					<?php comment_text(); ?>
				</div>
	  	
		         	 <div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('Reply','tranquille') ) ) ); ?>
				</div><!-- .reply -->
			</article><!-- #comment-##  -->

		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'tranquille' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'tranquille'), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
}
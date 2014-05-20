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
		esc_html( get_the_date('m') ),
		esc_html( get_the_date('y') )
	);

	printf( __( '<span class="posted-on"><span class="visually-hidden">Posted on </span>%1$s</span>', 'tranquille' ),
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

/**
 * Flush out the transients used in tranquille_categorized_blog.
 */
function tranquille_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'tranquille_categories' );
}
add_action( 'edit_category', 'tranquille_category_transient_flusher' );
add_action( 'save_post',     'tranquille_category_transient_flusher' );

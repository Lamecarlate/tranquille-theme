<?php
/**
 * @package tranquille
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php tranquille_posted_on(); ?>
			
			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link <?php echo (get_comments_number() > 0) ? 'comments' : 'no-comment'; ?> ">
				<?php comments_popup_link( __( 'Leave a comment', 'tranquille' ), __( '1 Comment', 'tranquille' ), __( '% Comments', 'tranquille' ) ); ?>
			</span>
			<?php endif; ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'tranquille' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<div class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			//$category_list = get_the_category_list( __( ', ', 'tranquille' ) );
			$categories = get_the_category();
			$category_list = "";
			foreach($categories as $cat) {
				$category_list .= '<a 
					href="' . get_category_link( $cat->term_id ) . '"
					title="' . esc_attr( sprintf( __( "View all posts in %s category" ), $cat->name ) ) .'"
					class=""
				>
					<span aria-hidden="true" class="picto picto-category-' . $cat->slug . '"></span>
					<span class="">' . $cat->cat_name . '</span>
				</a>';
			}

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'tranquille' ) );

			if ( ! tranquille_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'tranquille' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'tranquille' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'tranquille' );
				} else {
					$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'tranquille' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				get_the_title()
			);
		?>

		<?php edit_post_link( __( 'Edit', 'tranquille' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

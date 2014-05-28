<footer class="entry-footer">
		<div class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'tranquille' ) );
					if ( $categories_list && tranquille_categorized_blog() ) :
				?>
				<span class="cat-links">
					<?php printf( __( 'Categorized in: %1$s', 'tranquille' ), $categories_list ); ?>
				</span>
				<?php endif; // End if categories ?>

				<?php
					/* translators: used between list items, there is a space after the comma */
					$tags_list = get_the_tag_list( '', __( ', ', 'tranquille' ) );
					if ( $tags_list ) :
				?>
				<span class="tags-links">
					<?php printf( __( 'Tagged: %1$s', 'tranquille' ), $tags_list ); ?>
				</span>
				<?php endif; // End if $tags_list ?>
			<?php endif; // End if 'post' == get_post_type() ?>
			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link <?php echo (get_comments_number() > 0) ? 'comments' : 'no-comment'; ?> ">
				<?php comments_popup_link( __( 'Leave a comment', 'tranquille' ), __( '1 Comment', 'tranquille' ), __( '% Comments', 'tranquille' ) ); ?>
			</span>
			<?php endif; ?>

			<?php edit_post_link( __( 'Edit', 'tranquille' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	</footer><!-- .entry-footer -->
<footer class="entry-footer">
		<div class="entry-meta">
			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link <?php echo (get_comments_number() > 0) ? 'comments' : 'no-comment'; ?> ">
				<?php comments_popup_link( __( 'Leave a comment', 'tranquille' ), __( '1 Comment', 'tranquille' ), __( '% Comments', 'tranquille' ) ); ?>
			</span>
			<?php endif; ?>

			<?php edit_post_link( __( 'Edit', 'tranquille' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	</footer><!-- .entry-footer -->
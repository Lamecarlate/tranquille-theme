<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package tranquille
 */
?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Nothing Found', 'tranquille' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'tranquille' ); ?></p>

		<?php else : ?>

			<p><?php _e( 'There is nothing here. Please be patient :)', 'tranquille' ); ?></p>

		<?php endif; ?>

		<?php tranquille_get_widgets() ;?>
	</div><!-- .page-content -->
</section><!-- .no-results -->

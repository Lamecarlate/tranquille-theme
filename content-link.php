<?php
/**
 * @package tranquille
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	

	<header class="entry-header">
		<h2 class="entry-title">
			<?php the_title( sprintf( '<a href="%s" rel="bookmark" class="entry-title-link">', esc_url( get_permalink() ) ), '</a>' ); ?>
		</h2>
		<div class="entry-meta">
			<?php tranquille_posted_on(); ?>
			<?php tranquille_get_post_aside(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php echo tranquille_remove_first_link(get_the_excerpt()); ?>
	</div><!-- .entry-summary -->
	
	<?php tranquille_get_post_footer() ;?>	

</article>
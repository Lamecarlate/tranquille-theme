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


	<?php if ( !is_single() ) : ?>
	<div class="entry-summary">
		<?php 
		if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
		  the_post_thumbnail('thumbnail',array('class' => 'alignleft featured-image'));
		} 
		the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tranquille' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'tranquille' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<?php tranquille_get_post_footer() ; ?>
	
</article><!-- #post-## -->

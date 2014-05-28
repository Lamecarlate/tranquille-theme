<?php
/**
 * @package tranquille
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h2 class="entry-title visually-hidden">
			<?php the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); ?>
		</h2>
		<div class="entry-meta just-aside">
			<?php tranquille_get_post_aside(array('category' => FALSE)); ?>
		</div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tranquille' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'tranquille' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php tranquille_get_post_footer('date') ;?>

</article><!-- #post-## -->

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
		</div>
	</header><!-- .entry-header -->
	
	<div class="entry-summary">

	<?php
		$pattern = get_shortcode_regex();
		preg_match( "/$pattern/s", get_the_content(), $match );
		$atts    = isset( $match[3] ) ? shortcode_parse_atts( $match[3] ) : array();
		$images  = isset( $atts['ids'] ) ? explode( ',', $atts['ids'] ) : false;

		if ( ! $images ) :
			$images = get_posts( array(
				'post_parent'      => get_the_ID(),
				'fields'           => 'ids',
				'post_type'        => 'attachment',
				'post_mime_type'   => 'image',
				'orderby'          => 'menu_order',
				'order'            => 'ASC',
				'numberposts'      => 999,
				'suppress_filters' => false
			) );
		endif;

		if ( $images ) :
			$total_images = count( $images );
			$image        = array_shift( $images );
			$class = ($total_images > 10) ? 'gallery-number-10plus' : 'gallery-number-' . $total_images;
		?>
	
		<div class="alignleft gallery-thumb <?php echo $class ; ?>">
			<?php echo wp_get_attachment_image($image,'thumbnail', FALSE); ?><!-- .gallery-thumb -->
		</div>
		
		<?php endif; ?>
		<?php the_excerpt(); ?>
	</div>

	<?php tranquille_get_post_footer() ; ?>
	
</article><!-- #post-## -->

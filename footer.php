<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package tranquille
 */
?>

		</div><!-- #content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="wrapper">
				<?php get_search_form(); ?>
				<div class="site-info">
					<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'tranquille' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'tranquille' ), 'WordPress' ); ?></a>
					<span class="sep"> | </span>
					<?php printf( __( 'Theme: &laquo; %1$s &raquo; by %2$s.', 'tranquille' ), 'tranquille', '<a href="http://lamecarlate.net/" rel="author">Chaopale Lamecarlate</a>' ); ?>
				</div><!-- .site-info -->
			</div>
		</footer><!-- #colophon -->
	</div><!-- .wrapper -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

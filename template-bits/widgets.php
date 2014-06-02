<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

<?php if ( tranquille_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
<div class="widget widget_categories">
<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'tranquille' ); ?></h2>
<ul>
<?php
	wp_list_categories( array(
		'orderby'    => 'count',
		'order'      => 'DESC',
		'show_count' => 1,
		'title_li'   => '',
		'number'     => 10,
	) );
?>
</ul>
</div><!-- .widget -->
<?php endif; ?>

<?php
/* translators: %1$s: smiley */
$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'tranquille' ), convert_smilies( ':)' ) ) . '</p>';
the_widget( 'WP_Widget_Archives', 'dropdown=0', "after_title=</h2>$archive_content" );
?>

<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
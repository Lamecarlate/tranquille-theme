<aside class="post-aside">
	<?php if(isset($format) && $format) : ?>
	<ul class="post-aside-group post-format">
		<?php $format_name = get_post_format_string($format) ; ?>
		<li >
			<!--<a 
				href="<?php echo get_post_format_link($format) ; ?>"
				title="<?php echo esc_attr( sprintf( __( "View all posts of %s format" ), $format_name ) ); ?>"
				class="post-aside-item with-picto"
			>-->
				<span aria-hidden="true" class="post-aside-item-picto picto picto-format-<?php echo $format ; ?>"></span>
				<!--<span class="post-aside-item-name"><?php echo $format_name ; ?></span>-->
			<!--</a>-->
		</li>
	</ul>
	<?php endif ; ?>
	<?php //var_dump($categories) ; ?>
	<?php if(isset($categories) && $categories) : ?>
	<ul class="post-aside-group post-categories">
		<?php 
		foreach($categories as $cat) : 
			if($cat->term_id !== 1) : 
		?>
	<li >
		<a 
			href="<?php echo get_category_link( $cat->term_id ) ; ?>"
			title="<?php echo esc_attr( sprintf( __( "View all posts in %s category" ), $cat->name ) ); ?>"
			class="post-aside-item with-picto"
		>
			<span aria-hidden="true" class="post-aside-item-picto picto picto-category-<?php echo $cat->slug ; ?>"></span>
			<span class="post-aside-item-name"><?php echo $cat->cat_name ; ?></span>
		</a>
	</li>
		<?php 
			endif ; 
		endforeach ; 
		?>
	</ul>
	<?php endif ;?>
	<?php if(isset($tags) && $tags) : ?>
	<ul class="post-aside-group post-tags">
		<?php foreach($tags as $tag) : ?>
			<li ><!--
				--><a 
				href="<?php echo get_tag_link($tag->term_id) ; ?>"
				class="post-aside-item"
			>
			<?php echo $tag->name ; ?></a><!--
			--></li>
		<?php endforeach ; ?>
	</ul>
	<?php endif ; ?>
</aside>
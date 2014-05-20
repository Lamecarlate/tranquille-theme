<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package tranquille
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> style="background-image: url('<?php echo tranquille_header_image() ; ?>');">
<div id="page" class="hfeed site">
	<div class="skip-links">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'tranquille' ); ?></a>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php _e( 'Skip to menu', 'tranquille' ); ?></a>
	</div>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
		<?php if(is_front_page() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description h1-like"><?php bloginfo( 'description' ); ?></h2>
		<?php else : ?>
			<div class="site-title h1-like"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
			<div class="site-description h1-like"><?php bloginfo( 'description' ); ?></div>
		<?php endif ; ?>
		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle"><?php _e( 'Primary Menu', 'tranquille' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">

<?php
/**
 * tranquille functions and definitions
 *
 * @package tranquille
 */


if ( ! function_exists( 'tranquille_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tranquille_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on tranquille, use a find and replace
	 * to change 'tranquille' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'tranquille', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'tranquille' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'tranquille_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );
}
endif; // tranquille_setup
add_action( 'after_setup_theme', 'tranquille_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function tranquille_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'tranquille' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'tranquille_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tranquille_scripts() {
	//wp_enqueue_style( 'decode-style', get_stylesheet_directory_uri().'/css/style.css', array(), "2.8.3" );
	wp_enqueue_style( 'tranquille-style', get_stylesheet_directory_uri().'/css/style.css', array(), "0.1" );

	wp_enqueue_script( 'tranquille-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'tranquille-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'tranquille-modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tranquille_scripts' );


remove_filter('the_excerpt', 'wpautop');
remove_filter('the_content', 'wpautop');

function tranquille_header_image() {
	$folder = get_template_directory() . '/images/header/';

	$headers = array();

	$handle = opendir($folder);
    while (($file = readdir($handle))) {
        if (($file != '.') && ($file != '..')) {
    		$headers[] = $file;        
        }
    }
    closedir($handle);

    $rand = rand(0, count($headers) - 1);

    $image_src = get_template_directory_uri() . '/images/header/' . $headers[$rand];
 
	return $image_src;
}


add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 );
if ( !function_exists('cleaner_caption')) {
	function cleaner_caption( $output, $attr, $content ) {

		/* We're not worried about captions in feeds, so just return the output here. */
		if ( is_feed() )
			return $output;

		/* Set up the default arguments. */
		$defaults = array(
			'id' => '',
			'align' => '',
			'width' => '',
			'caption' => ''
		);

		/* Merge the defaults with user input. */
		$attr = shortcode_atts( $defaults, $attr );
		$attachment = preg_split( "/_/", esc_attr( $attr['id'] ) ); // Return attachment_xxx
		$attachment_id = $attachment[1];

		/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
		// if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		// 	return $content;

		/* Set up the attributes for the caption. */
		$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
		$attributes .= ' class="post-figure ' . ((!empty($attr['align'])) ? esc_attr( $attr['align'] ) : '') . '"';
		//if(!empty($attr['width'])) $attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';

		/* Open the caption <div>. */
		$output = '<figure' . $attributes .'>';

		/* Allow shortcodes for the content the caption was created for. */
		$output .= do_shortcode( $content );

		//var_dump($content);		

		/* Add information to the $output. */
		$description = get_post($attachment_id)->post_content;
		$title = get_post($attachment_id)->post_title;		
		
		//var_dump($attr);

		/* Append the caption text. */
		if($attr['caption'] !== '') $output .= '<figcaption class="post-figcaption">' . $attr['caption'] . '</figcaption>';

		/* Close the caption. */
		$output .= '</figure>';
		//$output .= '<p class="wp-description-text">'.$description.'</p>';

		/* Return the formatted, clean caption. */
		return $output;

	}
} //endif !function_exists


/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
//require get_template_directory() . '/inc/jetpack.php';

require get_template_directory() . '/inc/gallery.php';

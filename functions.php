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
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'tranquille' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'audio', 'video', 'quote', 'link', 'status', 'gallery') );

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
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'tranquille_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tranquille_scripts() {
	//wp_enqueue_style( 'decode-style', get_stylesheet_directory_uri().'/css/style.css', array(), "2.8.3" );
	wp_enqueue_style( 'tranquille-style', get_stylesheet_directory_uri().'/style.css', array(), "0.1" );

	wp_enqueue_script( 'tranquille-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'tranquille-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'tranquille-modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tranquille_scripts' );


//remove_filter('the_excerpt', 'wpautop');
//remove_filter('the_content', 'wpautop');


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

/**
 * Construct a cleaner caption (generated by caption shortcode in articles)
 */
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

		/* Set up the attributes for the caption. */
		$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
		$attributes .= ' class="post-figure ' . ((!empty($attr['align'])) ? esc_attr( $attr['align'] ) : '') . '"';
		if(!empty($attr['width'])) $attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';

		/* Open the caption <div>. */
		$output = '';

		$output .= '<figure' . $attributes .'>';

		/* Allow shortcodes for the content the caption was created for. */
		$output .= do_shortcode( $content );

		/* Add information to the $output. */
		$description = get_post($attachment_id)->post_content;
		$title = get_post($attachment_id)->post_title;

		/* Append the caption text. */
		if($attr['caption'] !== '') $output .= '<figcaption class="post-figcaption">' . $attr['caption'] . '</figcaption>';

		/* Close the caption. */
		$output .= '</figure>';

		//$output .= '<p class="wp-description-text">'.$description.'</p>';

		/* Return the formatted, clean caption. */
		return $output;

	}
} //endif !function_exists
add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 );

/**
 * Adding html5 functionnalities to searchform
 */
function html5_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <p><label class="screen-reader-text" for="s">' . __('Search for:','tranquille') . '</label>
    <input type="search" value="' . get_search_query() . '" name="s" id="s" class="search-input"
    	autocomplete="on" placeholder ='.__( '"What are you looking for?"', 'tranquille' ) . '
    /><!--
    --><button type="submit" id="searchsubmit" class="search-submit"><!--
    	--><span class="ir">'. esc_attr__('Search', 'tranquille') .'</span></button>
    </p>
    </form>';
    return $form;
}
add_filter( 'get_search_form', 'html5_search_form' );

/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return string The Link format URL.
 */
function twentythirteen_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Remove the first link of an article (default is on the excerpt)
 * 
 * @return string The content without the first link
 */
function tranquille_remove_first_link ($content, $excerpt = TRUE) {

	if($excerpt === FALSE) {
		$pattern = '/<a\s[^>]*?href=([\'"])(.+?)\1/is';
	}
	else {
		$pattern = '`((?:https?|ftp)://\S+?)(?=[[:punct:]]?(?:\s|\Z)|\Z)/?`'; 
	}
 
	$content = trim(preg_replace($pattern, "", $content, 1));

	return $content;
}

/**
 * DoFollow
 * 
 * Remove nofolow attributes on links
 * 
 * url : http://www.seomix.fr/nofollow-sans-plugin/
 * 
 */
function commentdofollow($text) {
	return str_replace('" rel="nofollow">', '">', $text);
}
add_filter('comment_text', 'commentdofollow');
remove_filter('pre_comment_content', 'wp_rel_nofollow', 15);

function remove_nofollow($string){
	return str_ireplace(' nofollow', '', $string);
}
add_filter('get_comment_author_link', 'remove_nofollow');


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

require get_template_directory() . '/inc/gallery.php';

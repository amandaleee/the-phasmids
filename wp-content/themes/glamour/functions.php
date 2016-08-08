<?php
/**
 * Bloom Blog Shop functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bloom_Blog_Shop
 */

if ( ! function_exists( 'bbs_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bbs_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Bloom Blog Shop, use a find and replace
	 * to change 'bbs' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'bbs', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'bbs' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add a Slider Image size
	add_image_size( 'featured-slider', 1000, 450, true );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'bbs_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // bbs_setup
add_action( 'after_setup_theme', 'bbs_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bbs_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bbs_content_width', 1000 );
}
add_action( 'after_setup_theme', 'bbs_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bbs_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'bbs' ),
		'id'            => 'sidebar',
		'description'   => 'This is the widget area where you can place your sidebar widgets!',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Featured', 'bbs' ),
		'id'            => 'featured',
		'description'   => 'This is the widget area where you can place your slider and recent posts!',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Social Media Menu', 'bbs' ),
		'id'            => 'social-media-menu',
		'description'   => 'This is the widget area where you can place your social media icons!',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'bbs' ),
		'id'            => 'footer',
		'description'   => 'This is the widget area where you can place your instagram!',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>'
	) );
}
add_action( 'widgets_init', 'bbs_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bbs_scripts() {
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'bbs-style', get_stylesheet_uri() );
	wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css?family=Karla:400,400italic,700,700italic' );

	wp_enqueue_script( 'bbs-global', get_template_directory_uri() . '/js/global.js', array(), true );
	wp_enqueue_script( 'bbs-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.js', array(), true );
	wp_enqueue_script( 'bbs-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bbs_scripts' );

/**
 * Modify the Read More Link
 */
function modify_read_more_link() {
	return '<a class="more-link button" href="' . get_permalink() . '">Read More</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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
require get_template_directory() . '/inc/jetpack.php';

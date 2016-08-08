<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme
define( 'CHILD_THEME_NAME', __( 'Gather Theme', 'gather' ) );
define( 'CHILD_THEME_URL', 'http://shop.17thavenuedesigns.com/products/gather-wordpress-theme/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Unregister layout options and sidebar areas
genesis_unregister_layout( 'content-sidebar-sidebar', 'gather' );
genesis_unregister_layout( 'sidebar-sidebar-content', 'gather' );
genesis_unregister_layout( 'sidebar-content-sidebar', 'gather' );
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'header-right' );

//* Add Support for WooCommerce Plugin
add_theme_support( 'genesis-connect-woocommerce' );

//* Remove Related Products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

//* Remove Add to Cart on Archives
add_action( 'woocommerce_after_shop_loop_item', 'gather_remove_add_to_cart_buttons', 1 );
function gather_remove_add_to_cart_buttons() {

    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

}

//* Import WordPress Theme Customizer PHP for Gather Theme
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Add new image sizes
add_image_size( 'blog-excerpt', 730, 470, TRUE );
add_image_size( 'sidebar', 270, 270, TRUE );
add_image_size( 'home-half', 360, 360, TRUE );
add_image_size( 'home-third', 200, 200, TRUE );
add_image_size( 'portfolio', 300, 300, TRUE );
add_image_size( 'category-index', 225, 225, TRUE );

//* Add support for custom background
add_theme_support( 'custom-background', array(
	'default-color' => 'fff',
) );

//* Add support for custom header.
	add_theme_support( 'genesis-custom-header', array(
			'width'  => 800,
			'height'  => 200,
		)
);

//* Enqueue Google Fonts, WooCommerce CSS, and Dashicons
add_action( 'wp_enqueue_scripts', 'gather_enqueue_scripts' );
function gather_enqueue_scripts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lora:400,400italic|Montserrat:400,700|Libre+Baskerville', array());
	wp_enqueue_style( 'dashicons' );

	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'custom-stylesheet', CHILD_URL . '/woocommerce/woocommerce.css', array() );
	}

}

//* Enqueue Custom Links Script
add_action( 'wp_enqueue_scripts', 'gather_custom_links' );
function gather_custom_links() {
 
	wp_enqueue_script( 'gather-custom-links', get_stylesheet_directory_uri() . '/lib/js/custom-links.js', array( 'jquery' ), '1.0.0', true );
 
}


//* Load Admin Stylesheet
add_action( 'admin_enqueue_scripts', 'gather_admin_styles' );
function gather_admin_styles() {

	wp_register_style( 'custom_wp_admin_css', get_stylesheet_directory_uri() . '/lib/admin-style.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );

}


// Register responsive menu script
add_action( 'wp_enqueue_scripts', 'gather_responsive_menu' );
function gather_responsive_menu() {
 
	wp_enqueue_script( 'gather-responsive-menu', get_stylesheet_directory_uri() . '/lib/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
 
}

//* Modify Genesis Read More Link
add_filter( 'excerpt_more', 'gather_read_more_link' );
add_filter( 'get_the_content_more_link', 'gather_read_more_link' );
add_filter( 'the_content_more_link', 'gather_read_more_link' );
/**
 * Modify the Genesis read more link.
 *
 * @since  1.0.0
 *
 * @param  string $more
 * @return string Modified read more text.
 */
function gather_read_more_link() {
	return '...</p><p><a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'gather' ) . '</a></p>';
}

//* Create Portfolio Taxonomy
add_action( 'init', 'gather_portfolio_taxonomy' );
function gather_portfolio_taxonomy() {

	register_taxonomy( 'portfolio-type', 'portfolio',
		array(
			'labels' => array(
				'name'          => _x( 'Types', 'taxonomy general name', 'gather' ),
				'add_new_item'  => __( 'Add New Portfolio Type', 'gather' ),
				'new_item_name' => __( 'New Portfolio Type', 'gather' ),
			),
			'exclude_from_search' => true,
			'has_archive'         => true,
			'hierarchical'        => true,
			'rewrite'             => array( 'slug' => 'portfolio-type', 'with_front' => false ),
			'show_ui'             => true,
			'show_tagcloud'       => false,
		)
	);

}

//* Edit width of tiled gallery
if ( ! isset( $content_width ) )
    $content_width = 1028;

//* Create portfolio custom post type
add_action( 'init', 'gather_portfolio_post_type' );
function gather_portfolio_post_type() {

	register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name'          => __( 'Portfolio', 'chanel' ),
				'singular_name' => __( 'Portfolio', 'chanel' ),
			),
			'has_archive'  => true,
			'hierarchical' => true,
			'menu_icon'    => 'dashicons-screenoptions',
			'public'       => true,
			'rewrite'      => array( 'slug' => 'portfolio', 'with_front' => false ),
			'supports'     => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-seo', 'genesis-cpt-archives-settings' ),
			'taxonomies'   => array( 'portfolio-type' ),

		)
	);
	
}

//* Add Portfolio Type Taxonomy to columns
add_filter( 'manage_taxonomies_for_portfolio_columns', 'chanel_portfolio_columns' );
function chanel_portfolio_columns( $taxonomies ) {

    $taxonomies[] = 'portfolio-type';
    return $taxonomies;

}

//* Change number of Portfolio posts per page
add_action( 'pre_get_posts', 'portfolio_posts_per_page' );
function portfolio_posts_per_page( $query ) {
	if( $query->is_main_query() && is_post_type_archive( $portfolio )  && ! is_admin() ) {
		$query->set( 'posts_per_page', '21' );
	}
}

//* Change number posts that display on category archive pages
add_action( 'pre_get_posts',  'change_number_posts_per_category'  );
function change_number_posts_per_category( $query ) {

    if ( is_archive() ) {
        $query->set( 'posts_per_page', 16 );

    return $query;
}}

//* Automatically display category name on archive pages
function be_default_category_title( $headline, $term ) {
	if( ( is_category() || is_tag() || is_tax() ) && empty( $headline ) )
		$headline = $term->name;
		
	return $headline;
}
add_filter( 'genesis_term_meta_headline', 'be_default_category_title', 10, 2 );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Hook after post widget after the entry content
add_action( 'genesis_after_entry', 'gather_after_entry', 5 );
function gather_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry widget-area">',
			'after'  => '</div>',
		) );

}


//* Reposition the primary navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before', 'genesis_do_nav' );


//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'gather_author_box_gravatar' );
function gather_author_box_gravatar( $size ) {

	return 96;
		
}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'gather_comments_gravatar' );
function gather_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;
	
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'gather_remove_comment_form_allowed_tags' );
function gather_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}


//* Customize the post meta function
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter($post_meta) {
if ( !is_page() ) {
    $post_meta = '[post_comments] [post_categories before=" / Filed In: "] <br /> [post_tags before="Tagged: "]';
    return $post_meta;
}}

//* Customize the post info function
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
if ( !is_page() ) {
    $post_info = '[post_date]';
    return $post_info;
}}

//* Customize the previous page link
add_filter ( 'genesis_prev_link_text' , 'sp_previous_page_link' );
function sp_previous_page_link ( $text ) {
    return 'Newer Entries';
}

//* Customize the next page link
add_filter ( 'genesis_next_link_text' , 'sp_next_page_link' );
function sp_next_page_link ( $text ) {
    return 'Previous Entries';
}

//* Customize the entire footer
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_after', 'custom_footer', 12 );
function custom_footer() {
	?>
	<div class="site-footer"><p class="site-footer">Theme by <a href="http://17thavenuedesigns.com/" target="_blank">17th Avenue</a> &middot; Powered by <a href="http://wordpress.org/" target="_blank">WordPress</a> & <a href="http://www.studiopress.com/" target="_blank">Genesis</a></p></div>
	<?php
}

//* Modify the WordPress read more link
add_filter( 'the_content_more_link', 'sp_read_more_link' );
function sp_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';
}

//* Customize search form input button text
add_filter( 'genesis_search_button_text', 'sp_search_button_text' );
function sp_search_button_text( $text ) {
	return esc_attr( 'GO' );
}

//* Add Custom Share Buttons
add_action( 'genesis_entry_footer', 'share_buttons', 2 );
function share_buttons() {


	if ( is_single() ) {
	
	echo '<div class="share-container"><div class="share" align="center">

<a href="http://www.facebook.com/share.php?u=<?php print(urlencode(get_permalink())); ?>&title=<?php print(urlencode(the_title())); ?>"><i class="share icon-facebook"></i></a>&nbsp;

<a href="http://twitter.com/share?text="><i class="share icon-twitter"></i></a>&nbsp;

<a href="javascript:void((function(){var%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)})());"><i class="share icon-pinterest"></i></a>

</div></div>';

}
}


//* Add Slider Below Header
add_action( 'genesis_after_header', 'gather_slider' );
function gather_slider() {
 
    if ( is_front_page( 'slider' ) ) {
        genesis_widget_area( 'slider', array(
            'before' => '<div class="slider widget-area"><div class="wrap"',
            'after' => '</div></div>'
            ) );
    }
}

//* Add Widget Area Below Footer
add_action( 'genesis_after', 'gather_below_footer', 1 );
function gather_below_footer() {

	if ( is_front_page( 'below-footer' ) || is_home( 'below-footer' ) ) {
        genesis_widget_area( 'below-footer', array(
            'before' => '<div class="below-footer widget-area"><div>',
            'after' => '</div></div>'
            ) );
    }
}

//* Add Widget Area Below Footer
add_action( 'genesis_after', 'gather_footer_social', 1 );
function gather_footer_social() {

    if (is_active_sidebar( 'footer-social' )) {
        genesis_widget_area( 'footer-social', array(
            'before' => '<div class="footer-social widget-area"><div>',
            'after' => '</div></div>'
            ) );
    }
}

//* Register widget areas
genesis_register_sidebar( array(
    'id' 			=> 'slider',
    'name' 			=> __( 'Home - Slider', 'gather' ),
    'description' 	=> __( 'This is the slider widget area.', 'gather' ),
) );
genesis_register_sidebar( array(
	'id'           => 'home-half',
	'name'         => __( 'Home - 2 Column', 'gather' ),
	'description'  => __( 'This area will display the Featured Posts Widget in two columns. Other widgets can also be placed here - they will not be displayed with columns.', 'gather' ),
) );
genesis_register_sidebar( array(
	'id'           => 'home-full',
	'name'         => __( 'Home - 1 Column (full width)', 'gather' ),
	'description'  => __( 'This area will display the Featured Posts Widget in full width. Other widgets can also be placed here.', 'gather' ),
) );
genesis_register_sidebar( array(
	'id'           => 'home-third',
	'name'         => __( 'Home - 3 Column', 'gather' ),
	'description'  => __( 'This area will display the Featured Posts Widget in three columns. Other widgets can also be placed here - they will not be displayed with columns.', 'gather' ),
) );
genesis_register_sidebar( array(
	'id'           => 'home-fourth',
	'name'         => __( 'Home - 4 Column', 'gather' ),
	'description'  => __( 'This area will display the Featured Posts Widget in four columns. Other widgets can also be placed here - they will not be displayed with columns.', 'gather' ),
) );
genesis_register_sidebar( array(
	'id'          => 'category-page',
	'name'        => __( 'Category Index Page', 'gather' ),
	'description' => __( 'This is the area for the Category Index.', 'gather' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'gather' ),
	'description' => __( 'This is the after entry widget area.', 'gather' ),
) );
genesis_register_sidebar( array(
    'id' 			=> 'below-footer',
    'name' 			=> __( 'Full Width Footer Area', 'gather' ),
    'description' 	=> __( 'This is the full width footer area that sits below the three footer columns.', 'gather' ),
) );
genesis_register_sidebar( array(
    'id' 			=> 'footer-social',
    'name' 			=> __( 'Footer Social Icons', 'gather' ),
    'description' 	=> __( 'This is the area for the footer social icons.', 'gather' ),
) );
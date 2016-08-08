<?php
/**
 * This file adds the Home Page to the Gather Theme.
 *
 * @author 17thAvenue
 * @package Gather
 * @subpackage Customizations
 */
 
add_action( 'genesis_meta', 'gather_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 * @since  1.0.0
 */
function gather_home_genesis_meta() {

	if ( is_active_sidebar( 'home-full' ) || is_active_sidebar( 'home-half' ) || is_active_sidebar( 'home-third' ) || is_active_sidebar( 'home-fourth' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );

		add_action( 'genesis_loop', 'gather_homepage_widgets' );
		add_filter( 'body_class', 'gather_add_home_body_class' );
	
	}
}

//* Display content for the home sections
function gather_homepage_widgets() {

	echo '<div class="home-half">';

		genesis_widget_area( 'home-half', array(
			'before' => '<div class="home-half widget-area">',
			'after'  => '</div>',
		) );

	echo '</div>';

		echo '<div class="home-full">';

	genesis_widget_area( 'home-full', array(
			'before' => '<div class="home-full widget-area">',
			'after'  => '</div>',
		) );

	echo '</div>';

	echo '<div class="home-third">';

		genesis_widget_area( 'home-third', array(
			'before' => '<div class="home-third widget-area">',
			'after'  => '</div>',
		) );

	echo '</div>';
	
	echo '<div class="home-fourth">';

		genesis_widget_area( 'home-fourth', array(
			'before' => '<div class="home-fourth widget-area">',
			'after'  => '</div>',
		) );

	echo '</div>';

}

//* Add body class to home page		
function gather_add_home_body_class( $classes ) {

	$classes[] = 'gather-home';
	return $classes;
	
}

genesis();
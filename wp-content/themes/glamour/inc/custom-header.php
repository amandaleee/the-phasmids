<?php
/**
 * Custom Header
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package Bloom_Blog_Shop
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses bbs_header_style()
 * @uses bbs_admin_header_style()
 * @uses bbs_admin_header_image()
 */
function bbs_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'bbs_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '333333',
		'width'                  => 160,
		'height'                 => 40,
	) ) );
}
add_action( 'after_setup_theme', 'bbs_custom_header_setup' );
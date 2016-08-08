<?php
/**
 * This file adds the Recipe Index Page to the Gather Theme.
 *
 * @author 17thAvenue
 * @package Gather
 * @subpackage Customizations
 */
 
/*
Template Name: Recipe Index
*/

add_action( 'genesis_meta', 'gather_category_genesis_meta' );
/**
 * Add widget support for recipe index. If no widgets active, display the default loop.
 *
 */
function gather_category_genesis_meta() {

	if ( is_active_sidebar( 'category-page' )) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'gather_category_sections' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

	}
	
}

function gather_category_sections() {

	genesis_widget_area( 'category-page', array(
		'before' => '<div class="category-page widget-area">',
		'after'  => '</div>',
	) );
	
}

genesis();
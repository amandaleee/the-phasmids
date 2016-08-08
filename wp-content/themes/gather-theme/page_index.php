<?php
/**
 * This file adds the Category Index to the Gather theme.
 *
 * @author 17thAvenue
 * @package Gather
 * @subpackage Customizations
 */
 

add_action( 'genesis_meta', 'gather_category_meta' );

function gather_category_meta() {

	if ( is_active_sidebar( 'category-index' )) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'bloom_category_sections' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

	}
	
}

function gather_categories() {

	genesis_widget_area( 'category-index', array(
		'before' => '<div class="category-index widget-area">',
		'after'  => '</div>',
	) );
	
}

genesis();
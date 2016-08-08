<?php
/**
 * This file adds the Landing template to the Gather Theme.
 *
 * @author 17th Avenue
 * @package Gather
 * @subpackage Customizations
 */

/*
Template Name: Landing
*/

//* Add custom body class to the head
add_filter( 'body_class', 'gather_add_body_class' );
function gather_add_body_class( $classes ) {

   $classes[] = 'gather-landing';
   return $classes;
   
}

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove navigation
remove_action( 'genesis_before_header', 'genesis_do_nav' );
remove_action( 'genesis_before', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove site footer widgets
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
remove_action( 'genesis_footer', 'custom_footer' );
remove_action( 'genesis_after', 'gather_footer_social', 1 );
remove_action( 'genesis_after', 'custom_footer', 12 );

//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Run the Genesis loop
genesis();

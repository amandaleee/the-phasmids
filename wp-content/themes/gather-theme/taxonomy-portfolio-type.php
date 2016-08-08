<?php
/**
 * This file adds the portfolio taxonomy template to the Gather theme.
 *
 * @author 17thAvenue
 * @package Gather
 * @subpackage Customizations
 */
 

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info' );

//* Remove the custom post date
remove_action( 'genesis_before_entry_content','gather_add_date');

//* Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove the post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//* Remove the post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );


//* Add portfolio body class to the head
add_filter( 'body_class', 'gather_body_class' );
function gather_body_class( $classes ) {
   
   $classes[] = 'gather-portfolio';
   return $classes;
   
//* Add the featured image after post title
add_action( 'genesis_entry_header', 'gather_portfolio', 1 );
function gather_portoflio() {

    if ( $image = genesis_get_image( 'format=url&size=portfolio' ) ) {
        printf( '<div class="portfolio-featured-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );

    }

}

//* Remove the post meta function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

genesis();
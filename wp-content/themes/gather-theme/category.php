<?php
/**
 * @author    17thAvenue
 * @package   Gather
 * @subpackage customizations
 */
 
//* Category Archive for the Gather theme

//* Remove the post meta and date
remove_action( 'genesis_entry_header', 'genesis_post_info' );
remove_action( 'genesis_before_entry_content','gather_add_date');
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Remove breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove the entry content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//* Remove the post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

//* Add portfolio body class to the head
add_filter( 'body_class', 'gather_body_class' );
function gather_body_class( $classes ) {
   
   $classes[] = 'gather-category-archive';
   return $classes;
   
}

//* Add featured image before post title
add_action( 'genesis_entry_header', 'gather_cat_archive', 1 );
function gather_cat_archive() {

    if ( $image = genesis_get_image( 'format=url&size=category-index' ) ) {
        printf( '<div class="cat-archive-featured-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );

    }

}


//* Run the Genesis loop
genesis();
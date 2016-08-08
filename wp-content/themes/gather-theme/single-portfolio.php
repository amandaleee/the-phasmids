<?php
/**
 * This file adds the custom portfolio single post template to the Gather theme.
 *
 * @author 17thAvenue
 * @package Gather
 * @subpackage Customizations
 */
 

//* Add link back to portfolio page
add_action( 'genesis_after_entry', 'portfolio_link');
function portfolio_link() {
?>
<div class="portfolio-back-button"><a href="<?php echo get_site_url(); ?>/portfolio">Back to Portfolio</a></div>
<?php
}

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 5 );

//* Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove the author box on single posts
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

//* Remove the post meta function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Remove Related Posts
remove_action( 'genesis_after_entry', 'child_related_posts', 1 );

genesis();
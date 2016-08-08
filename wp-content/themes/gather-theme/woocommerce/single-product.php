<?php
/**
 * This template displays the single Product
 *
 * @package genesis_connect_woocommerce
 *
 */

// Force full-width-content on Single Product pages
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove Layout Options from Product Pages
add_action( 'init', 'child_remove_post_type_support' );
/**
 * Remove Genesis inpost layouts from 'product' post_type
 *
 * Hooked to 'init', otherwise won't be removed
 * Note: GCW adds post_type support on genesis_init hook
 *
 * @author Studiograsshopper
 * @link http://www.studiograsshopper.ch
 */
function child_remove_post_type_support() {
	remove_post_type_support( 'product', 'genesis-layouts' );
}

// Remove Related Products from Single Product pages
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

/** Remove default Genesis loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );

/** Remove WooCommerce breadcrumbs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/** Uncomment the below line of code to add back WooCommerce breadcrumbs */
//add_action( 'genesis_before_loop', 'woocommerce_breadcrumb', 10, 0 );

/** Remove Woo #container and #content divs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );


add_action( 'genesis_loop', 'gencwooc_single_product_loop' );
/**
 * Displays single product loop
 *
 * Uses WooCommerce structure and contains all existing WooCommerce hooks
 *
 * Code based on WooCommerce 1.5.5 woocommerce_single_product_content()
 * @see woocommerce/woocommerce-template.php
 *
 * @since 0.9.0
 */
function gencwooc_single_product_loop() {

	do_action( 'woocommerce_before_main_content' );

	// Let developers override the query used, in case they want to use this function for their own loop/wp_query
	$wc_query = false;

	// Added a hook for developers in case they need to modify the query
	$wc_query = apply_filters( 'gencwooc_custom_query', $wc_query );

	if ( ! $wc_query) {

		global $wp_query;

		$wc_query = $wp_query;
	}

	if ( $wc_query->have_posts() ) while ( $wc_query->have_posts() ) : $wc_query->the_post(); ?>

		<?php do_action('woocommerce_before_single_product'); ?>

		<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php do_action( 'woocommerce_before_single_product_summary' ); ?>

			<div class="summary">
					
				<?php do_action( 'woocommerce_single_product_summary'); ?>
		
			</div>

			<?php do_action( 'woocommerce_after_single_product_summary' ); ?>

		</div>

		<?php do_action( 'woocommerce_after_single_product' );

	endwhile;

	do_action( 'woocommerce_after_main_content' );
}


genesis();
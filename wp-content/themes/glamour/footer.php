<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bloom_Blog_Shop
 */

?>
	</div><!-- .wrap -->
	</div><!-- .site-inner -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<div class="wrap">

			<?php if ( is_active_sidebar( 'footer' ) ) : ?>
				<div class="footer-widgets widget-area">
					<?php dynamic_sidebar( 'footer' ); ?>
				</div><!-- .footer-widgets -->
			<?php endif; ?>

		</div>

		<p class="site-info">&copy; Copyright <?php echo the_date( 'Y' ); ?>. <?php echo get_bloginfo( 'title' ); ?>. All Rights Reserved. Design by <a href="http://bloomblogshop.com" rel="designer">Bloom</a>.</p><!-- .site-info -->
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>

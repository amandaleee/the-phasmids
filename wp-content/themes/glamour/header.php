<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bloom_Blog_Shop
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header class="site-header" role="banner">
		<div class="wrap">
			<div class="title-area">
				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php if ( get_header_image() ) : ?>
							<img
								src="<?php header_image(); ?>"
								width="<?php echo esc_attr( get_custom_header()->width ); ?>"
								height="<?php echo esc_attr( get_custom_header()->height ); ?>"
								line-height="<?php echo esc_attr( get_custom_header()->height ); ?>"
								alt=""
							>
						<?php else : ?>
							<?php bloginfo( 'name' ); ?>
						<?php endif; // End header image check. ?>
					</a>
				</h1>
			</div>
			<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container_class' => 'nav',
					'menu_class' => 'nav',
				) );
			?>
			<?php if ( is_active_sidebar( 'social-media-menu' ) ) : ?>
				<div id="social-media-menu" class="social-media-menu widget-area ">
					<?php dynamic_sidebar( 'social-media-menu' ); ?>
				</div><!-- #social-media-menu -->
			<?php endif; ?>
			<div class="search-toggle">
				<i class="dashicons dashicons-search"></i>
				<?php get_search_form(); ?>
			</div>
		</div>
	</header><!-- #masthead -->

	<div class="site-inner">
		<div class="wrap">
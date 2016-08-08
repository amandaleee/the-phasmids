<?php

/**
 * This file adds the Customizer ability to the Chanel Theme.
 *
 * @package      Chanel
 * @subpackage   Customizations
 * @author       17thAvenue
 * @license      GPL-2.0+
 */
 
/**
 * Get default primary color for Customizer.
 *
 * @return string Hex color code for primary color.
 */
function chanel_customizer_get_default_primary_color() {
	return '#FAB9B5';
}

/**
 * Get default accent color for Customizer.
 *
 * @return string Hex color code for accent color.
 */
function chanel_customizer_get_default_accent_color() {
	return '#F9ECE6';
}

add_action( 'customize_register', 'chanel_customizer' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function chanel_customizer(){

global $wp_customize;
	
	$wp_customize->add_setting(
		'chanel_primary_color',
		array(
			'default' => chanel_customizer_get_default_primary_color(),
		)
	);

	$wp_customize->add_setting(
		'chanel_accent_color',
		array(
			'default' => chanel_customizer_get_default_accent_color(),
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'chanel_primary_color',
			array(
				'description' => __( 'Change the default primary color for the newsletter capture areas.', 'chanel' ),
			    'label'       => __( 'Primary Color', 'chanel' ),
			    'section'     => 'colors',
			    'settings'    => 'chanel_primary_color',
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'chanel_accent_color',
			array(
				'description' => __( 'Change the default accent color for links, buttons, and more.', 'chanel' ),
			    'label'       => __( 'Accent Color', 'chanel' ),
			    'section'     => 'colors',
			    'settings'    => 'chanel_accent_color',
			)
		)
	);

}

add_action( 'wp_enqueue_scripts', 'chanel_css' );
/**
* Checks the settings for the images and background colors for each image
* If any of these value are set the appropriate CSS is output
*
* @since 1.0
*/
function chanel_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'chanel';
	
	$color_primary = get_theme_mod( 'chanel_primary_color', chanel_customizer_get_default_primary_color() );
	$color_accent = get_theme_mod( 'chanel_accent_color', chanel_customizer_get_default_accent_color() );
	
	$opts = apply_filters( 'chanel_images', array( 'header', '2', '4', '6' ) );

	$settings = array();

	foreach( $opts as $opt ){
		$settings[$opt]['image'] = preg_replace( '/^https?:/', '', get_option( $opt .'-image', sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $opt ) ) );
	}

	$css = '';

	foreach ( $settings as $section => $value ) { 

		$background = $value['image'] ? sprintf( 'background-image: url(%s);', $value['image'] ) : '';

		$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '
		.front-page-%s {
			%s
		}
		', $section, $background ) : '';

	}
	
	$css .= ( chanel_customizer_get_default_primary_color() !== $color_primary ) ? sprintf( '
		
		.nav-primary,
		.footer-widgets,
		.after-entry,
		.sidebar .enews-widget,
		.footer-widgets .enews-widget,
		.slider .enews-widget,
		.nav-primary {
			background-color: %1$s;
		}
		
		a:hover {
			color: %1$s;
		}

		', $color_primary ) : '';

	$css .= ( chanel_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '
		
		.site-header,
		.site-footer,
		.enews-widget input[type="submit"]:hover,
		button:hover, 
		input[type="button"]:hover, 
		input[type="reset"]:hover, 
		input[type="submit"]:hover, 
		.button:hover,
		.pagination {
			background-color: %1$s;
		}
		
		a {
			background-color: %1$s;
		}
		
		', $color_accent ) : '';

	if( $css ){
		wp_add_inline_style( $handle, $css );
	}

}
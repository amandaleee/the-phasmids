<?php
/**
 * Bloom Blog Shop Theme Customizer.
 *
 * @package Bloom_Blog_Shop
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bbs_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/**
     * Header
     *
     */

    $colors[] = array(
        'slug'      => 'bbs_nav',
        'default'   => '#999999',
        'label'     => 'Header Navigation'
    );

    $colors[] = array(
        'slug'      => 'bbs_nav_hover',
        'default'   => '#333333',
        'label'     => 'Header Navigation Hover'
    );

    /**
     * Links
     *
     */

   $colors[] = array(
        'slug'      => 'bbs_link',
        'default'   => '#999999',
        'label'     => 'Link'
    );

    $colors[] = array(
        'slug'      => 'bbs_link_hover',
        'default'   => '#333333',
        'label'     => 'Link Hover'
    );

    $colors[] = array(
        'slug'      => 'bbs_entry_title',
        'default'   => '#333333',
        'label'     => 'Entry Title'
    );

    $colors[] = array(
        'slug'      => 'bbs_entry_title_hover',
        'default'   => '#333333',
        'label'     => 'Entry Title Hover'
    );

    /**
     * Buttons
     *
     */

    $colors[] = array(
        'slug'      => 'bbs_button_text',
        'default'   => '#333333',
        'label'     => 'Button Text'
    );

    $colors[] = array(
        'slug'      => 'bbs_button_background',
        'default'   => '#ffffff',
        'label'     => 'Button Background'
    );

    $colors[] = array(
        'slug'      => 'bbs_button_border',
        'default'   => '#333333',
        'label'     => 'Button Border'
    );

    $colors[] = array(
        'slug'      => 'bbs_button_hover',
        'default'   => '#333333',
        'label'     => 'Button Hover'
    );

    foreach( $colors as $color ) {

        // SETTINGS
        $wp_customize->add_setting(
            $color['slug'], array(
                'default' => $color['default'],
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );

        // CONTROLS
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                $color['slug'],
                array(
                    'label' => $color['label'],
                    'section' => 'colors',
                    'settings' => $color['slug']
                )
            )
        );
    }
}
add_action( 'customize_register', 'bbs_customize_register' );

function bbs_customizer_css() {

    $headerBackground = get_theme_mod('bbs_header_background');
    $siteTitle = get_theme_mod('bbs_site_title');
    $headerNav = get_theme_mod('bbs_nav');
    $headerNavHover = get_theme_mod('bbs_nav_hover');

    $link = get_theme_mod('bbs_link');
    $linkHover = get_theme_mod('bbs_link_hover');
    $entryTitle = get_theme_mod('bbs_entry_title');
    $entryTitleHover = get_theme_mod('bbs_entry_title_hover');

    $buttonText = get_theme_mod('bbs_button_text');
    $buttonBackground = get_theme_mod('bbs_button_background');
    $buttonBorder = get_theme_mod('bbs_button_border');
    $buttonHover = get_theme_mod('bbs_button_hover');

?><style type="text/css">

a,
.nav ul > li a,
.nav ul .current-menu-item > a,
.nav ul .sub-menu > li a {
    color: <?php echo $link; ?>;
}

a:hover,
.nav ul > li a:hover,
.nav ul .current-menu-item > a:hover,
.nav ul .sub-menu > li a:hover,
.nav ul .sub-menu .current-menu-item > a:hover {
    color: <?php echo $linkHover; ?>;
}

.entry-title a,
.rpwe-title a {
	color: <?php echo $entryTitle; ?>;
}

.entry-title a:hover,
.rpwe-title a:hover {
	color: <?php echo $entryTitleHover; ?>;
}

button,
input[type="button"],
input[type="reset"],
input[type="submit"],
.button {
    background: <?php echo $buttonBackground; ?>;
    color: <?php echo $buttonText; ?>;
    border-color: <?php echo $buttonBorder; ?>;
}

button:hover,
input:hover[type="button"],
input:hover[type="reset"],
input:hover[type="submit"],
.button:hover {
    background: <?php echo $buttonHover; ?>;
    border-color: <?php echo $buttonHover; ?>;
}

input:focus,
textarea:focus {
    border-color: <?php echo $link; ?>;
}

.site-header .site-title a {
    color: <?php echo $siteTitle; ?>;
}

.site-header .nav ul > li > a,
.icon-responsive-nav {
    color: <?php echo $headerNav; ?>;
}

.nav ul > li a:hover,
.nav ul .current-menu-item > a:hover,
.nav ul .sub-menu > li a:hover,
.nav ul .sub-menu .current-menu-item > a:hover {
    color: <?php echo $headerNavHover; ?>;
}

</style><?php
}
add_action( 'wp_head', 'bbs_customizer_css' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bbs_customize_preview_js() {
	wp_enqueue_script( 'bbs_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'bbs_customize_preview_js' );

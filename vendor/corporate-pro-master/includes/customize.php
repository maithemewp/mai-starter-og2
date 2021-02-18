<?php
/**
 * Corporate Pro
 *
 * This file adds Customizer settings to the Corporate Pro theme.
 *
 * @package   SEOThemes\CorporatePro
 * @link      https://seothemes.com/themes/corporate-pro
 * @author    SEO Themes
 * @copyright Copyright © 2019 SEO Themes
 * @license   GPL-3.0-or-later
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'customize_register', 'corporate_customize_register', 20 );
/**
 * Sets up the theme Customizer sections, controls, and settings.
 *
 * @access public
 *
 * @param  object $wp_customize Global Customizer object.
 *
 * @return void
 */
function corporate_customize_register( $wp_customize ) {

	// Globals.
	global $wp_customize;

	// Load RGBA Customizer control.
	include_once CHILD_THEME_DIR . '/includes/rgba.php';

	// Remove default colors, using custom instead.
	$wp_customize->remove_control( 'header_textcolor' );

	// Add logo size setting.
	$wp_customize->add_setting(
		'corporate_logo_size',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => corporate_logo_size(),
			'sanitize_callback' => 'corporate_sanitize_number',
		)
	);

	// Add logo size control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'corporate_logo_size',
			array(
				'label'       => __( 'Logo Size', 'corporate-pro' ),
				'description' => __( 'Set the logo size in pixels. Default is ', 'corporate-pro' ) . corporate_logo_size(),
				'settings'    => 'corporate_logo_size',
				'section'     => 'title_tagline',
				'type'        => 'number',
				'priority'    => 8,
			)
		)
	);

	// Add header settings.
	$wp_customize->add_setting( 'corporate_sticky_header' );

	// Add header controls.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'corporate_sticky_header',
			array(
				'label'    => __( 'Enable sticky header', 'corporate-pro' ),
				'settings' => 'corporate_sticky_header',
				'section'  => 'genesis_layout',
				'type'     => 'checkbox',
			)
		)
	);

	// Add gradient one settings.
	$wp_customize->add_setting(
		'corporate_gradient_one_color',
		array(
			'default'           => corporate_gradient_one_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	// Add gradient one controls.
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'corporate_gradient_one_color',
			array(
				'label'    => __( 'Gradient One Color', 'corporate-pro' ),
				'settings' => 'corporate_gradient_one_color',
				'section'  => 'colors',
			)
		)
	);

	// Add gradient two settings.
	$wp_customize->add_setting(
		'corporate_gradient_two_color',
		array(
			'default'           => corporate_gradient_two_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	// Add gradient two controls.
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'corporate_gradient_two_color',
			array(
				'label'    => __( 'Gradient Two Color', 'corporate-pro' ),
				'settings' => 'corporate_gradient_two_color',
				'section'  => 'colors',
			)
		)
	);

	// Add color setting.
	$wp_customize->add_setting(
		'corporate_overlay_color',
		array(
			'default'           => corporate_overlay_color(),
			'sanitize_callback' => 'corporate_sanitize_rgba',
		)
	);

	// Add color control.
	$wp_customize->add_control(
		new RGBA_Customize_Control(
			$wp_customize,
			'corporate_overlay_color',
			array(
				'section'      => 'colors',
				'label'        => __( 'Overlay Color', 'corporate-pro' ),
				'settings'     => 'corporate_overlay_color',
				'show_opacity' => true,
				'palette'      => true,
			)
		)
	);

}

add_action( 'wp_enqueue_scripts', 'corporate_customizer_output', 100 );
/**
 * Output Customizer styles.
 *
 * Checks the settings for the colors defined in the Customizer.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.1.0
 *
 * @var   array $corporate_colors Global theme colors.
 *
 * @return void
 * @throws Exception
 */
function corporate_customizer_output() {

	// Theme colors.
	$gradient_one = get_theme_mod( 'corporate_gradient_one_color', corporate_gradient_one_color() );
	$gradient_two = get_theme_mod( 'corporate_gradient_two_color', corporate_gradient_two_color() );
	$overlay      = get_theme_mod( 'corporate_overlay_color', corporate_overlay_color() );

	// Other customizer settings.
	$logo_size = get_theme_mod( 'corporate_logo_size', corporate_logo_size() );

	// Load color class.
	include_once CHILD_THEME_DIR . '/includes/colors.php';

	// Initialize accent color.
	$accent = new Corporate_Color( $gradient_one );
	$mix    = '#' . $accent->mix( $gradient_two );
	$shadow = corporate_hex_to_rgba( $mix, 0.3 );

	// Ensure $css var is empty.
	$css = '';

	// Logo size CSS.
	$css .= ( corporate_logo_size() !== $logo_size ) ? sprintf( '

		.wp-custom-logo .title-area {
			width: %1$spx;
		}

	', $logo_size ) : '';

	// Overlay color CSS.
	$css .= ( corporate_overlay_color() !== $overlay ) ? "

		.hero-section:before,
		.front-page-5 .image:before,
		.front-page-9:before,
		.archive.genesis-pro-portfolio .entry:before {
			background: {$overlay};
		}

	" : '';

	// Gradient color CSS.
	$css .= ( corporate_gradient_one_color() !== $gradient_one || corporate_gradient_two_color() !== $gradient_two ) ? "

		.button,
		button,
		input[type='button'],
		input[type='reset'],
		input[type='submit'],
		.front-page-6,
		.archive-pagination .active a,
		.wp-block-button a {
			background: {$gradient_one};
			background: -moz-linear-gradient(-45deg,  {$gradient_one} 0%, {$gradient_two} 100%);
			background: -webkit-linear-gradient(-45deg,  {$gradient_one} 0%,{$gradient_two} 100%);
			background: linear-gradient(135deg,  {$gradient_one} 0%,{$gradient_two} 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$gradient_one}', endColorstr='{$gradient_two}',GradientType=1 );
		}

		.button:hover,
		.button:focus,
		button:hover,
		button:focus,
		input[type='button']:hover,
		input[type='button']:focus,
		input[type='reset']:hover,
		input[type='reset']:focus,
		input[type='submit']:hover,
		input[type='submit']:focus,
		.wp-block-button a:hover,
		.wp-block-button a:focus {
			box-shadow: 0 0.5rem 2rem -0.5rem rgba({$shadow});
		}

		.button.outline,
		button.outline,
		input[type='button'].outline,
		input[type='reset'].outline,
		input[type='submit'].outline {
			color: {$mix};
			background: transparent;
			box-shadow: inset 0 0 0 2px {$mix};
		}

		.button.outline:hover,
		.button.outline:focus,
		button.outline:hover,
		button.outline:focus,
		input[type='button'].outline:hover,
		input[type='button'].outline:focus,
		input[type='reset'].outline:hover,
		input[type='reset'].outline:focus,
		input[type='submit'].outline:hover,
		input[type='submit'].outline:focus {
			background-color: {$mix};
			background: {$gradient_one};
			background: -moz-linear-gradient(-45deg,  {$gradient_one} 0%, {$gradient_two} 100%);
			background: -webkit-linear-gradient(-45deg,  {$gradient_one} 0%,{$gradient_two} 100%);
			background: linear-gradient(135deg,  {$gradient_one} 0%,{$gradient_two} 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$gradient_one}', endColorstr='{$gradient_two}',GradientType=1 );
		}

		a,
		.sidebar a:hover,
		.sidebar a:focus,
		.site-footer a:hover,
		.site-footer a:focus,
		.entry-title a:hover,
		.entry-title a:focus,
		.menu-item a:hover,
		.menu-item a:focus,
		.menu-item.current-menu-item > a,
		.site-footer .menu-item a:hover,
		.site-footer .menu-item a:focus,
		.site-footer .menu-item.current-menu-item > a,
		.entry-content p a:not(.button):hover,
		.entry-content p a:not(.button):focus,
		.pricing-table strong,
		div.gs-faq .gs-faq__question:hover,
		div.gs-faq .gs-faq__question:focus,
		.hero-section a:hover,
		.hero-section a:focus {
			color: {$mix};
		}

		input:focus,
		select:focus,
		textarea:focus {
			border-color: {$mix};
		}

		.entry-content p a:not(.button) {
			box-shadow: inset 0 -1.5px 0 {$mix};
		}

		" : '';

	// WooCommerce only styles.
	if ( corporate_is_woocommerce_page() ) {

		$css .= ( corporate_gradient_one_color() !== $gradient_one || corporate_gradient_two_color() !== $gradient_two ) ? "

			.woocommerce #respond input#submit,
			.woocommerce a.button,
			.woocommerce a.button.alt,
			.woocommerce button.button,
			.woocommerce button.button.alt,
			.woocommerce input.button,
			.woocommerce input.button.alt,
			.woocommerce input.button[type=submit],
			.woocommerce input.button[type=submit].alt {
				background: {$gradient_one};
				background: -moz-linear-gradient(-45deg,  {$gradient_one} 0%, {$gradient_two} 100%);
				background: -webkit-linear-gradient(-45deg,  {$gradient_one} 0%,{$gradient_two} 100%);
				background: linear-gradient(135deg,  {$gradient_one} 0%,{$gradient_two} 100%);
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$gradient_one}', endColorstr='{$gradient_two}',GradientType=1 );
			}

			.woocommerce #respond input#submit:focus,
			.woocommerce #respond input#submit:hover,
			.woocommerce a.button.alt:focus,
			.woocommerce a.button.alt:hover,
			.woocommerce a.button:focus,
			.woocommerce a.button:hover,
			.woocommerce button.button.alt:focus,
			.woocommerce button.button.alt:hover,
			.woocommerce button.button:focus,
			.woocommerce button.button:hover,
			.woocommerce input.button.alt:focus,
			.woocommerce input.button.alt:hover,
			.woocommerce input.button:focus,
			.woocommerce input.button:hover,
			.woocommerce input.button[type=submit].alt:focus,
			.woocommerce input.button[type=submit].alt:hover,
			.woocommerce input.button[type=submit]:focus,
			.woocommerce input.button[type=submit]:hover {
				background: {$gradient_one};
				background: -moz-linear-gradient(-45deg,  {$gradient_one} 0%, {$gradient_two} 100%);
				background: -webkit-linear-gradient(-45deg,  {$gradient_one} 0%,{$gradient_two} 100%);
				background: linear-gradient(135deg,  {$gradient_one} 0%,{$gradient_two} 100%);
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$gradient_one}', endColorstr='{$gradient_two}',GradientType=1 );
				box-shadow: 0 0.5rem 2rem -0.5rem rgba({$shadow});
			}

			.woocommerce div.product p.price,
			.woocommerce div.product span.price,
			div.gs-faq .gs-faq__question:hover,
			div.gs-faq .gs-faq__question:focus {
				color: {$mix};
			}

		" : '';

	}

	// Style handle is the name of the theme.
	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	// Output CSS if not empty.
	if ( ! empty( $css ) ) {

		// Add the inline styles, also minify CSS first.
		wp_add_inline_style( $handle, corporate_minify_css( $css ) );

	}
}

<?php
/**
 * Corporate Pro
 *
 * This file enqueues scripts and styles for the Corporate Pro theme.
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

add_action( 'wp_enqueue_scripts', 'corporate_enqueue_scripts', 20 );
/**
 * Enqueue theme scripts.
 *
 * @since  1.1.0
 *
 * @return void
 */
function corporate_enqueue_scripts() {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$folder = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '/min';

	// Conditionally load slider scripts.
	if ( ! class_exists( 'SEO_Slider_Widget' ) ) {
		wp_enqueue_script( CHILD_THEME_HANDLE . '-modernizr', CHILD_THEME_URI . "/assets/scripts{$folder}/modernizr{$suffix}.js", array( 'jquery' ), '3.5.0', true );
		wp_enqueue_script( CHILD_THEME_HANDLE . '-slick', CHILD_THEME_URI . "/assets/scripts{$folder}/slick{$suffix}.js", array( 'jquery' ), '1.8.1', true );
	}

	// Enqueue fitvids script.
	wp_enqueue_script( CHILD_THEME_HANDLE . '-fitvids', CHILD_THEME_URI . "/assets/scripts{$folder}/fitvids{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );

	// Enqueue custom theme scripts.
	wp_enqueue_script( CHILD_THEME_HANDLE . '-pro', CHILD_THEME_URI . "/assets/scripts{$folder}/theme{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );

	// Enqueue responsive menu script.
	wp_enqueue_script( CHILD_THEME_HANDLE . '-menus', CHILD_THEME_URI . "/assets/scripts{$folder}/menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );

	// Localize responsive menus script.
	wp_localize_script( CHILD_THEME_HANDLE . '-menus', 'genesis_responsive_menu', array(
		'mainMenu'         => '',
		'subMenu'          => '',
		'menuIconClass'    => null,
		'subMenuIconClass' => null,
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
				'.nav-secondary',
			),
		),
	) );
}

add_action( 'wp_enqueue_scripts', 'corporate_enqueue_styles', 20 );
/**
 * Enqueue theme styles.
 *
 * @since  1.1.0
 *
 * @return void
 */
function corporate_enqueue_styles() {

	// Remove Simple Social Icons CSS (included with theme).
	wp_dequeue_style( 'simple-social-icons-font' );

	// Enqueue custom Google fonts.
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Nunito+Sans:400,600,700', array(), CHILD_THEME_VERSION );

	// Conditionally load WooCommerce styles.
	if ( corporate_is_woocommerce_page() ) {

		wp_enqueue_style( CHILD_THEME_HANDLE . '-woocommerce', CHILD_THEME_URI . '/woocommerce.css', array(), CHILD_THEME_VERSION );

	}
}

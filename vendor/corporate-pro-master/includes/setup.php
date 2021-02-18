<?php
/**
 * Corporate Pro
 *
 * This file contains the setup functions for the Corporate Pro theme.
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

// Define theme constants (do not remove).
$child_theme = wp_get_theme();
define( 'CHILD_THEME_NAME', $child_theme->get( 'Name' ) );
define( 'CHILD_THEME_URL', $child_theme->get( 'ThemeURI' ) );
define( 'CHILD_THEME_VERSION', $child_theme->get( 'Version' ) );
define( 'CHILD_THEME_HANDLE', $child_theme->get( 'TextDomain' ) );
define( 'CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

// Set Localization (do not remove).
load_child_theme_textdomain( CHILD_THEME_HANDLE, apply_filters( 'child_theme_textdomain', CHILD_THEME_DIR . '/languages', CHILD_THEME_HANDLE ) );

// Enable support for Gutenberg wide images.
add_theme_support( 'align-wide' );

// Enable support for WooCommerce.
add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

// Add portfolio image size.
add_image_size( 'portfolio', 620, 380, true );

// Add slider image size (incase SEO slider not active).
add_image_size( 'slider', 1280, 720, true );

// Enable support for structural wraps.
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'menu-primary',
	'menu-secondary',
	'footer-widgets',
) );

// Enable Accessibility support.
add_theme_support( 'genesis-accessibility', array(
	'404-page',
	'drop-down-menu',
	'headings',
	'rems',
	'search-form',
	'skip-links',
) );

// Enable custom navigation menus.
add_theme_support( 'genesis-menus', array(
	'primary'   => __( 'Header Menu', 'corporate-pro' ),
	'secondary' => __( 'After Header Menu', 'corporate-pro' ),
) );

// Enable viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Enable footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Enable support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Enable HTML5 markup structure.
add_theme_support( 'html5', array(
	'caption',
	'comment-form',
	'comment-list',
	'gallery',
	'search-form',
) );

// Enable support for post formats.
add_theme_support( 'post-formats', array(
	'aside',
	'audio',
	'chat',
	'gallery',
	'image',
	'link',
	'quote',
	'status',
	'video',
) );

// Enable support for post thumbnails.
add_theme_support( 'post-thumbnails' );

// Enable automatic output of WordPress title tags.
add_theme_support( 'title-tag' );

// Enable selective refresh and Customizer edit icons.
add_theme_support( 'customize-selective-refresh-widgets' );

// Enable theme support for custom background image.
add_theme_support( 'custom-background', array(
	'default-color' => '#ffffff',
) );

// Enable logo option in Customizer > Site Identity.
add_theme_support( 'custom-logo', array(
	'height'      => 60,
	'width'       => 240,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( '.site-title', '.site-description' ),
) );

// Enable support for custom header image or video.
add_theme_support( 'custom-header', array(
	'header-selector'    => '.hero-section',
	'default-image'      => CHILD_THEME_URI . '/assets/images/hero.jpg',
	'header-text'        => true,
	'default-text-color' => '#2a3139',
	'width'              => 1280,
	'height'             => 720,
	'flex-height'        => true,
	'flex-width'         => true,
	'uploads'            => true,
	'video'              => true,
	'wp-head-callback'   => 'corporate_custom_header',
) );

// Enable support for page excerpts.
add_post_type_support( 'page', 'excerpt' );

// Register default header image.
register_default_headers( array(
	'child' => array(
		'url'           => '%2$s/assets/images/hero.jpg',
		'thumbnail_url' => '%2$s/assets/images/hero.jpg',
		'description'   => __( 'Hero Image', 'corporate-pro' ),
	),
) );

// Remove secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Remove unused site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Display custom logo in site title area.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Change order of main stylesheet to override plugin styles.
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 99 );

// Reposition primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_after_title_area', 'genesis_do_nav' );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_after_header_wrap', 'genesis_do_subnav' );

// Reposition the breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'corporate_hero_section', 'genesis_do_breadcrumbs', 30 );

// Reposition featured image.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_post_content', 'genesis_do_post_image' );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );

// Reposition footer widgets inside site footer.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_footer', 'genesis_footer_widget_areas', 14 );

// Remove footer credits.
remove_action( 'genesis_footer', 'genesis_do_footer' );

// Remove Genesis Portfolio Pro default styles.
add_filter( 'genesis_portfolio_load_default_styles', '__return_false' );

// Remove one click demo branding.
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

// Enable shortcodes in text widgets.
add_filter( 'widget_text', 'do_shortcode' );

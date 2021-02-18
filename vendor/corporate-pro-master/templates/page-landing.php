<?php
/**
 * Corporate Pro
 *
 * This file adds the landing page template to the Corporate Pro Theme.
 *
 * Template Name: Landing Page
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

add_filter( 'body_class', 'corporate_add_landing_body_class' );
/**
 * Add landing page body class to the head.
 *
 * @since  1.0.0
 *
 * @param  array $classes Array of body classes.
 *
 * @return array
 */
function corporate_add_landing_body_class( $classes ) {
	$classes[] = 'landing-page';

	return $classes;
}

add_action( 'wp_enqueue_scripts', 'corporate_dequeue_skip_links' );
/**
 * Dequeue Skip Links script.
 *
 * @since  1.0.0
 *
 * @return void
 */
function corporate_dequeue_skip_links() {
	wp_dequeue_script( 'skip-links' );
}

// Remove Skip Links.
remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove default hero section.
remove_action( 'genesis_before_content_sidebar_wrap', 'corporate_hero_section' );

// Remove navigation.
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove footer widgets.
remove_theme_support( 'genesis-footer-widgets' );
remove_action( 'genesis_footer', 'corporate_before_footer' );
remove_action( 'genesis_footer', 'corporate_footer_credits', 14 );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Add title back (removed in /includes/header.php).
remove_action( 'genesis_before', 'corporate_hero_section_setup' );

// Run the Genesis loop.
genesis();

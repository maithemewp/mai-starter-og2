<?php
/**
 * Corporate Pro
 *
 * This file adds the contact page template to the Corporate Pro Theme.
 *
 * Template Name: Contact Page
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

add_filter( 'body_class', 'corporate_add_contact_body_class' );
/**
 * Add contact page body class to the head.
 *
 * @since  1.0.0
 *
 * @param  array $classes Array of body classes.
 *
 * @return array
 */
function corporate_add_contact_body_class( $classes ) {
	$classes[] = 'contact-page';

	return $classes;
}

add_action( 'genesis_before_content_sidebar_wrap', 'corporate_contact_page_map' );
/**
 * Display Google map shortcode.
 *
 * Simply echoes the default map shortcode created by the Google Map plugin.
 *
 * @since  1.0.0
 *
 * @return void
 */
function corporate_contact_page_map() {
	echo do_shortcode( '[ank_google_map]' );
}

// Remove default hero section (show map instead).
remove_action( 'genesis_before_content_sidebar_wrap', 'corporate_hero_section' );

// Add entry title back inside content.
add_action( 'genesis_entry_header', 'genesis_do_post_title', 2 );

// Add page excerpt just below the title.
add_action( 'genesis_entry_header', 'corporate_page_excerpt', 3 );

// Run the Genesis loop.
genesis();

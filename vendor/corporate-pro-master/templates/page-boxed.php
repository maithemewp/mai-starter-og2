<?php
/**
 * Corporate Pro
 *
 * This file adds the boxed page template to the Corporate Pro Theme.
 *
 * Template Name: Boxed Template
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

add_filter( 'body_class', 'corporate_add_boxed_body_class' );
/**
 * Add contact page body class to the head.
 *
 * @since  1.0.0
 *
 * @param  array $classes Array of body classes.
 *
 * @return array
 */
function corporate_add_boxed_body_class( $classes ) {
	$classes[] = 'boxed-page';

	return $classes;
}

// Run the Genesis loop.
genesis();

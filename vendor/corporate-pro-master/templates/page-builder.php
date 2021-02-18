<?php
/**
 * Corporate Pro
 *
 * This file adds the page builder template to the Corporate Pro theme.
 *
 * Template Name: Page Builder
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

// Remove default hero section.
remove_action( 'genesis_after_header', 'corporate_hero_section_open', 20 );
remove_action( 'genesis_after_header', 'corporate_hero_section_title', 24 );
remove_action( 'genesis_after_header', 'corporate_hero_section_close', 28 );

// Get site-header.
get_header();

// Custom loop, remove all hooks except entry content.
if ( have_posts() ) :
	the_post();
	do_action( 'genesis_entry_content' );
endif;

// Get site-footer.
get_footer();

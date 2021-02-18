<?php
/**
 * Corporate Pro
 *
 * This file registers the required plugins for the Corporate Pro theme.
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

add_filter( 'icon_widget_default_font', 'corporate_icon_widget_default_font' );
/**
 * Set the default icon widget font.
 *
 * @since  1.0.0
 *
 * @return string
 */
function corporate_icon_widget_default_font() {
	return 'streamline';
}

add_filter( 'icon_widget_default_color', 'corporate_icon_widget_default_color' );
/**
 * Set the default icon widget font.
 *
 * @since  1.0.0
 *
 * @return string
 */
function corporate_icon_widget_default_color() {
	return corporate_gradient_two_color();
}

add_filter( 'icon_widget_default_size', 'corporate_icon_widget_default_size' );
/**
 * Set the default icon widget font.
 *
 * @since  1.0.0
 *
 * @return string
 */
function corporate_icon_widget_default_size() {
	return '2x';
}

add_filter( 'icon_widget_default_align', 'corporate_icon_widget_default_align' );
/**
 * Set the default icon widget font.
 *
 * @since  1.0.0
 *
 * @return string
 */
function corporate_icon_widget_default_align() {
	return 'left';
}

add_filter( 'seo_slider_default_overlay', 'corporate_default_slider_overlay' );
/**
 * Set the default slider overlay color.
 *
 * @since  1.0.0
 *
 * @return string
 */
function corporate_default_slider_overlay() {
	return corporate_overlay_color();
}

add_filter( 'genesis_theme_settings_defaults', 'corporate_theme_defaults' );
/**
 * Update theme settings upon reset.
 *
 * @since  1.0.0
 *
 * @param  array $defaults Default theme settings.
 *
 * @return array Custom theme settings.
 */
function corporate_theme_defaults( $defaults ) {
	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'excerpt';
	$defaults['content_archive_limit']     = 150;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignnone';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['image_size']                = 'portfolio';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;
}

add_action( 'after_switch_theme', 'corporate_theme_setting_defaults' );
/**
 * Update theme settings upon activation.
 *
 * @since  1.0.0
 *
 * @return void
 */
function corporate_theme_setting_defaults() {
	if ( function_exists( 'genesis_update_settings' ) ) {
		genesis_update_settings( array(
			'blog_cat_num'              => 6,
			'content_archive'           => 'excerpt',
			'content_archive_limit'     => 150,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignnone',
			'image_size'                => 'portfolio',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'full-width-content',
		) );
	}

	update_option( 'posts_per_page', 9 );
}

add_filter( 'simple_social_default_styles', 'corporate_social_default_styles' );
/**
 * Set the Simple Social Icon defaults.
 *
 * @since  1.0.0
 *
 * @param  array $defaults Default Simple Social Icons settings.
 *
 * @return array Custom settings.
 */
function corporate_social_default_styles( $defaults ) {
	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '',
		'background_color_hover' => '',
		'border_radius'          => 0,
		'border_color'           => '#fdfeff',
		'border_color_hover'     => '#fdfeff',
		'border_width'           => 0,
		'icon_color'             => '#c6cace',
		'icon_color_hover'       => corporate_gradient_two_color(),
		'size'                   => 40,
		'new_window'             => 1,
		'facebook'               => '#',
		'gplus'                  => '#',
		'instagram'              => '#',
		'dribbble'               => '#',
		'twitter'                => '#',
		'youtube'                => '#',
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;
}

add_filter( 'gsw_settings_defaults', 'corporate_testimonial_defaults' );
/**
 * Filter the default Genesis Testimonial Slider settings.
 *
 * @since  1.0.0
 *
 * @return array
 */
function corporate_testimonial_defaults() {
	$defaults = array(
		'gts_autoplay' => 'yes',
		'gts_column'   => 'three',
		'gts_controls' => 'yes',
		'gts_loop'     => 'yes',
		'gts_effect'   => 'slide',
		'gts_pause'    => 'yes',
		'gts_speed'    => '6000',
	);

	return $defaults;
}

add_filter( 'genesis_widget_column_classes', 'corporate_widget_columns' );
/**
 * Add additional column class to plugin.
 *
 * @since  1.0.0
 *
 * @param  array $column_classes Array of column classes.
 *
 * @return array Modified column classes.
 */
function corporate_widget_columns( $column_classes ) {
	$column_classes[] = 'full-width';

	return $column_classes;
}

add_action( 'after_switch_theme', 'corporate_excerpt_metabox' );
/**
 * Display excerpt metabox by default.
 *
 * The excerpt metabox is hidden by default on the page edit screen which
 * can cause some confusion for users when they want to edit or remove
 * the excerpt. To make life easier, we want to display the metabox
 * by default and that's what this function does. It is only run
 * after switching theme so the current user's screen options
 * are updated which allows them to hide the metabox again.
 *
 * @since  1.0.0
 *
 * @return void
 */
function corporate_excerpt_metabox() {

	// Get current user ID.
	$user_id = get_current_user_id();

	// Create array of post types to include.
	$post_types = array(
		'page',
		'post',
		'portfolio',
	);

	// Loop through each post type and update user meta.
	foreach ( $post_types as $post_type ) {

		// Create variables.
		$meta_key   = 'metaboxhidden_' . $post_type;
		$prev_value = get_user_meta( $user_id, $meta_key, true );

		// Check if value is an array.
		if ( ! is_array( $prev_value ) ) {
			$prev_value = array(
				'genesis_inpost_seo_box',
				'postcustom',
				'postexcerpt',
				'commentstatusdiv',
				'commentsdiv',
				'slugdiv',
				'authordiv',
				'genesis_inpost_scripts_box',
			);
		}

		// Remove excerpt from array.
		$meta_value = array_diff( $prev_value, array( 'postexcerpt' ) );

		// Update user meta with new value.
		update_user_meta( $user_id, $meta_key, $meta_value, $prev_value );
	}
}

add_filter( 'pt-ocdi/import_files', 'corporate_import_files' );
/**
 * One click demo import settings.
 *
 * @since  1.0.1
 *
 * @return array
 */
function corporate_import_files() {
	return array(
		array(
			'local_import_file'            => CHILD_THEME_DIR . '/sample.xml',
			'local_import_widget_file'     => CHILD_THEME_DIR . '/widgets.wie',
			'import_file_name'             => 'Demo Import',
			'categories'                   => false,
			'local_import_redux'           => false,
			'import_preview_image_url'     => false,
			'import_notice'                => false,
		),
	);
}

add_filter( 'pt-ocdi/after_all_import_execution', 'corporate_after_demo_import', 999 );
/**
 * Set default pages after demo import.
 *
 * Automatically creates and sets the Static Front Page and the Page for Posts
 * upon theme activation, only if these pages don't already exist and only
 * if the site does not already display a static page on the homepage.
 *
 * @since  1.0.0
 *
 * @return void
 */
function corporate_after_demo_import() {

	// Assign menus to their locations.
	$menu = get_term_by( 'name', 'Header Menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
		'primary' => $menu->term_id,
	) );

	// Assign front page and posts page (blog page).
	$home = get_page_by_title( 'Home' );
	$news = get_page_by_title( 'News' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home->ID );
	update_option( 'page_for_posts', $news->ID );

	// Set the WooCommerce shop page.
	$shop = get_page_by_title( 'Shop' );

	update_option( 'woocommerce_shop_page_id', $shop->ID );

	// Trash "Hello World" post.
	wp_delete_post( 1 );
}

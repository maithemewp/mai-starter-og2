<?php
/**
 * Mai Starter theme.
 *
 * @package   BizBudding\MaiStarter
 * @link      https://bizbudding.com/
 * @author    BizBudding
 * @copyright Copyright © 2020 BizBudding
 * @license   GPL-2.0-or-later
 */

require_once __DIR__ . '/vendor/autoload.php';

/**********************************
 * Add your customizations below! *
 **********************************/

/**
 * Register custom post types.
 *
 * @return void.
 */
add_action( 'init', function() {

	register_post_type( 'mai_theme', [
		'exclude_from_search' => false,
		'has_archive'         => true,
		'hierarchical'        => false,
		'labels'              => [
			'name'               => _x( 'Themes', 'Theme general name', 'bizbudding' ),
			'singular_name'      => _x( 'Theme', 'Theme singular name', 'bizbudding' ),
			'menu_name'          => _x( 'Themes', 'Theme admin menu', 'bizbudding' ),
			'name_admin_bar'     => _x( 'Theme', 'Theme add new on admin bar', 'bizbudding' ),
			'add_new'            => _x( 'Add New', 'Theme', 'bizbudding' ),
			'add_new_item'       => __( 'Add New Theme',  'bizbudding' ),
			'new_item'           => __( 'New Theme', 'bizbudding' ),
			'edit_item'          => __( 'Edit Theme', 'bizbudding' ),
			'view_item'          => __( 'View Theme', 'bizbudding' ),
			'all_items'          => __( 'All Themes', 'bizbudding' ),
			'search_items'       => __( 'Search Themes', 'bizbudding' ),
			'parent_item_colon'  => __( 'Parent Themes:', 'bizbudding' ),
			'not_found'          => __( 'No Themes found.', 'bizbudding' ),
			'not_found_in_trash' => __( 'No Themes found in Trash.', 'bizbudding' )
		],
		'menu_icon'          => 'dashicons-welcome-widgets-menus',
		'public'             => true,
		'publicly_queryable' => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'show_ui'            => true,
		'rewrite'            => [ 'slug' => 'themes', 'with_front' => false ],
		'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'genesis-cpt-archives-settings', 'genesis-layouts', 'mai-archive-settings', 'mai-single-settings' ],
		// 'taxonomies'         => [ 'slideshow_cat' ],
	] );
});

/**
 * Sort themes by menu_order.
 *
 * @return void
 */
add_action( 'pre_get_posts', function( $query ) {
	if ( ! $query->is_main_query() ) {
		return;
	}
	// Bail if not the main showcase archive.
	if ( ! is_post_type_archive( 'theme' ) ) {
		return;
	}
	// Order by menu order.
	$query->set( 'orderby', 'menu_order');
	$query->set( 'order', 'ASC' );
});

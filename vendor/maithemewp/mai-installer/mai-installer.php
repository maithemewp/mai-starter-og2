<?php
/**
 * Mai Installer.
 *
 * @package   BizBudding\MaiInstaller
 * @link      https://bizbuding.com
 * @author    BizBudding
 * @copyright Copyright © 2020 BizBudding
 * @license   GPL-2.0-or-later
 */

// Needed in theme's functions.php file.
add_filter( 'pand_theme_loader', '__return_true' );

add_action( 'after_setup_theme', 'mai_plugin_dependencies' );
/**
 * Description of expected behavior.
 *
 * @since 1.0.0
 *
 * @return void
 */
function mai_plugin_dependencies() {

	// Set plugin dependencies.
	$config = apply_filters( 'mai_plugin_dependencies', [
		[
			'name'     => 'Mai Engine',
			'host'     => 'github',
			'slug'     => 'mai-engine/mai-engine.php',
			'uri'      => 'maithemewp/mai-engine',
			'branch'   => 'master',
			'optional' => false,
		],
	] );

	// Install and active dependencies.
	\WP_Dependency_Installer::instance()->load_hooks();
	\WP_Dependency_Installer::instance()->register( $config );
}

add_action( 'admin_init', 'mai_theme_redirect', 100 );
/**
 * Redirect after activation.
 *
 * @since 1.0.0
 *
 * @return void
 */
function mai_theme_redirect() {
	global $pagenow;

	if ( "themes.php" == $pagenow && is_admin() && isset( $_GET['activated'] ) ) {
		exit( wp_redirect( admin_url( 'admin.php?page=mai-demo-import' ) ) );
	}
}

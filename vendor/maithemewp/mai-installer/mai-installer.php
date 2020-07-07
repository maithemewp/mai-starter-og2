<?php
/**
 * Mai Installer.
 *
 * @package   BizBudding\MaiInstaller
 * @link      https://bizbuding.com
 * @author    BizBudding
 * @copyright Copyright © 2020 BizBudding
 * @license   GPL-2.0-or-later
 * @version   1.2.0
 */

/**
 * Add theme support for Mai Engine.
 *
 * Default Mai Engine themes are already supported so let's check first.
 *
 * @since 1.1.0
 *
 * @return void
 */
if ( ! current_theme_supports( 'mai-engine' ) ) {
	add_theme_support( 'mai-engine' );
}

/**
 * Allow WP_Dependency_Installer to be used in a plugin.
 *
 * @since 1.0.0
 *
 * @return bool
 */
add_filter( 'pand_theme_loader', '__return_true' );

add_action( 'after_setup_theme', 'mai_plugin_dependencies' );
/**
 * Pass config to WP Dependency Installer.
 *
 * @since 1.2.0
 *
 * @return void
 */
function mai_plugin_dependencies() {

	// Filter dependencies for use in engine plugin.
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
	\WP_Dependency_Installer::instance()->register( $config )->run();
}

add_action( 'admin_init', 'mai_theme_redirect', 100 );
/**
 * Redirect after activation.
 *
 * @since 1.2.0
 *
 * @return void
 */
function mai_theme_redirect() {
	global $pagenow;

	if ( 'themes.php' === $pagenow && is_admin() && isset( $_GET['activated'] ) ) {
		exit( wp_redirect( admin_url( 'admin.php?page=mai-setup-wizard' ) ) );
	}
}

<?php
/**
 * Corporate Pro
 *
 * This file sets up the Corporate Pro Theme.
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

// Load Genesis Framework (do not remove).
require_once get_template_directory() . '/lib/init.php';

// Load setup functions.
require_once __DIR__ . '/includes/setup.php';

// Load helper functions.
require_once __DIR__ . '/includes/helpers.php';

// Load scripts and styles.
require_once __DIR__ . '/includes/enqueue.php';

// Load general functions.
require_once __DIR__ . '/includes/general.php';

// Load widget areas.
require_once __DIR__ . '/includes/widgets.php';

// Load hero section.
require_once __DIR__ . '/includes/hero.php';

// Load Customizer settings.
require_once __DIR__ . '/includes/customize.php';

// Load default settings.
require_once __DIR__ . '/includes/defaults.php';

// Load recommended plugins.
require_once __DIR__ . '/includes/plugins.php';

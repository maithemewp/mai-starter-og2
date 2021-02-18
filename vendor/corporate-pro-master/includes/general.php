<?php
/**
 * Corporate Pro
 *
 * This file adds general theme functions to the Corporate Pro Theme.
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

add_filter( 'body_class', 'corporate_body_classes' );
/**
 * Add additional classes to the body element.
 *
 * Adds some extra classes to the body element which help with styling the
 * same elements differently depending on which settings the user has
 * chosen from either the Customizer, Widget Areas or Navigation.
 *
 * @since  1.1.0
 *
 * @param  array $classes Body classes.
 *
 * @return array
 */
function corporate_body_classes( $classes ) {
	if ( true === get_theme_mod( 'corporate_sticky_header', false ) ) {
		$classes[] = 'has-sticky-header';
	}

	if ( is_active_sidebar( 'before-header' ) ) {
		$classes[] = 'has-before-header';
	}

	if ( has_nav_menu( 'secondary' ) ) {
		$classes[] = 'has-nav-secondary';
	}

	if ( is_page_template( 'page_blog.php' ) ) {
		$classes[] = 'blog';

		$classes = array_diff( $classes, [ 'page' ] );
	}

	if ( corporate_sidebar_has_widget( 'front-page-1', 'seo_slider' ) ) {
		$classes[] = 'has-hero-slider';
	}

	if ( is_front_page() ) {
	    $classes[] = 'front-page';
    }

	$classes[] = 'no-js';

	return $classes;
}

add_action( 'genesis_before', 'corporate_js_nojs_script', 1 );
/**
 * Echo out the script that changes 'no-js' class to 'js'.
 *
 * Adds a script on the genesis_before hook which immediately changes the
 * class to js if JavaScript is enabled. This is how WP does things on
 * the back end, to allow different styles for the same elements
 * depending if JavaScript is active or not.
 *
 * Outputting the script immediately also reduces a flash of incorrectly
 * styled content, as the page does not load with no-js styles, then
 * switch to js once everything has finished loading.
 *
 * @since  1.0.0
 *
 * @return void
 */
function corporate_js_nojs_script() {
	?>
    <script>
        //<![CDATA[
        (function () {
            var c = document.body.classList;
            c.remove('no-js');
            c.add('js');
        })();
        //]]>
    </script>
	<?php
}

add_filter( 'genesis_attr_title-area', 'corporate_title_area_schema' );
/**
 * Add schema microdata to title-area.
 *
 * By default, Genesis applies no schema microdata to the title area element.
 * Since this is a business theme, the site title is usually the business
 * name, so we want to mark up this section with the relevant schema.
 *
 * @since  1.0.0
 *
 * @param  array $attr Array of attributes.
 *
 * @return array
 */
function corporate_title_area_schema( $attr ) {
	$attr['itemscope'] = 'itemscope';
	$attr['itemtype']  = 'http://schema.org/Organization';

	return $attr;
}

add_filter( 'genesis_attr_site-title', 'corporate_site_title_schema' );
/**
 * Correct site title schema.
 *
 * Genesis adds the headline itemprop to the site title by default. Since we
 * already have a headline (page title) we can remove this and replace it
 * with an itemprop of name which is inside of the Organization scope.
 *
 * @since  1.0.0
 *
 * @param  array $attr Array of attributes.
 *
 * @return array
 */
function corporate_site_title_schema( $attr ) {
	$attr['itemprop'] = 'name';

	return $attr;
}

add_action( 'init', 'corporate_structural_wrap_hooks' );
/**
 * Add hooks before and after Genesis structural wraps.
 *
 * This is a clever workaround that allows us to insert HTML between a container
 * and its immediate descendant .wrap element. These hooks are used to display
 * the Before Header widget area, the Secondary Nav and the Footer Widgets.
 *
 * @since  1.0.0
 *
 * @author Tim Jensen
 * @link   https://timjensen.us/add-hooks-before-genesis-structural-wraps
 *
 * @return void
 */
function corporate_structural_wrap_hooks() {
	$wraps = get_theme_support( 'genesis-structural-wraps' );

	foreach ( $wraps[0] as $context ) {

		/**
		 * Inserts an action hook before the opening div and after the closing div
		 * for each of the structural wraps.
		 *
		 * @param string $output   HTML for opening or closing the structural wrap.
		 * @param string $original Either 'open' or 'close'.
		 *
		 * @return string
		 */
		add_filter( "genesis_structural_wrap-{$context}", function ( $output, $original ) use ( $context ) {

			$position = ( 'open' === $original ) ? 'before' : 'after';

			ob_start();
			do_action( "genesis_{$position}_{$context}_wrap" );

			if ( 'open' === $original ) {
				return ob_get_clean() . $output;
			} else {
				return $output . ob_get_clean();
			}
		}, 10, 2 );
	}
}

add_filter( 'http_request_args', 'corporate_dont_update_theme', 5, 2 );
/**
 * Prevent automatic theme updates.
 *
 * Because WordPress (the software) doesn’t know whether a theme or plugin is
 * listed in the WordPress.org repositories, it has to check them all, and
 * let the repository sort it out. If there is a theme in the repo with
 * the same name this prevents WP from prompting an automatic update.
 *
 * @since  1.0.0
 *
 * @link   https://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 *
 * @param  array  $request Request arguments.
 * @param  string $url     Request url.
 *
 * @return array  request arguments
 */
function corporate_dont_update_theme( $request, $url ) {

	// Not a theme update request. Bail immediately.
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) ) {
		return $request;
	}

	$themes = unserialize( $request['body']['themes'] );

	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );

	$request['body']['themes'] = serialize( $themes );

	return $request;
}

add_filter( 'agm_custom_styles', 'corporate_map_styles' );
/**
 * Custom Google map style (Ultra Light).
 *
 * Adds a custom Google map style to the Google Map plugin used in the theme demo.
 * The JSON file used in this function can be found in the top level directory
 * of the theme. More information can be found by following the links below.
 *
 * @since 1.0.0
 *
 * @link  https://github.com/ankurk91/wp-google-map/wiki/How-to-add-your-own-styles
 * @link  https://snazzymaps.com/style/85413/cartagena
 *
 * @param array $json Array of JSON data.
 *
 * @return array
 */
function corporate_map_styles( $json ) {
	array_push( $json, array(
		'id'    => '123456789',
		'name'  => 'Ultra Light',
		'style' => json_decode( file_get_contents( CHILD_THEME_DIR . '/map.json' ), true ),
	) );

	return $json;
}

add_filter( 'genesis_markup_title-area_close', 'corporate_after_title_area', 10, 2 );
/**
 * Appends HTML to the closing markup for .title-area.
 *
 * Adding something between the title + description and widget area used to require
 * re-building genesis_do_header(). However, since the title-area closing markup
 * now goes through genesis_markup(), it means we now have some extra filters
 * to play with. This function makes use of this and adds in an extra hook
 * after the title-area used for displaying the primary navigation menu.
 *
 * @since  1.0.0
 *
 * @param  string $close_html HTML tag being processed by the API.
 * @param  array  $args       Array with markup arguments.
 *
 * @return string
 */
function corporate_after_title_area( $close_html, $args ) {
	if ( $close_html ) {
		ob_start();
		do_action( 'genesis_after_title_area' );
		$close_html = $close_html . ob_get_clean();
	}

	return $close_html;
}

add_action( 'genesis_entry_header', 'corporate_reposition_post_meta', 0 );
/**
 * Reposition post info and remove excerpts on archives.
 *
 * Small customization to reposition the post info and remove the excerpt links
 * on all archive pages including search results, blog page, categories etc.
 *
 * @since  1.0.0
 *
 * @return void
 */
function corporate_reposition_post_meta() {
	if ( is_archive() || is_home() || is_search() || is_post_type_archive() ) {

		// Reposition post meta.
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		add_action( 'genesis_entry_header', 'genesis_post_info', 1 );

		// Remove read more link on archives.
		add_filter( 'get_the_content_more_link', '__return_empty_string' );

	}
}

add_filter( 'genesis_post_info', 'corporate_post_info_date' );
/**
 * Change the default post info on archives.
 *
 * Replaces the default post info (author, comments, edit link) with just the
 * date of the post, which is then repositioned above the entry title with
 * the corporate_reposition_post_meta() function above on archive pages.
 *
 * @since  1.0.0
 *
 * @param  string $post_info The default post information.
 *
 * @return string
 */
function corporate_post_info_date( $post_info ) {
	if ( is_archive() || is_home() || is_search() || is_post_type_archive() ) {
		$post_info = '[post_date]';
	}

	return $post_info;
}

add_filter( 'genesis_post_meta', 'corporate_post_meta_filter' );
/**
 * Customize the entry meta in the entry footer.
 *
 * This function filters the genesis post meta to display SVG icons before the
 * post categories and post tags on archive pages including the search page,
 * blog, category and tag pages. SVG images are included with the theme.
 *
 * @since  1.0.0
 *
 * @param  string $post_meta Default post meta.
 *
 * @return string
 */
function corporate_post_meta_filter( $post_meta ) {
	if ( is_archive() || is_home() || is_search() || ! is_post_type_archive() ) {
		$cat_alt   = apply_filters( 'corporate_cat_alt', __( 'Category icon', 'corporate-pro' ) );
		$tag_alt   = apply_filters( 'corporate_tag_alt', __( 'Tag icon', 'corporate-pro' ) );
		$cat_img   = '<img width=\'20\' height=\'20\' alt=\'' . $cat_alt . '\' src=\'' . CHILD_THEME_URI . '/assets/images/cats.svg\'>';
		$tag_img   = '<img width=\'20\' height=\'20\' alt=\'' . $tag_alt . '\' src=\'' . CHILD_THEME_URI . '/assets/images/tags.svg\'>';
		$post_meta = '[post_categories before="' . $cat_img . '" sep=",&nbsp;"] [post_tags before="' . $tag_img . '" sep=",&nbsp;"]';
	}

	return $post_meta;
}

add_filter( 'genesis_attr_site-container', 'corporate_primary_nav_id' );
/**
 * Add ID attribute to site-container.
 *
 * This adds an ID attribute to the site-container by filtering the element
 * attributes so that the "Return to Top" link has something to link to.
 *
 * @since  1.0.0
 *
 * @param  array $atts Navigation attributes.
 *
 * @return array
 */
function corporate_primary_nav_id( $atts ) {
	$atts['id'] = 'top';

	return $atts;
}

add_shortcode( 'footer_backtotop', 'corporate_footer_backtotop_shortcode' );
/**
 * Produces the "Return to Top" link.
 *
 * Supported shortcode attributes are:
 * - after (output after link, default is empty string),
 * - before (output before link, default is empty string),
 * - href (link url, default is fragment identifier '#wrap'),
 * - nofollow (boolean for whether to include rel="nofollow", default is true),
 * - text (Link text, default is 'Return to top of page').
 *
 * Output passes through `corporate_footer_backtotop_shortcode` filter before returning.
 *
 * @since  1.0.0
 *
 * @param  array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return string Output for `footer_backtotop` shortcode.
 */
function corporate_footer_backtotop_shortcode( $atts ) {
	$defaults = array(
		'after'    => '',
		'before'   => '',
		'href'     => '#top',
		'nofollow' => true,
		'text'     => __( 'Return to top', 'genesis' ),
	);

	$atts = shortcode_atts( $defaults, $atts, 'footer_backtotop' );

	$nofollow = $atts['nofollow'] ? 'rel="nofollow"' : '';

	$output = sprintf( '%s<a href="%s" %s>%s</a>%s', $atts['before'], esc_url( $atts['href'] ), $nofollow, $atts['text'], $atts['after'] );

	return apply_filters( 'corporate_footer_backtotop_shortcode', $output, $atts );
}


add_filter( 'genesis_site_layout', 'corporate_search_and_404_page_layouts' );
/**
 * Gets a custom page layout for the search results page.
 *
 * @since  1.0.0
 *
 * @return string
 */
function corporate_search_and_404_page_layouts() {
	if ( is_search() ) {
		$page   = get_page_by_path( 'search' );
		$field  = genesis_get_custom_field( '_genesis_layout', $page->ID );
		$layout = $field ? $field : genesis_get_option( 'site_layout' );

		return $layout;
	}

	if ( is_404() ) {
		$page   = get_page_by_path( 'error-404' );
		$field  = genesis_get_custom_field( '_genesis_layout', $page->ID );
		$layout = $field ? $field : genesis_get_option( 'site_layout' );

		return $layout;
	}
}

add_filter( 'wp_nav_menu_items', 'corporate_menu_extras', 10, 2 );
/**
 * Filter menu items, appending a search form.
 *
 * @since 1.1.0
 *
 * @param string   $menu HTML string of list items.
 * @param stdClass $args Menu arguments.
 *
 * @return string Amended HTML string of list items.
 */
function corporate_menu_extras( $menu, $args ) {
    $settings = get_option( 'genesis-settings', false );

    if ( isset( $settings[ 'nav_extras' ] ) && 'search' === $settings[ 'nav_extras'] ) {
        return $menu;
    }

	if ( 'primary' !== $args->theme_location ) {
		return $menu;
	}

	ob_start();
	get_search_form();
	$search = ob_get_clean();
	$menu   .= '<li class="right search">' . $search . '</li>';

	return $menu;
}

<?php

/**
 * SmartShop Theme Functions
 *
 * @package SmartShop
 * @version 1.0.0
 */


if (!defined('ABSPATH')) {
  exit;
}


// ─── Constants ────────────────────────────────────────────────────────────────

define( 'SMARTSHOP_VERSION',   '1.0.0' );
define( 'SMARTSHOP_DIR',       get_template_directory() );
define( 'SMARTSHOP_URI',       get_template_directory_uri() );
define( 'SMARTSHOP_ASSETS',    SMARTSHOP_URI . '/assets' );
define( 'SMARTSHOP_MIN_PHP',   '7.4' );
define( 'SMARTSHOP_MIN_WP',    '6.4' );


// ─── PHP / WP version gate ────────────────────────────────────────────────────

if ( version_compare( PHP_VERSION, SMARTSHOP_MIN_PHP, '<' ) ) {
	add_action( 'admin_notices', static function () {
		printf(
			'<div class="notice notice-error"><p>%s</p></div>',
			esc_html(
				sprintf(
					/* translators: 1: required PHP version, 2: current PHP version */
					__( 'SmartShop requires PHP %1$s or higher. You are running %2$s.', 'smartshop' ),
					SMARTSHOP_MIN_PHP,
					PHP_VERSION
				)
			)
		);
	} );
	return;
}

// ─── Load modules ─────────────────────────────────────────────────────────────

$smartshop_modules = [
	'/inc/setup.php',
	'/inc/helpers.php',
	'/inc/template-functions.php',
	'/inc/template-tags.php',
	'/inc/enqueue.php',
	'/inc/woocommerce.php',
	'/inc/hooks.php',
	'/inc/widgets.php',
	'/inc/sidebar.php',
	'/inc/customizer.php',
	'/inc/customizer-css.php',
	'/inc/security.php',
	'/inc/performance.php',
	'/inc/ajax.php',
];

foreach ( $smartshop_modules as $module ) {
	$path = SMARTSHOP_DIR . $module;
	if ( file_exists( $path ) ) {
		require_once $path;
	}
}
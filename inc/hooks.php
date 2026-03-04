<?php
/**
 * SmartShop Template Hooks
 *
 * Wire actions to template-parts rather than hardcoding output
 * inside template files. This keeps templates clean and overridable.
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;

// ─── <head> additions ─────────────────────────────────────────────────────────

/**
 * Output viewport meta and theme color in <head>.
 * (wp_head() handles most of this, but theme-color is not automatic.)
 */
add_action( 'wp_head', static function (): void {
	echo '<meta name="theme-color" content="#ffffff">' . "\n";
}, 1 );

// ─── Header ───────────────────────────────────────────────────────────────────

/**
 * Output site branding (logo or site name).
 */
function smartshop_site_branding(): void {
	get_template_part( 'template-parts/header/site-branding' );
}
add_action( 'smartshop_header', 'smartshop_site_branding', 10 );

/**
 * Output primary navigation.
 */
function smartshop_primary_navigation(): void {
	get_template_part( 'template-parts/header/navigation-primary' );
}
add_action( 'smartshop_header', 'smartshop_primary_navigation', 20 );

/**
 * Output header utilities (search, cart icon, account).
 */
function smartshop_header_utilities(): void {
	get_template_part( 'template-parts/header/header-utilities' );
}
add_action( 'smartshop_header', 'smartshop_header_utilities', 30 );

// ─── Footer ───────────────────────────────────────────────────────────────────

/**
 * Output footer widget area.
 */
function smartshop_footer_widgets(): void {
	get_template_part( 'template-parts/footer/footer-widgets' );
}
add_action( 'smartshop_footer', 'smartshop_footer_widgets', 10 );

/**
 * Output footer bottom bar (copyright, links).
 */
function smartshop_footer_bottom(): void {
	get_template_part( 'template-parts/footer/footer-bottom' );
}
add_action( 'smartshop_footer', 'smartshop_footer_bottom', 20 );

// ─── Page header ──────────────────────────────────────────────────────────────
// TODO Phase 2: create template-parts/global/page-header.php then hook it here.
// add_action( 'smartshop_before_content', 'smartshop_page_header', 10 );
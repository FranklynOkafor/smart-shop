<?php
/**
 * SmartShop Asset Enqueueing
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue front-end styles and scripts.
 */
function smartshop_enqueue_assets(): void {

	// ── Styles ────────────────────────────────────────────────────────────────

	// Main stylesheet (style.css at root is always loaded by WP; we enqueue our compiled CSS separately).
	wp_enqueue_style(
		'smartshop-theme',
		SMARTSHOP_ASSETS . '/css/theme.css',
		[],
		SMARTSHOP_VERSION
	);

	// WooCommerce additions (loaded only when WooCommerce is active).
	if ( smartshop_is_woocommerce_active() ) {
		wp_enqueue_style(
			'smartshop-woocommerce',
			SMARTSHOP_ASSETS . '/css/woocommerce.css',
			[ 'smartshop-theme' ],
			SMARTSHOP_VERSION
		);
	}

	// ── Scripts ───────────────────────────────────────────────────────────────

	// Navigation toggle (tiny, no jQuery dependency).
	wp_enqueue_script(
		'smartshop-navigation',
		SMARTSHOP_ASSETS . '/js/navigation.js',
		[],
		SMARTSHOP_VERSION,
		true // load in footer
	);

	// Localised data for JS.
	wp_localize_script(
		'smartshop-navigation',
		'smartshopData',
		[
			'ajaxUrl' => esc_url( admin_url( 'admin-ajax.php' ) ),
			'nonce'   => wp_create_nonce( 'smartshop-nonce' ),
			'i18n'    => [
				'menuOpen'  => esc_html__( 'Open menu', 'smartshop' ),
				'menuClose' => esc_html__( 'Close menu', 'smartshop' ),
			],
		]
	);

	// Comments reply script (only on singular with comments open).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'smartshop_enqueue_assets' );

/**
 * Dequeue WooCommerce's default block styles when we handle them ourselves.
 */
function smartshop_dequeue_block_styles(): void {
	if ( ! smartshop_is_woocommerce_active() ) {
		return;
	}
	// Uncomment selectively once you have confirmed replacements are ready.
	// wp_dequeue_style( 'wc-blocks-style' );
}
add_action( 'wp_enqueue_scripts', 'smartshop_dequeue_block_styles', 20 );

/**
 * Add preconnect hints for performance.
 */
function smartshop_resource_hints( array $urls, string $relation_type ): array {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = [ 'href' => 'https://fonts.googleapis.com' ];
		$urls[] = [ 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' ];
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'smartshop_resource_hints', 10, 2 );
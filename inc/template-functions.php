<?php
/**
 * SmartShop Template Functions
 *
 * Reusable helpers called by template files and hooks.
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;

// ─── Layout helpers ───────────────────────────────────────────────────────────

/**
 * Return the correct container class based on context.
 *
 * @return string CSS class string.
 */
function smartshop_container_class(): string {
	$class = 'container';

	if ( is_page() || is_singular( 'post' ) ) {
		$class .= ' container--narrow';
	}

	if ( smartshop_is_woocommerce_active() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
		$class .= ' container--shop';
	}

	return apply_filters( 'smartshop_container_class', $class );
}

/**
 * Output the opening container div.
 */
function smartshop_container_open(): void {
	echo '<div class="' . esc_attr( smartshop_container_class() ) . '">' . "\n";
}

/**
 * Output the closing container div.
 */
function smartshop_container_close(): void {
	echo '</div><!-- .container -->' . "\n";
}

// ─── Branding helpers ─────────────────────────────────────────────────────────

/**
 * Output the site logo or site name as a fallback.
 */
function smartshop_site_logo(): void {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}

	$tag  = is_front_page() && is_home() ? 'h1' : 'p';
	printf(
		'<%1$s class="site-title"><a href="%2$s" rel="home">%3$s</a></%1$s>',
		esc_attr( $tag ),
		esc_url( home_url( '/' ) ),
		esc_html( get_bloginfo( 'name', 'display' ) )
	);

	$description = get_bloginfo( 'description', 'display' );
	if ( $description ) {
		printf( '<p class="site-description screen-reader-text">%s</p>', esc_html( $description ) );
	}
}

// ─── SVG icon helper ──────────────────────────────────────────────────────────

/**
 * Output an inline SVG icon from /assets/icons/.
 *
 * @param string $name   Icon filename without extension.
 * @param string $class  Optional extra CSS classes.
 */
function smartshop_icon( string $name, string $class = '' ): void {
	$path = SMARTSHOP_DIR . '/assets/icons/' . sanitize_file_name( $name ) . '.svg';

	if ( ! file_exists( $path ) ) {
		return;
	}

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG from theme files only.
	echo '<span class="icon icon--' . esc_attr( $name ) . ( $class ? ' ' . esc_attr( $class ) : '' ) . '" aria-hidden="true">'
		. file_get_contents( $path ) // nosec — local theme file.
		. '</span>';
}

// ─── WooCommerce helpers ──────────────────────────────────────────────────────

/**
 * Return the cart item count for display.
 *
 * @return int
 */
function smartshop_cart_count(): int {
	if ( ! smartshop_is_woocommerce_active() ) {
		return 0;
	}
	return (int) WC()->cart?->get_cart_contents_count() ?? 0;
}

/**
 * Output a skip-to-content link (accessibility).
 */
function smartshop_skip_link(): void {
	echo '<a class="skip-link screen-reader-text" href="#main">'
		. esc_html__( 'Skip to content', 'smartshop' )
		. '</a>';
}
add_action( 'wp_body_open', 'smartshop_skip_link' );

// ─── Pagination ───────────────────────────────────────────────────────────────

/**
 * Output posts or products pagination.
 */
function smartshop_pagination(): void {
	$args = [
		'prev_text' => smartshop_is_woocommerce_active()
			? esc_html__( '&larr; Previous', 'smartshop' )
			: esc_html__( '&larr; Older', 'smartshop' ),
		'next_text' => smartshop_is_woocommerce_active()
			? esc_html__( 'Next &rarr;', 'smartshop' )
			: esc_html__( 'Newer &rarr;', 'smartshop' ),
		'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page', 'smartshop' ) . ' </span>',
	];

	the_posts_pagination( $args );
}
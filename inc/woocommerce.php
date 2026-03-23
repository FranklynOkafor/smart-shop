<?php
/**
 * SmartShop WooCommerce Integration
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Check whether WooCommerce is active.
 */
function smartshop_is_woocommerce_active(): bool {
	return class_exists( 'WooCommerce' );
}

if ( ! smartshop_is_woocommerce_active() ) {
	return;
}

// ─── Layout ───────────────────────────────────────────────────────────────────

/**
 * Remove default WooCommerce breadcrumb (we add it via template-hooks).
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Remove WooCommerce sidebar so we can handle it in our templates.
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Disable WooCommerce's default stylesheet (we write our own).
 *
 * Set to false once woocommerce.css is production-ready.
 */
add_filter( 'woocommerce_enqueue_styles', static function ( array $styles ): array {
	// Uncomment to remove individual WC stylesheets:
	// unset( $styles['woocommerce-general'] );
	// unset( $styles['woocommerce-layout'] );
	// unset( $styles['woocommerce-smallscreen'] );
	return $styles;
} );

// ─── Product archive ──────────────────────────────────────────────────────────

/**
 * Adjust default products per page.
 */
add_filter( 'loop_shop_per_page', static fn() => apply_filters( 'smartshop_products_per_page', 16 ) );

/**
 * Adjust default columns in product grid.
 */
add_filter( 'loop_shop_columns', static fn() => apply_filters( 'smartshop_loop_columns', 4 ) );

// ─── Product card ─────────────────────────────────────────────────────────────

/**
 * Remove default product loop title so our template-part controls markup.
 */
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

/**
 * Remove default WooCommerce wrappers — our template-parts handle structure.
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item',  'woocommerce_template_loop_product_link_close', 5 );

// ─── Single product ───────────────────────────────────────────────────────────

/**
 * Move product meta below the add-to-cart button.
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 55 );

// ─── Cart / Checkout ──────────────────────────────────────────────────────────

/**
 * Placeholder — add targeted cart/checkout tweaks here as needed.
 * Avoid wholesale modifications that break WC forward compatibility.
 */

// ─── Breadcrumbs ──────────────────────────────────────────────────────────────

/**
 * Customise WooCommerce breadcrumb defaults.
 */
add_filter(
	'woocommerce_breadcrumb_defaults',
	static function ( array $defaults ): array {
		$defaults['delimiter']   = '<span class="breadcrumb__sep" aria-hidden="true">/</span>';
		$defaults['wrap_before'] = '<nav class="breadcrumb woo-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'smartshop' ) . '">';
		$defaults['wrap_after']  = '</nav>';
		$defaults['before']      = '<span class="breadcrumb__item">';
		$defaults['after']       = '</span>';
		return $defaults;
	}
);



/**
 * Use SmartShop product card for related products and upsells.
 */
add_action( 'woocommerce_before_shop_loop_item', function() {
	global $product;
	if ( $product ) {
			set_query_var( 'smartshop_product', $product );
	}
}, 1 );



// Add trust badges to the cart

add_action( 'woocommerce_review_order_after_submit', function() {
  ?>
  <div class="smartshop-checkout-trust">
    <span class="smartshop-checkout-trust__item">
      <?php smartshop_icon( 'shield' ); ?>
      <?php esc_html_e( 'SSL Secure Payment', 'smartshop' ); ?>
    </span>
    <span class="smartshop-checkout-trust__item">
      <?php smartshop_icon( 'lock' ); ?>
      <?php esc_html_e( 'Your data is protected', 'smartshop' ); ?>
    </span>
    <span class="smartshop-checkout-trust__item">
      <?php smartshop_icon( 'return' ); ?>
      <?php esc_html_e( '30-day returns', 'smartshop' ); ?>
    </span>
  </div>
  <?php
} );










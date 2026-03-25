<?php
/**
 * Template part: Header Utilities (search, cart, account)
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="header-utils" role="region" aria-label="<?php esc_attr_e( 'Utilities', 'smartshop' ); ?>">

	<?php /* Search toggle */ ?>
	<button
		class="header-utils__btn header-utils__btn--search js-search-toggle"
		aria-label="<?php esc_attr_e( 'Open search', 'smartshop' ); ?>"
		aria-expanded="false"
		aria-controls="header-search"
		type="button"
	>
		<?php smartshop_icon( 'search' ); ?>
	</button>

	<?php if ( smartshop_is_woocommerce_active() ) : ?>

		<?php /* My Account */ ?>
		<a
			href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>"
			class="header-utils__btn header-utils__btn--account"
			aria-label="<?php esc_attr_e( 'My account', 'smartshop' ); ?>"
		>
			<?php smartshop_icon( 'user' ); ?>
		</a>

		<?php /* Cart + Mini Cart Dropdown */ ?>
		<div class="mini-cart-wrap" data-mini-cart>

			<a
				href="<?php echo esc_url( wc_get_cart_url() ); ?>"
				class="header-utils__btn header-utils__btn--cart js-cart-trigger"
				aria-label="<?php esc_attr_e( 'Shopping cart', 'smartshop' ); ?>"
				aria-haspopup="true"
				aria-expanded="false"
			>
				<?php smartshop_icon( 'cart' ); ?>
				<span
					class="cart-count<?php echo smartshop_cart_count() === 0 ? ' cart-count--empty' : ''; ?>"
					aria-live="polite"
					aria-atomic="true"
				>
					<?php echo esc_html( smartshop_cart_count() ); ?>
				</span>
			</a>

			<!-- Mini cart dropdown -->
			<div
				class="mini-cart"
				role="dialog"
				aria-label="<?php esc_attr_e( 'Cart summary', 'smartshop' ); ?>"
				aria-hidden="true"
				data-mini-cart-panel
			>
				<div class="mini-cart__inner">

					<div class="mini-cart__header">
						<span class="mini-cart__title"><?php esc_html_e( 'Your Cart', 'smartshop' ); ?></span>
						<span class="mini-cart__count">
							<?php
							printf(
								/* translators: %d: item count */
								esc_html( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'smartshop' ) ),
								WC()->cart->get_cart_contents_count()
							);
							?>
						</span>
					</div>

					<div class="mini-cart__body woocommerce">
						<?php woocommerce_mini_cart(); ?>
					</div>

				</div>
			</div><!-- .mini-cart -->

		</div><!-- .mini-cart-wrap -->

	<?php endif; ?>

	<?php /* Mobile menu toggle */ ?>
	<button
		class="header-utils__btn header-utils__btn--menu js-nav-toggle"
		aria-label="<?php esc_attr_e( 'Open menu', 'smartshop' ); ?>"
		aria-expanded="false"
		aria-controls="mobile-nav"
		type="button"
	>
		<?php smartshop_icon( 'menu' ); ?>
	</button>

</div><!-- .header-utils -->
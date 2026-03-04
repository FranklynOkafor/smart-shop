<?php
/**
 * Template part: Mobile Navigation
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;
?>
<div id="mobile-nav" class="mobile-nav" aria-hidden="true" role="dialog" aria-label="<?php esc_attr_e( 'Mobile navigation', 'smartshop' ); ?>">
	<div class="mobile-nav__overlay js-nav-close" tabindex="-1"></div>
	<div class="mobile-nav__drawer">

		<button
			class="mobile-nav__close js-nav-close"
			type="button"
			aria-label="<?php esc_attr_e( 'Close menu', 'smartshop' ); ?>"
		>
			<?php smartshop_icon( 'x' ); ?>
		</button>

		<?php
		wp_nav_menu(
			[
				'theme_location' => 'mobile',
				'menu_class'     => 'mobile-nav__menu',
				'container'      => false,
				'depth'          => 2,
				'fallback_cb'    => static function () {
					// Fall back to primary menu if no mobile menu is assigned.
					wp_nav_menu( [
						'theme_location' => 'primary',
						'menu_class'     => 'mobile-nav__menu',
						'container'      => false,
						'depth'          => 2,
					] );
				},
			]
		);
		?>

	</div><!-- .mobile-nav__drawer -->
</div><!-- #mobile-nav -->
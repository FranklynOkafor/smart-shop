<?php
/**
 * Template part: Footer Bottom Bar
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="footer-bottom">
	<div class="container footer-bottom__inner">

		<p class="footer-bottom__copyright">
			<?php
			printf(
				/* translators: 1: copyright year, 2: site name */
				esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'smartshop' ),
				esc_html( date_i18n( 'Y' ) ),
				esc_html( get_bloginfo( 'name', 'display' ) )
			);
			?>
		</p>

		<?php if ( has_nav_menu( 'secondary' ) ) : ?>
			<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'smartshop' ); ?>">
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'secondary',
						'menu_class'     => 'footer-nav__menu',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					]
				);
				?>
			</nav>
		<?php endif; ?>

	</div><!-- .footer-bottom__inner -->
</div><!-- .footer-bottom -->
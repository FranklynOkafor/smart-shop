<?php
/**
 * Template part: Primary Navigation
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;

if ( ! has_nav_menu( 'primary' ) ) {
	return;
}
?>
<nav id="site-navigation" class="primary-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'smartshop' ); ?>">
	<?php
	wp_nav_menu(
		[
			'theme_location'  => 'primary',
			'menu_id'         => 'primary-menu',
			'menu_class'      => 'primary-nav__menu',
			'container'       => false,
			'depth'           => 3,
			'fallback_cb'     => false,
			'items_wrap'      => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
		]
	);
	?>
</nav><!-- #site-navigation -->
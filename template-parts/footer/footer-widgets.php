<?php
/**
 * Template part: Footer Widgets
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;

$has_widgets =
	is_active_sidebar( 'footer-1' ) ||
	is_active_sidebar( 'footer-2' ) ||
	is_active_sidebar( 'footer-3' );

if ( ! $has_widgets ) {
	return;
}
?>
<div class="footer-widgets">
	<div class="container">
		<div class="footer-widgets__grid">

			<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
				<div class="footer-widgets__col">
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
				<div class="footer-widgets__col">
					<?php dynamic_sidebar( 'footer-2' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
				<div class="footer-widgets__col">
					<?php dynamic_sidebar( 'footer-3' ); ?>
				</div>
			<?php endif; ?>

		</div><!-- .footer-widgets__grid -->
	</div><!-- .container -->
</div><!-- .footer-widgets -->
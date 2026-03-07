<?php
/**
 * Template Part: Trust Badges
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;

$badges = [
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>',
		'title' => __( 'Secure Checkout', 'smartshop' ),
		'desc'  => __( 'Your payment info is always encrypted and protected.', 'smartshop' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.84a16 16 0 0 0 5.61 5.61l1.74-1.74a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
		'title' => __( '24/7 Customer Support', 'smartshop' ),
		'desc'  => __( 'Our team is always here to help, any time of day.', 'smartshop' ),
	],
	[
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/></svg>',
		'title' => __( 'Easy Returns', 'smartshop' ),
		'desc'  => __( 'Not happy? Return any item within 30 days, no questions asked.', 'smartshop' ),
	],
];

// Allow child themes or plugins to modify the badges
$badges = apply_filters( 'smartshop_trust_badges', $badges );
?>

<ul class="trust-badges">
	<?php foreach ( $badges as $badge ) : ?>
	<li class="trust-badges__item">
		<div class="trust-badges__icon" aria-hidden="true">
			<?php echo $badge['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — hardcoded SVG ?>
		</div>
		<div class="trust-badges__body">
			<h3 class="trust-badges__title"><?php echo esc_html( $badge['title'] ); ?></h3>
			<p class="trust-badges__desc"><?php echo esc_html( $badge['desc'] ); ?></p>
		</div>
	</li>
	<?php endforeach; ?>
</ul><!-- .trust-badges -->
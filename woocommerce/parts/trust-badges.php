<?php
/**
 * Template Part: Trust Badges
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;

$badges = apply_filters( 'smartshop_trust_badges', array(
	array(
		'icon'  => 'truck',
		'title' => __( 'Free Shipping', 'smartshop' ),
		'desc'  => __( 'On orders over $75', 'smartshop' ),
	),
	array(
		'icon'  => 'return',
		'title' => __( '30-Day Returns', 'smartshop' ),
		'desc'  => __( 'Hassle-free guarantee', 'smartshop' ),
	),
	array(
		'icon'  => 'shield',
		'title' => __( 'Secure Payment', 'smartshop' ),
		'desc'  => __( '256-bit SSL encryption', 'smartshop' ),
	),
	array(
		'icon'  => 'star',
		'title' => __( 'Top Rated', 'smartshop' ),
		'desc'  => __( '4.9/5 from 2,400+ reviews', 'smartshop' ),
	),
) );
?>

<ul class="smartshop-trust__list">
	<?php foreach ( $badges as $badge ) : ?>
	<li class="smartshop-trust__item">
		<div class="smartshop-trust__icon" aria-hidden="true">
			<?php smartshop_icon( $badge['icon'] ); ?>
		</div>
		<div class="smartshop-trust__text">
			<strong class="smartshop-trust__title"><?php echo esc_html( $badge['title'] ); ?></strong>
			<span class="smartshop-trust__desc"><?php echo esc_html( $badge['desc'] ); ?></span>
		</div>
	</li>
	<?php endforeach; ?>
</ul>

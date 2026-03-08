<?php
/**
 * Template Part: Promo Split Banner
 *
 * ACF fields required (attached to front page):
 * promo_image, promo_eyebrow, promo_heading, promo_text,
 * promo_primary_label, promo_primary_url,
 * promo_outline_label, promo_outline_url
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;

// Bail if ACF is not active
if ( ! function_exists( 'get_field' ) ) {
	return;
}

$image         = get_field( 'promo_image' );
$eyebrow       = get_field( 'promo_eyebrow' );
$heading       = get_field( 'promo_heading' );
$text          = get_field( 'promo_text' );
$primary_label = get_field( 'promo_primary_label' );
$primary_url   = get_field( 'promo_primary_url' );
$outline_label = get_field( 'promo_outline_label' );
$outline_url   = get_field( 'promo_outline_url' );



// Bail if no heading and no image — nothing meaningful to show
if ( empty( $heading ) && empty( $image ) ) {
	return;
}

// Image attributes
$image_url = '';
$image_alt = '';
if ( is_array( $image ) ) {
	$image_url = $image['url'];
	$image_alt = $image['alt'] ?: $heading;
} elseif ( $image ) {
	$image_url = wp_get_attachment_url( $image );
	$image_alt = get_post_meta( $image, '_wp_attachment_image_alt', true ) ?: $heading;
}
?>

<section class="promo-split" aria-label="<?php esc_attr_e( 'Promotional banner', 'smartshop' ); ?>">
	<div class="promo-split__inner">

		<!-- ── LEFT: Image ── -->
		<?php if ( $image_url ) : ?>
		<div class="promo-split__media">
			<img
				src="<?php echo esc_url( $image_url ); ?>"
				alt="<?php echo esc_attr( $image_alt ); ?>"
				class="promo-split__img"
				loading="lazy"
				decoding="async"
			/>
		</div>
		<?php endif; ?>

		<!-- ── RIGHT: Content ── -->
		<div class="promo-split__content">

			<?php if ( $eyebrow ) : ?>
			<span class="smartshop-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
			<h2 class="promo-split__heading"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( $text ) : ?>
			<p class="promo-split__text"><?php echo esc_html( $text ); ?></p>
			<?php endif; ?>

			<?php if ( $primary_label || $outline_label ) : ?>
			<div class="promo-split__actions">

				<?php if ( $primary_label && $primary_url ) : ?>
				<a href="<?php echo esc_url( $primary_url ); ?>" class="btn btn--primary">
					<?php echo esc_html( $primary_label ); ?>
				</a>
				<?php endif; ?>

				<?php if ( $outline_label && $outline_url ) : ?>
				<a href="<?php echo esc_url( $outline_url ); ?>" class="btn btn--outline">
					<?php echo esc_html( $outline_label ); ?>
				</a>
				<?php endif; ?>

			</div>
			<?php endif; ?>

		</div><!-- .promo-split__content -->

	</div><!-- .promo-split__inner -->
</section><!-- .promo-split -->
<?php
/**
 * Template Part: Product Card
 *
 * Used by homepage loops (new arrivals, bestsellers).
 * Requires $product (WC_Product) to be set in global scope before calling.
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product instanceof WC_Product ) {
	return;
}

$permalink      = $product->get_permalink();
$image_id       = $product->get_image_id();
$is_on_sale     = $product->is_on_sale();
$is_new         = ( time() - ( 30 * DAY_IN_SECONDS ) ) < strtotime( $product->get_date_created() );
?>

<article class="smartshop-product-card" aria-label="<?php echo esc_attr( $product->get_name() ); ?>">

	<!-- Image -->
	<div class="smartshop-product-card__media">
		<a href="<?php echo esc_url( $permalink ); ?>" class="smartshop-product-card__image-link" tabindex="-1" aria-hidden="true">
			<?php if ( $image_id ) : ?>
				<?php echo wp_get_attachment_image( $image_id, 'woocommerce_single', false, array(
					'class'   => 'smartshop-product-card__img',
					'loading' => 'lazy',
					'alt'     => esc_attr( $product->get_name() ),
				) ); ?>
			<?php else : ?>
				<img src="<?php echo esc_url( wc_placeholder_img_src( 'woocommerce_thumbnail' ) ); ?>" alt="<?php esc_attr_e( 'Placeholder', 'smartshop' ); ?>" class="smartshop-product-card__img">
			<?php endif; ?>
		</a>

		<!-- Badges -->
		<div class="smartshop-product-card__badges">
			<?php if ( $is_on_sale ) : ?>
				<span class="smartshop-badge smartshop-badge--sale"><?php esc_html_e( 'Sale', 'smartshop' ); ?></span>
			<?php endif; ?>
			<?php if ( $is_new ) : ?>
				<span class="smartshop-badge smartshop-badge--new"><?php esc_html_e( 'New', 'smartshop' ); ?></span>
			<?php endif; ?>
			<?php if ( ! $product->is_in_stock() ) : ?>
				<span class="smartshop-badge smartshop-badge--soldout"><?php esc_html_e( 'Sold Out', 'smartshop' ); ?></span>
			<?php endif; ?>
		</div>
	</div>

	<!-- Body -->
	<div class="smartshop-product-card__body">
		<h3 class="smartshop-product-card__title">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
		</h3>

		<?php if ( wc_review_ratings_enabled() && $product->get_average_rating() ) : ?>
		<div class="smartshop-product-card__rating">
			<?php echo wc_get_rating_html( $product->get_average_rating(), $product->get_rating_count() ); // phpcs:ignore ?>
		</div>
		<?php endif; ?>

		<div class="smartshop-product-card__price">
			<?php echo $product->get_price_html(); // phpcs:ignore ?>
		</div>
	</div>

	<!-- Footer CTA -->
	<div class="smartshop-product-card__footer">
		<?php if ( $product->is_in_stock() ) : ?>
			<?php woocommerce_template_loop_add_to_cart( array( 'class' => 'smartshop-btn smartshop-btn--primary smartshop-btn--full' ) ); ?>
		<?php else : ?>
			<a href="<?php echo esc_url( $permalink ); ?>" class="smartshop-btn smartshop-btn--outline smartshop-btn--full">
				<?php esc_html_e( 'View Product', 'smartshop' ); ?>
			</a>
		<?php endif; ?>
	</div>

</article>

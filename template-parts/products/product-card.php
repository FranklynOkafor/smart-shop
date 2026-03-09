<?php
/**
 * Template Part: Product Card
 *
 * Used in New Arrivals, Best Sellers, and any product grid loop.
 * Expects $product to be set as a WC_Product object in $GLOBALS.
 *
 * @package SmartShop
 */


defined( 'ABSPATH' ) || exit;

$product = get_query_var( 'smartshop_product' );

if ( ! $product instanceof WC_Product ) {
    return;
}
	
$product_id    = $product->get_id();
$product_link  = get_permalink( $product_id );
$product_name  = $product->get_name();
$is_on_sale    = $product->is_on_sale();
$is_instock    = $product->is_in_stock();
$rating_count  = $product->get_rating_count();
$average       = $product->get_average_rating();



// Image
$image_id      = $product->get_image_id();
$image         = $image_id
	? wp_get_attachment_image( $image_id, 'smartshop-product-card', false, [
		'class'   => 'product-card__img',
		'loading' => 'lazy',
		'alt'     => esc_attr( $product_name ),
	] )
	: wc_placeholder_img( 'smartshop-product-card' );

// Price
$price_html = $product->get_price_html();

// Add to cart
$add_to_cart_url   = $product->add_to_cart_url();
$add_to_cart_text  = $product->add_to_cart_text();
$purchasable       = $product->is_purchasable() && $is_instock;
?>

<article
	class="product-card<?php echo $is_on_sale ? ' product-card--sale' : ''; ?><?php echo ! $is_instock ? ' product-card--outofstock' : ''; ?>"
	aria-label="<?php echo esc_attr( $product_name ); ?>"
>

	<!-- ── IMAGE ── -->
	<div class="product-card__media">

		<a href="<?php echo esc_url( $product_link ); ?>" class="product-card__image-link" tabindex="-1" aria-hidden="true">
			<?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</a>

		<!-- Badges -->
		<div class="product-card__badges" aria-label="<?php esc_attr_e( 'Product badges', 'smartshop' ); ?>">
			<?php if ( $is_on_sale ) : ?>
				<span class="product-card__badge product-card__badge--sale">
					<?php esc_html_e( 'Sale', 'smartshop' ); ?>
				</span>
			<?php endif; ?>

			<?php if ( ! $is_instock ) : ?>
				<span class="product-card__badge product-card__badge--outofstock">
					<?php esc_html_e( 'Out of Stock', 'smartshop' ); ?>
				</span>
			<?php endif; ?>
		</div>

		<!-- Wishlist button -->
		<button
			class="product-card__wishlist js-wishlist-toggle"
			type="button"
			aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to wishlist', 'smartshop' ), $product_name ) ); ?>"
			data-product-id="<?php echo esc_attr( $product_id ); ?>"
		>
			<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
				<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
			</svg>
		</button>

	</div><!-- .product-card__media -->

	<!-- ── BODY ── -->
	<div class="product-card__body">

		<!-- Product name -->
		<h3 class="product-card__title">
			<a href="<?php echo esc_url( $product_link ); ?>" class="product-card__title-link">
				<?php echo esc_html( $product_name ); ?>
			</a>
		</h3>

		<!-- Star ratings -->
		<?php if ( $rating_count > 0 ) : ?>
		<div class="product-card__rating" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %s out of 5', 'smartshop' ), $average ) ); ?>">
			<?php echo wc_get_rating_html( $average, $rating_count ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span class="product-card__rating-count">(<?php echo esc_html( $rating_count ); ?>)</span>
		</div>
		<?php endif; ?>

		<!-- Price -->
		<?php if ( $price_html ) : ?>
		<div class="product-card__price">
			<?php echo $price_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php endif; ?>

		<!-- Add to cart -->
		<?php if ( $purchasable ) : ?>
		<a
			href="<?php echo esc_url( $add_to_cart_url ); ?>"
			class="product-card__atc btn btn--primary btn--sm ajax_add_to_cart"
			data-product_id="<?php echo esc_attr( $product_id ); ?>"
			data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
			data-quantity="1"
			aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'smartshop' ), $product_name ) ); ?>"
			rel="nofollow"
		>
			<?php echo esc_html( $add_to_cart_text ); ?>
		</a>
		<?php else : ?>
		<a
			href="<?php echo esc_url( $product_link ); ?>"
			class="product-card__atc btn btn--outline btn--sm"
		>
			<?php esc_html_e( 'View Product', 'smartshop' ); ?>
		</a>
		<?php endif; ?>

	</div><!-- .product-card__body -->

</article><!-- .product-card -->
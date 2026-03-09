<?php
/**
 * Single Product Template
 *
 * WordPress template hierarchy: single-product.php
 * All WooCommerce hooks fire in their standard order —
 * we only reorganise layout wrappers, never remove core functionality.
 *
 * @package SmartShop
 * @see     https://woocommerce.com/document/template-structure/
 */

defined( 'ABSPATH' ) || exit;

get_header();

do_action( 'smartshop_before_single_product' );
?>

<main id="smartshop-main" class="smartshop-main smartshop-single-product" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php
    global $product;
    $product = wc_get_product( get_the_ID() );
		/**
		 * Hook: woocommerce_before_single_product
		 * @hooked woocommerce_output_all_notices - 10
		 */
		do_action( 'woocommerce_before_single_product' );
		?>

		<article id="product-<?php the_ID(); ?>" <?php wc_product_class( 'smartshop-product', $product ); ?>>

			<!-- ── BREADCRUMB ── -->
			<div class="smartshop-breadcrumb-bar">
				<div class="container">
					<?php woocommerce_breadcrumb(); ?>
				</div>
			</div>

			<!-- ═══════════════════════════════════
			     PRODUCT HERO: GALLERY + SUMMARY
			═══════════════════════════════════ -->
			<div class="smartshop-product-hero">
				<div class="container">
					<div class="smartshop-product-layout">

						<!-- Gallery column (55%) -->
						<div class="smartshop-product-gallery-col">
							<?php
							/**
							 * Hook: woocommerce_before_single_product_summary
							 *
							 * @hooked woocommerce_show_product_sale_flash   -  10
							 * @hooked woocommerce_show_product_images       -  20
							 */
							do_action( 'woocommerce_before_single_product_summary' );
							?>
						</div>

						<!-- Summary column (45%) -->
						<div class="smartshop-product-summary-col">
							<div class="smartshop-product-summary">
								<?php
								/**
								 * Hook: woocommerce_single_product_summary
								 *
								 * @hooked woocommerce_template_single_title       -  5
								 * @hooked woocommerce_template_single_rating      - 10
								 * @hooked woocommerce_template_single_price       - 10
								 * @hooked woocommerce_template_single_excerpt     - 20
								 * @hooked woocommerce_template_single_add_to_cart - 30
								 * @hooked woocommerce_template_single_meta        - 40
								 * @hooked woocommerce_template_single_sharing     - 50
								 */
								do_action( 'woocommerce_single_product_summary' );

								// Trust signals beneath the add-to-cart
								do_action( 'smartshop_after_add_to_cart' );
								?>

								<!-- Inline trust badges -->
								<div class="smartshop-product-trust">
									<span class="smartshop-product-trust__item">
										<?php smartshop_icon( 'shield' ); ?>
										<?php esc_html_e( 'Secure checkout', 'smartshop' ); ?>
									</span>
									<span class="smartshop-product-trust__item">
										<?php smartshop_icon( 'truck' ); ?>
										<?php esc_html_e( 'Free shipping over $75', 'smartshop' ); ?>
									</span>
									<span class="smartshop-product-trust__item">
										<?php smartshop_icon( 'return' ); ?>
										<?php esc_html_e( '30-day returns', 'smartshop' ); ?>
									</span>
								</div>

							</div><!-- .smartshop-product-summary -->
						</div><!-- .smartshop-product-summary-col -->

					</div><!-- .smartshop-product-layout -->
				</div><!-- .container -->
			</div><!-- .smartshop-product-hero -->


			<!-- ═══════════════════════════════════
			     PRODUCT TABS (Description, Reviews, etc.)
			═══════════════════════════════════ -->
			<div class="smartshop-product-tabs-section">
				<div class="container">
					<?php
					/**
					 * Hook: woocommerce_after_single_product_summary
					 *
					 * @hooked woocommerce_output_product_data_tabs - 10
					 * @hooked woocommerce_upsell_display           - 15
					 * @hooked woocommerce_output_related_products  - 20
					 */

					// Remove upsells and related from default hook position —
					// we want them below the tabs in controlled sections.
					remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
					remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

					do_action( 'woocommerce_after_single_product_summary' );
					?>
				</div>
			</div>


			<!-- ═══════════════════════════════════
			     UPSELLS
			═══════════════════════════════════ -->
			<?php
			global $product;
			$upsells = $product->get_upsell_ids();
			if ( $upsells ) :
			?>
			<section class="smartshop-upsells" aria-label="<?php esc_attr_e( 'You may also like', 'smartshop' ); ?>">
				<div class="container">
					<header class="smartshop-section-header">
						<h2 class="smartshop-section-header__title"><?php esc_html_e( 'You May Also Like', 'smartshop' ); ?></h2>
					</header>
					<?php woocommerce_upsell_display( 4, 4 ); ?>
				</div>
			</section>
			<?php endif; ?>


			<!-- ═══════════════════════════════════
			     RELATED PRODUCTS
			═══════════════════════════════════ -->
			<section class="smartshop-related" aria-label="<?php esc_attr_e( 'Related products', 'smartshop' ); ?>">
				<div class="container">
					<header class="smartshop-section-header">
						<h2 class="smartshop-section-header__title"><?php esc_html_e( 'Related Products', 'smartshop' ); ?></h2>
					</header>
					<?php
					woocommerce_output_related_products( array(
						'posts_per_page' => 4,
						'columns'        => 4,
						'orderby'        => 'rand',
					) );
					?>
				</div>
			</section>

		</article><!-- #product-<?php the_ID(); ?> -->

	<?php endwhile; ?>

</main><!-- #smartshop-main -->

<?php
do_action( 'smartshop_after_single_product' );
get_footer();

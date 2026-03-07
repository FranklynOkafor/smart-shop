<?php

/**
 * Front Page — Homepage Template
 *
 * Used when Settings → Reading → "A static page" is selected.
 * This is your storefront: hero, categories, products, testimonials.
 *
 * @package SmartShop
 */

get_header();
?>

<main id="smartshop-main" class="smartshop-main smartshop-home" role="main">

	<?php do_action('smartshop_before_home'); ?>

	<!-- ═══════════════════════════════════
	     HERO BANNER
	═══════════════════════════════════ -->
	<?php get_template_part('woocommerce/parts/hero-banner'); ?>

	<?php do_action('smartshop_after_hero'); ?>

	<!-- ═══════════════════════════════════
	     TRUST BADGES
	═══════════════════════════════════ -->
	<section class="smartshop-trust" aria-label="<?php esc_attr_e('Why shop with us', 'smartshop'); ?>">
		<div class="container">
			<?php get_template_part('woocommerce/parts/trust-badges'); ?>
		</div>
	</section>

	<?php do_action('smartshop_after_trust_badges'); ?>

	<!-- ═══════════════════════════════════
	     SHOP BY CATEGORY
	═══════════════════════════════════ -->
	<?php if (class_exists('WooCommerce')) : ?>
		<section class="smartshop-categories" aria-label="<?php esc_attr_e('Product categories', 'smartshop'); ?>">
			<div class="container">

				<header class="smartshop-section-header">
					<span class="smartshop-eyebrow"><?php esc_html_e('Browse by Category', 'smartshop'); ?></span>
					<h2 class="smartshop-section-header__title"><?php esc_html_e('Shop What You Love', 'smartshop'); ?></h2>
				</header>

				<?php
				$categories = woocommerce_get_product_subcategories(0);
				if ($categories) :
				?>
					<ul class="smartshop-category-grid">
						<?php foreach ($categories as $cat) : ?>
							<li class="smartshop-category-grid__item">
								<a href="<?php echo esc_url(get_term_link($cat)); ?>" class="smartshop-category-card">
									<?php
									$thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
									if ($thumbnail_id) :
									?>
										<div class="smartshop-category-card__image">
											<?php echo wp_get_attachment_image($thumbnail_id, 'medium', false, array(
												'class'   => 'smartshop-category-card__img',
												'loading' => 'lazy',
												'alt'     => esc_attr($cat->name),
											)); ?>
										</div>
									<?php endif; ?>
									<div class="smartshop-category-card__body">
										<h3 class="smartshop-category-card__name"><?php echo esc_html($cat->name); ?></h3>
										<span class="smartshop-category-card__count">
											<?php
											/* translators: %d: product count */
											printf(esc_html(_n('%d product', '%d products', $cat->count, 'smartshop')), esc_html($cat->count));
											?>
										</span>
									</div>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

			</div>
		</section>
	<?php endif; ?>

	<?php do_action('smartshop_after_categories'); ?>

	<!-- ═══════════════════════════════════
	     NEW ARRIVALS
	═══════════════════════════════════ -->
	<?php if (class_exists('WooCommerce')) : ?>
		<section class="smartshop-new-arrivals" aria-label="<?php esc_attr_e('New arrivals', 'smartshop'); ?>">
			<div class="container">

				<header class="smartshop-section-header smartshop-section-header--split">
					<div>
						<span class="smartshop-eyebrow"><?php esc_html_e('Just Landed', 'smartshop'); ?></span>
						<h2 class="smartshop-section-header__title"><?php esc_html_e('New Arrivals', 'smartshop'); ?></h2>
					</div>
					<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="smartshop-link-arrow">
						<?php esc_html_e('View All', 'smartshop'); ?> &rarr;
					</a>
				</header>

				<?php
				$new_products = wc_get_products(array(
					'limit'   => 4,
					'orderby' => 'date',
					'order'   => 'DESC',
					'status'  => 'publish',
				));

				if ($new_products) :
				?>
					<ul class="smartshop-product-grid smartshop-product-grid--4col">
						<?php foreach ($new_products as $product) :
							$GLOBALS['product'] = $product;
							wc_setup_product_data($product);
						?>
							<li class="smartshop-product-grid__item">
								<?php get_template_part('woocommerce/parts/product-card'); ?>
							</li>
						<?php endforeach;
						wp_reset_postdata(); ?>
					</ul>
				<?php endif; ?>

			</div>
		</section>
	<?php endif; ?>

	<?php do_action('smartshop_after_new_arrivals'); ?>

	<!-- ═══════════════════════════════════
	     BEST SELLERS
	═══════════════════════════════════ -->
	<?php if (class_exists('WooCommerce')) : ?>
		<section class="smartshop-bestsellers" aria-label="<?php esc_attr_e('Best sellers', 'smartshop'); ?>">
			<div class="container">

				<header class="smartshop-section-header smartshop-section-header--split">
					<div>
						<span class="smartshop-eyebrow"><?php esc_html_e('Customer Favourites', 'smartshop'); ?></span>
						<h2 class="smartshop-section-header__title"><?php esc_html_e('Best Sellers', 'smartshop'); ?></h2>
					</div>
					<a href="<?php echo esc_url(add_query_arg('orderby', 'popularity', wc_get_page_permalink('shop'))); ?>" class="smartshop-link-arrow">
						<?php esc_html_e('View All', 'smartshop'); ?> &rarr;
					</a>
				</header>

				<?php
				$bestsellers = wc_get_products(array(
					'limit'   => 4,
					'orderby' => 'popularity',
					'order'   => 'DESC',
					'status'  => 'publish',
				));

				if ($bestsellers) :
				?>
					<ul class="smartshop-product-grid smartshop-product-grid--4col">
						<?php foreach ($bestsellers as $product) :
							$GLOBALS['product'] = $product;
						?>
							<li class="smartshop-product-grid__item">
								<?php get_template_part('woocommerce/product-card'); ?>
							</li>
						<?php endforeach;
						wp_reset_postdata(); ?>
					</ul>
				<?php endif; ?>

			</div>
		</section>
	<?php endif;
	wp_reset_postdata(); ?>

	<?php do_action('smartshop_after_bestsellers'); ?>

	<!-- ═══════════════════════════════════
	     PROMO SPLIT BANNER
	═══════════════════════════════════ -->
	<?php get_template_part('woocommerce/parts/promo-split'); ?>

	<?php do_action('smartshop_after_promo_banner'); ?>

	<!-- ═══════════════════════════════════
	     TESTIMONIALS
	═══════════════════════════════════ -->
	<?php get_template_part('woocommerce/parts/testimonials'); ?>

	<?php do_action('smartshop_after_testimonials'); ?>

	<!-- ═══════════════════════════════════
	     NEWSLETTER
	═══════════════════════════════════ -->
	<section class="smartshop-newsletter-section" aria-label="<?php esc_attr_e('Newsletter signup', 'smartshop'); ?>">
		<div class="container container--narrow">
			<h2 class="smartshop-newsletter-section__title"><?php esc_html_e('Get Early Access to New Drops', 'smartshop'); ?></h2>
			<p class="smartshop-newsletter-section__desc"><?php esc_html_e('Join 12,000+ subscribers. No spam, unsubscribe anytime.', 'smartshop'); ?></p>
			<?php get_template_part('template-parts/footer/parts/newsletter-signup'); ?>
		</div>
	</section>

	<?php do_action('smartshop_after_home'); ?>

</main><!-- #smartshop-main -->

<?php get_footer(); ?>
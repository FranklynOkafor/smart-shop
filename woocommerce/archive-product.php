<?php

/**
 * Archive Product — WooCommerce Shop & Category Pages
 *
 * Handles: /shop/, /product-category/*, /product-tag/*
 * WordPress template hierarchy: archive-product.php
 *
 * @package SmartShop
 * @see     https://woocommerce.com/document/template-structure/
 */

defined('ABSPATH') || exit;

get_header();

/**
 * Hook: smartshop_before_archive_product
 * Use this to inject banners, notices above the shop header.
 */
do_action('smartshop_before_archive_product');
?>

<main id="smartshop-main" class="smartshop-main smartshop-archive-product" role="main">

  <!-- ── ARCHIVE HEADER: title, breadcrumb, sort ── -->
  <div class="smartshop-archive-hero">
    <div class="container">

      <?php woocommerce_breadcrumb(); ?>

      <div class="smartshop-archive-hero__inner">
        <div class="smartshop-archive-hero__meta">
          <?php
          // Category/tag description when on taxonomy archive
          if (is_product_taxonomy()) {
            woocommerce_taxonomy_archive_description();
          }
          // Shop page title
          woocommerce_page_title();
          ?>
          <span class="smartshop-archive-hero__count">
            <?php woocommerce_result_count(); ?>
          </span>
        </div>

        <div class="smartshop-archive-hero__controls">
          <?php woocommerce_catalog_ordering(); ?>
        </div>
      </div>

    </div>
  </div>

  <?php do_action('smartshop_before_shop_loop'); ?>

  <!-- ── MAIN LAYOUT: SIDEBAR + GRID ── -->
  <div class="smartshop-archive-layout">
    <div class="container">
      <div class="smartshop-archive-columns">

        <!-- ─── FILTER SIDEBAR ─── -->
        <aside class="smartshop-sidebar smartshop-sidebar--shop" aria-label="<?php esc_attr_e('Product filters', 'smartshop'); ?>">

          <?php do_action('smartshop_before_shop_sidebar'); ?>

          <!-- Mobile: Filter toggle -->
          <button
            class="smartshop-sidebar__toggle"
            aria-expanded="false"
            aria-controls="smartshop-filters"
            type="button">
            <?php smartshop_icon('filter'); ?>
            <?php esc_html_e('Filters', 'smartshop'); ?>
          </button>

          <div id="smartshop-filters" class="smartshop-sidebar__body">

            <!-- Active Filters -->
            <?php if (is_active_sidebar('shop-filters')) : ?>
              <?php dynamic_sidebar('shop-filters'); ?>
            <?php else : ?>

              <!-- Active filter chips -->
              <div class="smartshop-filter-group smartshop-filter-group--active">
                <?php the_widget('WC_Widget_Layered_Nav_Filters', array('title' => '')); ?>
              </div>

              <!-- Categories -->
              <div class="smartshop-filter-group">
                <h3 class="smartshop-filter-group__title"><?php esc_html_e('Categories', 'smartshop'); ?></h3>
                <?php the_widget('WC_Widget_Product_Categories', array(
                  'title'              => '',
                  'orderby'            => 'name',
                  'show_children_only' => true,
                  'hide_empty'         => true,
                )); ?>
              </div>

              <!-- Price Filter -->
              <div class="smartshop-filter-group">
                <h3 class="smartshop-filter-group__title"><?php esc_html_e('Price', 'smartshop'); ?></h3>
                <?php the_widget('WC_Widget_Price_Filter', array('title' => '')); ?>
              </div>

              <!-- Rating Filter -->
              <div class="smartshop-filter-group">
                <h3 class="smartshop-filter-group__title"><?php esc_html_e('Rating', 'smartshop'); ?></h3>
                <?php the_widget('WC_Widget_Rating_Filter', array('title' => '')); ?>
              </div>

              <!-- Stock Status -->
              <div class="smartshop-filter-group">
                <h3 class="smartshop-filter-group__title"><?php esc_html_e('Availability', 'smartshop'); ?></h3>
                <?php the_widget('WC_Widget_Product_Tag_Cloud', array(
                  'title' => '',
                )); ?>
              </div>

              <?php
              /**
               * Attribute filters — add one per attribute.
               * Replace 'pa_color', 'pa_size' with your actual attribute slugs.
               */
              $filter_attributes = apply_filters('smartshop_filter_attributes', array('pa_color', 'pa_size'));

              foreach ($filter_attributes as $attribute) :
                $label = wc_attribute_label($attribute);
              ?>
                <div class="smartshop-filter-group">
                  <h3 class="smartshop-filter-group__title"><?php echo esc_html($label); ?></h3>
                  <?php the_widget('WC_Widget_Layered_Nav', array(
                    'title'        => '',
                    'attribute'    => $attribute,
                    'query_type'   => 'or',
                    'display_type' => 'list',
                  )); ?>
                </div>
              <?php endforeach; ?>

            <?php endif; ?>

          </div><!-- #smartshop-filters -->

          <?php do_action('smartshop_after_shop_sidebar'); ?>

        </aside><!-- .smartshop-sidebar -->

        <!-- ─── PRODUCT GRID ─── -->
        <div class="smartshop-archive-grid-col">

          <?php
          /**
           * Hook: woocommerce_before_shop_loop
           *
           * @hooked woocommerce_output_all_notices        - 10
           * @hooked woocommerce_result_count              - 20 (removed, we moved it above)
           * @hooked woocommerce_catalog_ordering          - 30 (removed, we moved it above)
           */
          remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
          remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
          do_action('woocommerce_before_shop_loop');
          ?>

          <?php if (woocommerce_product_loop()) : ?>

            <?php woocommerce_product_loop_start(); ?>

            <?php while (have_posts()) : the_post(); ?>
              <?php wc_get_template_part('content', 'product'); ?>
            <?php endwhile; ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php
            /**
             * Hook: woocommerce_after_shop_loop
             * @hooked woocommerce_pagination - 10
             */
            do_action('woocommerce_after_shop_loop');
            ?>

          <?php else : ?>
            <?php
            /**
             * Hook: woocommerce_no_products_found
             * @hooked wc_no_products_found - 10
             */
            do_action('woocommerce_no_products_found');
            ?>
          <?php endif; ?>

          <?php do_action('smartshop_after_shop_loop'); ?>

        </div><!-- .smartshop-archive-grid-col -->

      </div><!-- .smartshop-archive-columns -->
    </div><!-- .container -->
  </div><!-- .smartshop-archive-layout -->

</main><!-- #smartshop-main -->

<?php
do_action('smartshop_after_archive_product');
get_footer();

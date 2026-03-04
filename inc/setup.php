<?php

/**
 * SmartShop Theme Setup
 *
 * @package SmartShop
 */



if (!defined('ABSPATH')) {
  exit;
}


/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function smartshop_setup(): void
{

  // Make theme available for translation.
  load_theme_textdomain('smartshop', SMARTSHOP_DIR . '/languages');

  // Let WordPress manage the document title.
  add_theme_support('title-tag');

  // Enable post thumbnails.
  add_theme_support('post-thumbnails');

  // Switch default core markup to valid HTML5.
  add_theme_support(
    'html5',
    ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']
  );

  // Add support for full and wide aligned images.
  add_theme_support('align-wide');

  // Add support for responsive embedded content.
  add_theme_support('responsive-embeds');

  // Add support for editor styles.
  add_theme_support('editor-styles');
  add_editor_style('assets/css/editor-style.css');

  // Add default posts and comments RSS feed links to head.
  add_theme_support('automatic-feed-links');

  // Appearance tools (theme.json controlled).
  add_theme_support('appearance-tools');

  // Custom logo.
  add_theme_support(
    'custom-logo',
    [
      'height'               => 60,
      'width'                => 200,
      'flex-height'          => true,
      'flex-width'           => true,
      'unlink-homepage-logo' => true,
    ]
  );

  // Register nav menus.
  register_nav_menus(
    [
      'primary'   => esc_html__('Primary Navigation', 'smartshop'),
      'secondary' => esc_html__('Footer Navigation', 'smartshop'),
      'mobile'    => esc_html__('Mobile Navigation', 'smartshop'),
    ]
  );

  // Custom image sizes.
  add_image_size('smartshop-product-card',   420, 420, true);
  add_image_size('smartshop-product-hero',   900, 700, false);
  add_image_size('smartshop-product-thumb',  100, 100, true);

  // WooCommerce support.
  add_theme_support('woocommerce', [
    'thumbnail_image_width'         => 420,
    'single_image_width'            => 900,
    'product_grid'                  => [
      'default_rows'    => 4,
      'min_rows'        => 1,
      'max_rows'        => 10,
      'default_columns' => 4,
      'min_columns'     => 2,
      'max_columns'     => 5,
    ],
  ]);
  add_theme_support('wc-product-gallery-zoom');
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'smartshop_setup');

/**
 * Register widget areas / sidebars.
 */
function smartshop_widgets_init(): void
{

  $sidebars = [
    [
      'name'          => esc_html__('Shop Sidebar', 'smartshop'),
      'id'            => 'sidebar-shop',
      'description'   => esc_html__('Widgets in this area appear in the shop sidebar.', 'smartshop'),
    ],
    [
      'name'          => esc_html__('Footer Column 1', 'smartshop'),
      'id'            => 'footer-1',
      'description'   => esc_html__('First footer widget column.', 'smartshop'),
    ],
    [
      'name'          => esc_html__('Footer Column 2', 'smartshop'),
      'id'            => 'footer-2',
      'description'   => esc_html__('Second footer widget column.', 'smartshop'),
    ],
    [
      'name'          => esc_html__('Footer Column 3', 'smartshop'),
      'id'            => 'footer-3',
      'description'   => esc_html__('Third footer widget column.', 'smartshop'),
    ],
  ];

  $defaults = [
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widget__title">',
    'after_title'   => '</h3>',
  ];

  foreach ($sidebars as $sidebar) {
    register_sidebar(array_merge($defaults, $sidebar));
  }
}
add_action('widgets_init', 'smartshop_widgets_init');

/**
 * Set content width in pixels, based on the theme's design and stylesheet.
 */
function smartshop_content_width(): void
{
  $GLOBALS['content_width'] = apply_filters('smartshop_content_width', 1200);
}
add_action('after_setup_theme', 'smartshop_content_width', 0);

<?php

if (!defined('ABSPATH')) {
  exit;
}

function smartshop_theme_setup()
{

  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo');

  add_theme_support('woocommerce');

  register_nav_menus([
    'primary' => __('Primary Menu', 'smartshop'),
    'footer'  => __('Footer Menu', 'smartshop'),
  ]);
}

add_action('after_setup_theme', 'smartshop_theme_setup');

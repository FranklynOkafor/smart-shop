<?php

if (!defined('ABSPATH')) {
  exit;
}

function smartshop_enqueue_assets()
{

  wp_enqueue_style(
    'smartshop-style',
    get_stylesheet_uri(),
    [],
    wp_get_theme()->get('Version')
  );

  // Main 
  wp_enqueue_style(
    'smartshop-main',
    get_template_directory_uri() . '/assets/css/main.css',
    [],
    wp_get_theme()->get('Version')
  );


  // Main Js
  wp_enqueue_script(
    'smartshop-main-js',
    get_template_directory_uri() . '/assets/js/main.js',
    [],
    wp_get_theme()->get('Version'),
    true
  );
}

add_action('wp_enqueue_scripts', 'smartshop_enqueue_assets');

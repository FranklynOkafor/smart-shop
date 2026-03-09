<?php
defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product instanceof WC_Product ) {
    $product = wc_get_product( get_the_ID() );
}

if ( ! $product ) return;

set_query_var( 'smartshop_product', $product );
get_template_part( 'template-parts/products/product-card' );
<?php
/**
 * Template part: Static page content
 *
 * Called by page.php
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="page-<?php the_ID(); ?>" <?php post_class( 'single-page' ); ?>>

	<!-- ── PAGE HEADER ── -->
	<header class="single-page__header">
		<h1 class="single-page__title"><?php the_title(); ?></h1>
	</header>

	<!-- ── FEATURED IMAGE ── -->
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="single-page__thumbnail">
		<?php the_post_thumbnail( 'smartshop-product-hero', [
			'class'   => 'single-page__img',
			'loading' => 'eager',
			'alt'     => esc_attr( get_the_title() ),
		] ); ?>
	</div>
	<?php endif; ?>

	<!-- ── PAGE CONTENT ── -->
	<div class="single-page__content entry-content">
		<?php
		the_content();

		// Handles pages split with <!--nextpage-->
		wp_link_pages( [
			'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'smartshop' ) . '">',
			'after'  => '</nav>',
		] );
		?>
	</div><!-- .single-page__content -->

</article><!-- #page-<?php the_ID(); ?> -->
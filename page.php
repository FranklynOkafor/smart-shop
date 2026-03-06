<?php
/**
 * Static Page Template
 *
 * @package SmartShop
 */

get_header();
?>

<main id="main" class="site-main" role="main">

	<?php do_action( 'smartshop_before_content' ); ?>

	<div class="container container--narrow">

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content/content', 'page' );
		endwhile;
		?>

		<!-- Comments only if explicitly enabled on this page -->
		<?php if ( comments_open() || get_comments_number() ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>

	</div><!-- .container -->

	<?php do_action( 'smartshop_after_content' ); ?>

</main><!-- #main -->

<?php get_footer(); ?>
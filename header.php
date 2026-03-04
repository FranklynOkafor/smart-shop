<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

	<header id="masthead" class="site-header" role="banner">
		<div class="site-header__inner container">
			<?php
			/**
			 * Hook: smartshop_header
			 *
			 * @hooked smartshop_site_branding      - 10
			 * @hooked smartshop_primary_navigation - 20
			 * @hooked smartshop_header_utilities   - 30
			 */
			do_action( 'smartshop_header' );
			?>
		</div><!-- .site-header__inner -->

		<?php get_template_part( 'template-parts/header/navigation-mobile' ); ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
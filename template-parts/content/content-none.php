<?php
/**
 * Template part: No content found
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="no-results">
	<h1 class="no-results__title">
		<?php esc_html_e( 'Nothing found', 'smartshop' ); ?>
	</h1>
	<p class="no-results__text">
		<?php esc_html_e( 'It looks like nothing was found here. Maybe try a search?', 'smartshop' ); ?>
	</p>
	<?php get_search_form(); ?>
</section>
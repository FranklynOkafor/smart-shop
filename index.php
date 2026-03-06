<?php

/**
 * Index — Universal Fallback Template
 *
 * WordPress uses this when no more specific template exists.
 * For an ecommerce store this is typically the blog index.
 *
 * @package SmartShop
 */

get_header();
?>

<main id="smartshop-main" class="smartshop-main" role="main">

  <div class="smartshop-archive container">

    <?php if (have_posts()) : ?>

      <header class="smartshop-archive__header">
        <?php
        if (is_home() && ! is_front_page()) {
          // Static blog page title
          single_post_title('<h1 class="smartshop-archive__title">', '</h1>');
        } else {
          the_archive_title('<h1 class="smartshop-archive__title">', '</h1>');
          the_archive_description('<div class="smartshop-archive__desc">', '</div>');
        }
        ?>
      </header>

      <div class="smartshop-post-grid">
        <?php
        while (have_posts()) :
          the_post();
          get_template_part('template-parts/global/post-card', get_post_type());
        endwhile;
        ?>
      </div>

      <?php get_template_part('template-parts/global/pagination'); ?>

    <?php else : ?>

      <?php get_template_part('template-parts/global/no-results'); ?>

    <?php endif; ?>

  </div><!-- .smartshop-archive -->

</main><!-- #smartshop-main -->

<?php get_footer(); ?>
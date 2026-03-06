<?php

/**
 * Single Post Template
 *
 * @package SmartShop
 */

get_header();
?>

<main id="main" class="site-main" role="main">

  <?php do_action('smartshop_before_content'); ?>

  <div class="container container--single">
    <div class="single-layout single-layout--sidebar-left">

      <!-- ── LEFT SIDEBAR ── -->
      <?php if (is_active_sidebar('sidebar-blog')) : ?>
        <aside class="single-sidebar" role="complementary" aria-label="<?php esc_attr_e('Blog sidebar', 'smartshop'); ?>">
          <?php dynamic_sidebar('sidebar-blog'); ?>
        </aside>
      <?php endif; ?>

      <!-- ── MAIN CONTENT ── -->
      <div class="single-content">
        <?php
        while (have_posts()) :
          the_post();
          get_template_part('template-parts/content/content', 'single');
        endwhile;
        ?>
        
        <!-- Previous / Next post navigation -->
        <?php
        the_post_navigation([
          'prev_text' => '&larr; <span class="nav-subtitle">%title</span>',
          'next_text' => '<span class="nav-subtitle">%title</span> &rarr;',
          'class'     => 'post-navigation',
        ]);
        ?>

        <!-- Comments -->
        <?php if (comments_open() || get_comments_number()) : ?>
          <?php comments_template(); ?>
        <?php endif; ?>

      </div><!-- .single-content -->

    </div><!-- .single-layout -->
  </div><!-- .container -->

  <?php do_action('smartshop_after_content'); ?>

</main><!-- #main -->

<?php get_footer(); ?>
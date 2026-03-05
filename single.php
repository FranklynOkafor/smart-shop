<?php

/**
 * The main template file.
 *
 * This is WordPress's ultimate fallback — used when no more-specific
 * template is found. For SmartShop, specific templates (front-page.php,
 * archive.php, single.php, etc.) should handle their own contexts.
 *
 * @package SmartShop
 */

get_header();
?>

<main id="main" class="site-main" role="main">
  <?php
  /**
   * Hook: smartshop_before_content
   *
   * @hooked smartshop_page_header - 10
   */
  do_action('smartshop_before_content');
  ?>

  <div class="<?php echo esc_attr(smartshop_container_class()); ?>">

    <?php if (have_posts()) : ?>

      <div class="posts-grid">
        <?php
        while (have_posts()) :
          the_post();
          // Loads content-post.php for posts, or falls back to content-post.php
          $slug = get_post_type() === 'post' ? 'post' : 'post';
          get_template_part('template-parts/content/content', $slug);
        endwhile;
        ?>
      </div>

      <?php smartshop_pagination(); ?>

    <?php else : ?>

      <?php get_template_part('template-parts/content/content', 'none'); ?>

    <?php endif; ?>

  </div><!-- .container -->

  <?php
  /**
   * Hook: smartshop_after_content
   */
  do_action('smartshop_after_content');
  ?>
</main><!-- #main -->

<?php
get_footer();

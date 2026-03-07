<?php

/**
 * Template Part: Hero Banner Slideshow
 *
 * ACF fields required (attached to front page):
 * hero_slide_1_image, hero_slide_1_heading, hero_slide_1_subtext,
 * — same pattern for slides 2 and 3.
 *
 * @package SmartShop
 */

defined('ABSPATH') || exit;

// Build slides array — skip any slide with no image
$slides = [];

for ($i = 1; $i <= 3; $i++) {
  $image = get_field("hero_slide_{$i}_image");

  if (empty($image)) {
    continue;
  }

  $slides[] = [
    'image'         => is_array($image) ? $image['url'] : wp_get_attachment_url($image),
    'image_alt'     => is_array($image) ? $image['alt'] : get_post_meta($image, '_wp_attachment_image_alt', true),
    'heading'       => get_field("hero_slide_{$i}_heading"),
    'subtext'       => get_field("hero_slide_{$i}_subtext"),
    'primary_label' => get_field("primary_label"),
    'primary_url'   => get_field("hero_slide_{$i}_primary_url"),
    'outline_label' => get_field("outline_label"),
    'outline_url'   => get_field("outline_url"),
  ];

  
}

// Nothing to show if no slides have images
if (empty($slides)) {
  return;
}
?>

<section
  class="hero-banner"
  aria-label="<?php esc_attr_e('Hero banner', 'smartshop'); ?>"
  aria-roledescription="slideshow">

  <div class="hero-banner__track" data-hero-track>

    <?php foreach ($slides as $index => $slide) : ?>

      <div
        class="hero-banner__slide<?php echo $index === 0 ? ' hero-banner__slide--active' : ''; ?>"
        aria-roledescription="slide"
        aria-label="<?php echo esc_attr(sprintf('%d / %d', $index + 1, count($slides))); ?>"
        aria-hidden="<?php echo $index === 0 ? 'false' : 'true'; ?>"
        data-hero-slide>
        <!-- Background image + overlay -->
        <div
          class="hero-banner__bg"
          style="background-image: url('<?php echo esc_url($slide['image']); ?>');"
          role="img"
          aria-label="<?php echo esc_attr($slide['image_alt']); ?>">
          <div class="hero-banner__overlay" aria-hidden="true"></div>
        </div>

        <!-- Slide content -->
        <div class="hero-banner__content container">

          <?php if (! empty($slide['heading'])) : ?>
            <h2 class="hero-banner__heading">
              <?php echo esc_html($slide['heading']); ?>
            </h2>
          <?php endif; ?>

          <?php if (! empty($slide['subtext'])) : ?>
            <p class="hero-banner__subtext">
              <?php echo esc_html($slide['subtext']); ?>
            </p>
          <?php endif; ?>

          <?php if (! empty($slide['primary_label']) || ! empty($slide['outline_label'])) : ?>
            <div class="hero-banner__actions">

              <?php if (! empty($slide['primary_label']) && ! empty($slide['primary_url'])) : ?>
                <a
                  href="<?php echo esc_url($slide['primary_url']); ?>"
                  class="btn btn--primary">
                  <?php echo esc_html($slide['primary_label']); ?>
                </a>
              <?php endif; ?>

              <?php if (! empty($slide['outline_label']) && ! empty($slide['outline_url'])) : ?>
                <a
                  href="<?php echo esc_url($slide['outline_url']); ?>"
                  class="btn btn--outline-white">
                  <?php echo esc_html($slide['outline_label']); ?>
                </a>
              <?php endif; ?>

            </div>
          <?php endif; ?>

        </div><!-- .hero-banner__content -->

      </div><!-- .hero-banner__slide -->

    <?php endforeach; ?>

  </div><!-- .hero-banner__track -->

  <?php if (count($slides) > 1) : ?>

    <!-- Prev / Next controls -->
    <button
      class="hero-banner__btn hero-banner__btn--prev"
      type="button"
      aria-label="<?php esc_attr_e('Previous slide', 'smartshop'); ?>"
      data-hero-prev>
      <?php smartshop_icon('chevron-left'); ?>
    </button>

    <button
      class="hero-banner__btn hero-banner__btn--next"
      type="button"
      aria-label="<?php esc_attr_e('Next slide', 'smartshop'); ?>"
      data-hero-next>
      <?php smartshop_icon('chevron-right'); ?>
    </button>

    <!-- Dot indicators -->
    <div class="hero-banner__dots" role="tablist" aria-label="<?php esc_attr_e('Slides', 'smartshop'); ?>">
      <?php foreach ($slides as $index => $slide) : ?>
        <button
          class="hero-banner__dot<?php echo $index === 0 ? ' hero-banner__dot--active' : ''; ?>"
          type="button"
          role="tab"
          aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
          aria-label="<?php echo esc_attr(sprintf(__('Go to slide %d', 'smartshop'), $index + 1)); ?>"
          data-hero-dot="<?php echo esc_attr($index); ?>"></button>
      <?php endforeach; ?>
    </div>

  <?php endif; ?>

</section><!-- .hero-banner -->
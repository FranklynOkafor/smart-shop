<?php

/**
 * Template Part: Testimonials Carousel
 *
 * ACF fields required (attached to front page):
 * testimonial_1_name, testimonial_1_location, testimonial_1_rating,
 * testimonial_1_text, testimonial_1_avatar
 * — same pattern for 2, 3, 4.
 *
 * @package SmartShop
 */

defined('ABSPATH') || exit;

if (! function_exists('get_field')) {
  return;
}

// Build testimonials array — skip any with no text
$testimonials = [];

for ($i = 1; $i <= 4; $i++) {
  $text = get_field("testimonial_{$i}_text");

  if (empty($text)) {
    continue;
  }

  $avatar    = get_field("testimonial_{$i}_avatar");
  $avatar_url = '';
  $avatar_alt = '';

  if (is_array($avatar)) {
    $avatar_url = $avatar['sizes']['thumbnail'] ?? $avatar['url'];
    $avatar_alt = $avatar['alt'] ?: get_field("testimonial_{$i}_name");
  } elseif ($avatar) {
    $avatar_url = wp_get_attachment_thumb_url($avatar);
    $avatar_alt = get_post_meta($avatar, '_wp_attachment_image_alt', true);
  }

  $testimonials[] = [
    'name'     => get_field("testimonial_{$i}_name"),
    'location' => get_field("testimonial_{$i}_location"),
    'rating'   => (int) get_field("testimonial_{$i}_rating"),
    'text'     => $text,
    'avatar'   => $avatar_url,
    'alt'      => $avatar_alt,
  ];
}

if (empty($testimonials)) {
  return;
}
?>

<section class="testimonials" aria-label="<?php esc_attr_e('Customer testimonials', 'smartshop'); ?>">
  <div class="container">

    <header class="smartshop-section-header">
      <span class="smartshop-eyebrow"><?php esc_html_e('Happy Customers', 'smartshop'); ?></span>
      <h2 class="smartshop-section-header__title"><?php esc_html_e('What Our Customers Say', 'smartshop'); ?></h2>
    </header>

    <div
      class="testimonials__carousel"
      aria-roledescription="carousel"
      aria-label="<?php esc_attr_e('Customer testimonials', 'smartshop'); ?>"
      data-testimonial-carousel>

      <div class="testimonials__track" data-testimonial-track>

        <?php foreach ($testimonials as $index => $testimonial) : ?>
          <div
            class="testimonials__slide<?php echo $index === 0 ? ' testimonials__slide--active' : ''; ?>"
            role="group"
            aria-roledescription="slide"
            aria-label="<?php echo esc_attr(sprintf('%d / %d', $index + 1, count($testimonials))); ?>"
            aria-hidden="<?php echo $index === 0 ? 'false' : 'true'; ?>"
            data-testimonial-slide>
            <blockquote class="testimonial-card">

              <!-- Star rating -->
              <?php if ($testimonial['rating'] > 0) : ?>
                <div class="testimonial-card__stars" aria-label="<?php echo esc_attr(sprintf(__('Rated %d out of 5', 'smartshop'), $testimonial['rating'])); ?>">
                  <?php for ($s = 1; $s <= 5; $s++) : ?>
                    <svg
                      class="testimonial-card__star<?php echo $s <= $testimonial['rating'] ? ' testimonial-card__star--filled' : ''; ?>"
                      xmlns="http://www.w3.org/2000/svg"
                      width="16" height="16"
                      viewBox="0 0 24 24"
                      fill="<?php echo $s <= $testimonial['rating'] ? 'currentColor' : 'none'; ?>"
                      stroke="currentColor"
                      stroke-width="2"
                      aria-hidden="true">
                      <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                  <?php endfor; ?>
                </div>
              <?php endif; ?>

              <!-- Review text -->
              <p class="testimonial-card__text">
                <?php echo esc_html($testimonial['text']); ?>
              </p>

              <!-- Author -->
              <footer class="testimonial-card__author">
                <?php if ($testimonial['avatar']) : ?>
                  <img
                    src="<?php echo esc_url($testimonial['avatar']); ?>"
                    alt="<?php echo esc_attr($testimonial['alt']); ?>"
                    class="testimonial-card__avatar"
                    width="48"
                    height="48"
                    loading="lazy" />
                <?php else : ?>
                  <div class="testimonial-card__avatar-placeholder" aria-hidden="true">
                    <?php echo esc_html(mb_substr($testimonial['name'], 0, 1)); ?>
                  </div>
                <?php endif; ?>

                <div class="testimonial-card__meta">
                  <?php if ($testimonial['name']) : ?>
                    <cite class="testimonial-card__name"><?php echo esc_html($testimonial['name']); ?></cite>
                  <?php endif; ?>
                  <?php if ($testimonial['location']) : ?>
                    <span class="testimonial-card__location"><?php echo esc_html($testimonial['location']); ?></span>
                  <?php endif; ?>
                </div>
              </footer>

            </blockquote>
          </div><!-- .testimonials__slide -->
        <?php endforeach; ?>

      </div><!-- .testimonials__track -->

      <?php if (count($testimonials) > 1) : ?>

        <!-- Prev / Next -->
        <button
          class="testimonials__btn testimonials__btn--prev"
          type="button"
          aria-label="<?php esc_attr_e('Previous testimonial', 'smartshop'); ?>"
          data-testimonial-prev>
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="15 18 9 12 15 6" />
          </svg>
        </button>

        <button
          class="testimonials__btn testimonials__btn--next"
          type="button"
          aria-label="<?php esc_attr_e('Next testimonial', 'smartshop'); ?>"
          data-testimonial-next>
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="9 18 15 12 9 6" />
          </svg>
        </button>

        <!-- Dots -->
        <div class="testimonials__dots" role="tablist" aria-label="<?php esc_attr_e('Testimonials', 'smartshop'); ?>">
          <?php foreach ($testimonials as $index => $testimonial) : ?>
            <button
              class="testimonials__dot<?php echo $index === 0 ? ' testimonials__dot--active' : ''; ?>"
              type="button"
              role="tab"
              aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
              aria-label="<?php echo esc_attr(sprintf(__('Go to testimonial %d', 'smartshop'), $index + 1)); ?>"
              data-testimonial-dot="<?php echo esc_attr($index); ?>"></button>
          <?php endforeach; ?>
        </div>

      <?php endif; ?>

    </div><!-- .testimonials__carousel -->

  </div><!-- .container -->
</section><!-- .testimonials -->
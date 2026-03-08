/**
 * Testimonials Carousel
 *
 * File: assets/js/components/testimonials.js
 *
 * - Manual navigation only (prev/next/dots)
 * - Keyboard: ArrowLeft / ArrowRight when focused
 * - Pause on focus inside carousel
 * - No jQuery, no external dependencies
 *
 * @package SmartShop
 */

(function () {
  "use strict";

  const ACTIVE_CLASS = "testimonials__slide--active";
  const ACTIVE_DOT_CLASS = "testimonials__dot--active";

  /**
   * Initialise a single testimonials carousel.
   *
   * @param {HTMLElement} carousel
   */
  function initCarousel(carousel) {
    const slides = Array.from(
      carousel.querySelectorAll("[data-testimonial-slide]")
    );
    const dots = Array.from(
      carousel.querySelectorAll("[data-testimonial-dot]")
    );
    const prevBtn = carousel.querySelector("[data-testimonial-prev]");
    const nextBtn = carousel.querySelector("[data-testimonial-next]");

    if (slides.length <= 1) {
      return;
    }

    let current = 0;

    // ── Go to a specific slide ────────────────────────────────────────

    function goTo(index) {
      if (index < 0) index = slides.length - 1;
      if (index >= slides.length) index = 0;

      // Deactivate current
      slides[current].classList.remove(ACTIVE_CLASS);
      slides[current].setAttribute("aria-hidden", "true");

      if (dots[current]) {
        dots[current].classList.remove(ACTIVE_DOT_CLASS);
        dots[current].setAttribute("aria-selected", "false");
      }

      // Activate new
      current = index;
      slides[current].classList.add(ACTIVE_CLASS);
      slides[current].setAttribute("aria-hidden", "false");

      if (dots[current]) {
        dots[current].classList.add(ACTIVE_DOT_CLASS);
        dots[current].setAttribute("aria-selected", "true");
      }
    }

    // ── Prev / Next ───────────────────────────────────────────────────

    if (prevBtn) {
      prevBtn.addEventListener("click", function () {
        goTo(current - 1);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener("click", function () {
        goTo(current + 1);
      });
    }

    // ── Dots ──────────────────────────────────────────────────────────

    dots.forEach(function (dot) {
      dot.addEventListener("click", function () {
        const index = parseInt(dot.getAttribute("data-testimonial-dot"), 10);
        goTo(index);
      });
    });

    // ── Keyboard ──────────────────────────────────────────────────────

    carousel.addEventListener("keydown", function (e) {
      if (e.key === "ArrowLeft") {
        e.preventDefault();
        goTo(current - 1);
      }
      if (e.key === "ArrowRight") {
        e.preventDefault();
        goTo(current + 1);
      }
    });
  }

  // ── Boot ─────────────────────────────────────────────────────────────

  document.addEventListener("DOMContentLoaded", function () {
    const carousels = document.querySelectorAll("[data-testimonial-carousel]");
    carousels.forEach(initCarousel);
  });
})();

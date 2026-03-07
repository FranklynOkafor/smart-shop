/**
 * Hero Banner Slideshow
 *
 * File: assets/js/components/hero-slideshow.js
 *
 * - Auto-advances every 5 seconds
 * - Pauses on hover and on focus inside the banner
 * - Prev / Next buttons
 * - Dot indicators
 * - Keyboard: ArrowLeft / ArrowRight when focused inside banner
 * - Respects prefers-reduced-motion (skips auto-advance)
 * - No jQuery, no external dependencies
 *
 * @package SmartShop
 */

(function () {
  "use strict";

  const INTERVAL_MS = 5000; // 5 seconds
  const ACTIVE_CLASS = "hero-banner__slide--active";
  const ACTIVE_DOT_CLASS = "hero-banner__dot--active";

  /**
   * Initialise a single hero banner instance.
   *
   * @param {HTMLElement} banner
   */
  function initHero(banner) {
    const slides = Array.from(banner.querySelectorAll("[data-hero-slide]"));
    const dots = Array.from(banner.querySelectorAll("[data-hero-dot]"));
    const prevBtn = banner.querySelector("[data-hero-prev]");
    const nextBtn = banner.querySelector("[data-hero-next]");

    // Nothing to do with only one slide
    if (slides.length <= 1) {
      return;
    }

    let current = 0;
    let timer = null;
    let isPaused = false;

    const reducedMotion = window.matchMedia(
      "(prefers-reduced-motion: reduce)"
    ).matches;

    // ── Go to a specific slide ──────────────────────────────────────────

    function goTo(index) {
      // Wrap around
      if (index < 0) {
        index = slides.length - 1;
      }
      if (index >= slides.length) {
        index = 0;
      }

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

    // ── Auto-advance timer ──────────────────────────────────────────────

    function startTimer() {
      if (reducedMotion) {
        return; // Respect reduced motion — no auto-advance
      }
      stopTimer();
      timer = setInterval(function () {
        if (!isPaused) {
          goTo(current + 1);
        }
      }, INTERVAL_MS);
    }

    function stopTimer() {
      if (timer) {
        clearInterval(timer);
        timer = null;
      }
    }

    // ── Pause on hover ──────────────────────────────────────────────────

    banner.addEventListener("mouseenter", function () {
      isPaused = true;
    });

    banner.addEventListener("mouseleave", function () {
      isPaused = false;
    });

    // ── Pause when focus moves inside the banner ────────────────────────

    banner.addEventListener("focusin", function () {
      isPaused = true;
    });

    banner.addEventListener("focusout", function (e) {
      // Only resume if focus left the banner entirely
      if (!banner.contains(e.relatedTarget)) {
        isPaused = false;
      }
    });

    // ── Prev / Next buttons ─────────────────────────────────────────────

    if (prevBtn) {
      prevBtn.addEventListener("click", function () {
        goTo(current - 1);
        startTimer(); // Reset timer on manual interaction
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener("click", function () {
        goTo(current + 1);
        startTimer();
      });
    }

    // ── Dot clicks ──────────────────────────────────────────────────────

    dots.forEach(function (dot) {
      dot.addEventListener("click", function () {
        const index = parseInt(dot.getAttribute("data-hero-dot"), 10);
        goTo(index);
        startTimer();
      });
    });

    // ── Keyboard support (ArrowLeft / ArrowRight) ───────────────────────

    banner.addEventListener("keydown", function (e) {
      if (e.key === "ArrowLeft") {
        e.preventDefault();
        goTo(current - 1);
        startTimer();
      }
      if (e.key === "ArrowRight") {
        e.preventDefault();
        goTo(current + 1);
        startTimer();
      }
    });

    // ── Visibility API — pause when tab is hidden ───────────────────────

    document.addEventListener("visibilitychange", function () {
      if (document.hidden) {
        stopTimer();
      } else {
        startTimer();
      }
    });

    // ── Kick off ────────────────────────────────────────────────────────

    startTimer();
  }

  // ── Boot on DOMContentLoaded ────────────────────────────────────────────

  document.addEventListener("DOMContentLoaded", function () {
    const banners = document.querySelectorAll(".hero-banner");
    banners.forEach(initHero);
  });
})();

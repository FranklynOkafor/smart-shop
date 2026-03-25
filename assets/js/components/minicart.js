/**
 * Mini Cart Dropdown
 *
 * File: assets/js/components/mini-cart.js
 *
 * - Hover intent with delay so it doesn't flicker
 * - Touch devices fall back to click
 * - Refreshes on WooCommerce AJAX add-to-cart
 * - Closes on Escape key
 * - Closes on outside click
 *
 * @package SmartShop
 */

( function () {

	'use strict';

	const OPEN_CLASS    = 'is-open';
	const HOVER_DELAY   = 150; // ms before opening
	const CLOSE_DELAY   = 300; // ms before closing — gives time to move mouse into panel

	/**
	 * Initialise a single mini cart wrap.
	 *
	 * @param {HTMLElement} wrap
	 */
	function initMiniCart( wrap ) {

		const trigger = wrap.querySelector( '.js-cart-trigger' );
		const panel   = wrap.querySelector( '[data-mini-cart-panel]' );

		if ( ! trigger || ! panel ) return;

		let openTimer  = null;
		let closeTimer = null;
		let isTouch    = false;

		// ── Detect touch ────────────────────────────────────────────────

		window.addEventListener( 'touchstart', function () {
			isTouch = true;
		}, { once: true } );

		// ── Helpers ──────────────────────────────────────────────────────

		function open() {
			clearTimeout( closeTimer );
			wrap.classList.add( OPEN_CLASS );
			trigger.setAttribute( 'aria-expanded', 'true' );
			panel.setAttribute( 'aria-hidden', 'false' );
		}

		function close() {
			clearTimeout( openTimer );
			wrap.classList.remove( OPEN_CLASS );
			trigger.setAttribute( 'aria-expanded', 'false' );
			panel.setAttribute( 'aria-hidden', 'true' );
		}

		function scheduleOpen() {
			clearTimeout( closeTimer );
			openTimer = setTimeout( open, HOVER_DELAY );
		}

		function scheduleClose() {
			clearTimeout( openTimer );
			closeTimer = setTimeout( close, CLOSE_DELAY );
		}

		// ── Hover (desktop) ──────────────────────────────────────────────

		wrap.addEventListener( 'mouseenter', function () {
			if ( isTouch ) return;
			scheduleOpen();
		} );

		wrap.addEventListener( 'mouseleave', function () {
			if ( isTouch ) return;
			scheduleClose();
		} );

		// ── Click (touch / keyboard fallback) ────────────────────────────

		trigger.addEventListener( 'click', function ( e ) {
			if ( ! isTouch ) return; // hover handles it on desktop

			// On touch, toggle and prevent navigation to cart page
			if ( wrap.classList.contains( OPEN_CLASS ) ) {
				close();
			} else {
				e.preventDefault();
				open();
			}
		} );

		// ── Escape key ───────────────────────────────────────────────────

		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && wrap.classList.contains( OPEN_CLASS ) ) {
				close();
				trigger.focus();
			}
		} );

		// ── Outside click ────────────────────────────────────────────────

		document.addEventListener( 'click', function ( e ) {
			if ( ! wrap.contains( e.target ) ) {
				close();
			}
		} );
	}

	// ── WooCommerce AJAX cart refresh ────────────────────────────────────

	function refreshMiniCart() {
		if ( typeof wc_cart_fragments_params === 'undefined' ) return;

		jQuery( document.body ).on( 'wc_fragments_refreshed wc_fragments_loaded added_to_cart removed_from_cart', function () {
			// WooCommerce updates .woocommerce-mini-cart automatically via fragments
			// Update item count badge in header
			const countEls = document.querySelectorAll( '.cart-count' );
			const fragment = document.querySelector( '.woocommerce-mini-cart' );

			if ( fragment ) {
				const items = fragment.querySelectorAll( '.woocommerce-mini-cart__item' );
				const count = items.length;

				countEls.forEach( function ( el ) {
					el.textContent = count;
					el.classList.toggle( 'cart-count--empty', count === 0 );
				} );

				// Update item count in mini cart header
				const countLabel = document.querySelector( '.mini-cart__count' );
				if ( countLabel ) {
					countLabel.textContent = count === 1 ? '1 item' : count + ' items';
				}
			}
		} );
	}

	// ── Boot ─────────────────────────────────────────────────────────────

	document.addEventListener( 'DOMContentLoaded', function () {
		const wraps = document.querySelectorAll( '[data-mini-cart]' );
		wraps.forEach( initMiniCart );
		refreshMiniCart();
	} );

} )();
/**
 * NaijaFresh Market — main.js
 * Core interactive behaviours: sticky header, cart drawer,
 * search modal, toast notifications, scroll animations.
 *
 * Vanilla JS — no framework dependency, tree-shakeable.
 * @package NaijaFresh
 */

( function () {
  'use strict';

  // ==========================================================================
  // UTILITIES
  // ==========================================================================

  const $ = ( sel, ctx = document ) => ctx.querySelector( sel );
  const $$ = ( sel, ctx = document ) => [ ...ctx.querySelectorAll( sel ) ];
  const on = ( el, ev, fn, opts ) => el && el.addEventListener( ev, fn, opts );
  const off = ( el, ev, fn ) => el && el.removeEventListener( ev, fn );

  /** Debounce */
  function debounce( fn, ms = 200 ) {
    let t;
    return ( ...args ) => {
      clearTimeout( t );
      t = setTimeout( () => fn( ...args ), ms );
    };
  }

  /** Trap focus inside an element */
  function trapFocus( el ) {
    const focusable = $$( 'a[href],button:not([disabled]),input,select,textarea,[tabindex]:not([tabindex="-1"])', el );
    const first = focusable[ 0 ];
    const last  = focusable[ focusable.length - 1 ];

    function handler( e ) {
      if ( e.key !== 'Tab' ) return;
      if ( e.shiftKey ) {
        if ( document.activeElement === first ) { e.preventDefault(); last.focus(); }
      } else {
        if ( document.activeElement === last )  { e.preventDefault(); first.focus(); }
      }
    }

    on( el, 'keydown', handler );
    return () => off( el, 'keydown', handler );
  }

  // ==========================================================================
  // STICKY HEADER
  // ==========================================================================

  ( function initStickyHeader() {
    const header = $( '.nf-site-header' );
    if ( ! header ) return;

    const threshold = 60;
    let ticking = false;

    function update() {
      header.classList.toggle( 'is-scrolled', window.scrollY > threshold );
      ticking = false;
    }

    on( window, 'scroll', () => {
      if ( ! ticking ) {
        requestAnimationFrame( update );
        ticking = true;
      }
    }, { passive: true } );
  } )();

  // ==========================================================================
  // CART DRAWER
  // ==========================================================================

  const CartDrawer = ( function () {
    const drawer   = $( '#nf-cart-drawer' );
    const overlay  = $( '#nf-drawer-overlay' );
    const toggles  = $$( '.nf-cart-toggle' );
    const closeBtns = $$( '.nf-cart-drawer__close' );
    let releaseTrap;

    if ( ! drawer ) return {};

    function open() {
      drawer.classList.add( 'is-open' );
      overlay.classList.add( 'is-visible' );
      document.body.style.overflow = 'hidden';
      toggles.forEach( b => b.setAttribute( 'aria-expanded', 'true' ) );
      drawer.removeAttribute( 'hidden' );
      releaseTrap = trapFocus( drawer );
      // Focus first interactive element
      const firstFocusable = $( 'button, a', drawer );
      if ( firstFocusable ) firstFocusable.focus();
    }

    function close() {
      drawer.classList.remove( 'is-open' );
      overlay.classList.remove( 'is-visible' );
      document.body.style.overflow = '';
      toggles.forEach( b => b.setAttribute( 'aria-expanded', 'false' ) );
      if ( releaseTrap ) releaseTrap();
      // Return focus to toggle
      if ( toggles[ 0 ] ) toggles[ 0 ].focus();
    }

    toggles.forEach( b => on( b, 'click', () => {
      drawer.classList.contains( 'is-open' ) ? close() : open();
    } ) );

    closeBtns.forEach( b => on( b, 'click', close ) );
    on( overlay, 'click', close );

    on( document, 'keydown', e => {
      if ( e.key === 'Escape' && drawer.classList.contains( 'is-open' ) ) close();
    } );

    return { open, close };
  } )();

  // ==========================================================================
  // SEARCH MODAL
  // ==========================================================================

  ( function initSearch() {
    const modal     = $( '#nf-search-modal' );
    const toggles   = $$( '.nf-search-toggle' );
    const closeBtn  = $( '.nf-search-modal__close' );
    const input     = $( '#nf-search-input' );
    const resultBox = $( '#nf-search-results' );
    let releaseTrap;

    if ( ! modal ) return;

    function openModal() {
      modal.removeAttribute( 'hidden' );
      modal.classList.add( 'is-open' );
      document.body.style.overflow = 'hidden';
      toggles.forEach( b => b.setAttribute( 'aria-expanded', 'true' ) );
      releaseTrap = trapFocus( modal );
      if ( input ) input.focus();
    }

    function closeModal() {
      modal.setAttribute( 'hidden', '' );
      modal.classList.remove( 'is-open' );
      document.body.style.overflow = '';
      toggles.forEach( b => b.setAttribute( 'aria-expanded', 'false' ) );
      if ( releaseTrap ) releaseTrap();
      if ( resultBox ) { resultBox.hidden = true; resultBox.innerHTML = ''; }
    }

    toggles.forEach( b => on( b, 'click', openModal ) );
    if ( closeBtn ) on( closeBtn, 'click', closeModal );
    on( document, 'keydown', e => { if ( e.key === 'Escape' ) closeModal(); } );

    // Click backdrop
    on( modal, 'click', e => { if ( e.target === modal ) closeModal(); } );

    // Live search autocomplete
    if ( input && resultBox && window.naijafreshData ) {
      const fetchSuggestions = debounce( async function ( query ) {
        if ( query.length < 2 ) { resultBox.hidden = true; return; }

        try {
          const url = new URL( window.naijafreshData.restUrl + 'wc/v3/products' );
          url.searchParams.set( 'search', query );
          url.searchParams.set( 'per_page', '6' );
          url.searchParams.set( 'status', 'publish' );

          const res = await fetch( url.toString(), {
            headers: { 'X-WP-Nonce': window.naijafreshData.nonce },
          } );
          const products = await res.json();

          if ( ! Array.isArray( products ) || products.length === 0 ) {
            resultBox.hidden = true;
            return;
          }

          resultBox.innerHTML = products.map( p => `
            <a href="${ p.permalink }" class="nf-search-result-item">
              ${ p.images && p.images[0]
                ? `<img src="${ p.images[0].thumbnail }" alt="${ p.name }" width="48" height="64" loading="lazy">`
                : '<span class="nf-search-result-item__placeholder"></span>' }
              <span class="nf-search-result-item__info">
                <strong>${ p.name }</strong>
                <span>${ p.price_html }</span>
              </span>
            </a>
          ` ).join( '' );

          resultBox.removeAttribute( 'hidden' );
        } catch ( err ) {
          console.warn( '[NaijaFresh] Search error:', err );
        }
      }, 300 );

      on( input, 'input', () => fetchSuggestions( input.value.trim() ) );

      on( document, 'click', e => {
        if ( ! resultBox.contains( e.target ) && e.target !== input ) {
          resultBox.hidden = true;
        }
      } );
    }
  } )();

  // ==========================================================================
  // TOAST NOTIFICATIONS
  // ==========================================================================

  const Toast = ( function () {
    const container = $( '#nf-toast-container' );

    function show( message, type = 'info', duration = 3500 ) {
      if ( ! container ) return;

      const icons = { success: 'ph-check-circle', error: 'ph-warning-circle', info: 'ph-info' };
      const toast = document.createElement( 'div' );
      toast.className = `nf-toast nf-toast--${ type }`;
      toast.innerHTML = `
        <i class="ph-fill ${ icons[ type ] || icons.info } nf-toast__icon" aria-hidden="true"></i>
        <span>${ message }</span>
        <button class="nf-toast__close" aria-label="Dismiss" style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;">
          <i class="ph ph-x" aria-hidden="true"></i>
        </button>
      `;

      container.appendChild( toast );

      const dismiss = () => {
        toast.classList.add( 'is-leaving' );
        setTimeout( () => toast.remove(), 350 );
      };

      on( toast.querySelector( '.nf-toast__close' ), 'click', dismiss );
      setTimeout( dismiss, duration );

      return dismiss;
    }

    return { show };
  } )();

  // Expose globally
  window.NaijaFreshToast = Toast;

  // ==========================================================================
  // ADD TO CART — AJAX
  // ==========================================================================

  on( document, 'click', async function ( e ) {
    const btn = e.target.closest( '.nf-add-to-cart[data-product-id]' );
    if ( ! btn || ! window.naijafreshData ) return;

    e.preventDefault();

    const productId = btn.dataset.productId;
    const qty       = parseInt( btn.dataset.qty || '1', 10 );

    btn.classList.add( 'is-loading' );
    btn.disabled = true;

    try {
      const res = await fetch( window.naijafreshData.ajaxUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams( {
          action:     'woocommerce_ajax_add_to_cart',
          product_id: productId,
          quantity:   qty,
        } ),
      } );

      const data = await res.json();

      if ( data.fragments ) {
        // Update WooCommerce fragments (cart count etc.)
        Object.entries( data.fragments ).forEach( ( [ selector, html ] ) => {
          $$( selector ).forEach( el => { el.outerHTML = html; } );
        } );
      }

      btn.classList.remove( 'is-loading' );
      btn.classList.add( 'added' );
      btn.disabled = false;

      Toast.show( window.naijafreshData.i18n.addedToCart, 'success' );

      // Open cart drawer
      if ( CartDrawer.open ) CartDrawer.open();

      setTimeout( () => btn.classList.remove( 'added' ), 2000 );
    } catch ( err ) {
      btn.classList.remove( 'is-loading' );
      btn.disabled = false;
      Toast.show( window.naijafreshData.i18n.errorGeneric, 'error' );
    }
  } );

  // ==========================================================================
  // SCROLL REVEAL
  // ==========================================================================

  ( function initScrollReveal() {
    if ( ! ( 'IntersectionObserver' in window ) ) return;

    const els = $$( '[data-reveal]' );
    if ( els.length === 0 ) return;

    const observer = new IntersectionObserver( ( entries ) => {
      entries.forEach( entry => {
        if ( entry.isIntersecting ) {
          entry.target.classList.add( 'is-revealed' );
          observer.unobserve( entry.target );
        }
      } );
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' } );

    els.forEach( el => observer.observe( el ) );
  } )();

  // ==========================================================================
  // HERO PARALLAX
  // ==========================================================================

  ( function initHeroParallax() {
    const hero = $( '.nf-hero' );
    if ( ! hero ) return;

    // Trigger Ken Burns only after paint
    requestAnimationFrame( () => hero.classList.add( 'is-visible' ) );

    // Parallax on scroll
    let ticking = false;
    on( window, 'scroll', () => {
      if ( ! ticking ) {
        requestAnimationFrame( () => {
          const offset = window.scrollY;
          const media  = $( '.nf-hero__media', hero );
          if ( media && offset < window.innerHeight ) {
            media.style.transform = `translateY( ${ offset * 0.3 }px )`;
          }
          ticking = false;
        } );
        ticking = true;
      }
    }, { passive: true } );
  } )();

  // ==========================================================================
  // PRODUCT IMAGE GALLERY
  // ==========================================================================

  ( function initProductGallery() {
    const thumbs = $$( '.nf-gallery-thumb' );
    const main   = $( '.nf-gallery-main img' );
    if ( ! thumbs.length || ! main ) return;

    thumbs.forEach( thumb => {
      on( thumb, 'click', () => {
        const src    = thumb.dataset.fullSrc || thumb.src;
        const srcset = thumb.dataset.fullSrcset || '';
        main.src    = src;
        main.srcset = srcset;
        thumbs.forEach( t => t.classList.remove( 'is-active' ) );
        thumb.classList.add( 'is-active' );
      } );
    } );
  } )();

  // ==========================================================================
  // QUANTITY SELECTOR
  // ==========================================================================

  on( document, 'click', function ( e ) {
    const btn = e.target.closest( '.nf-qty__btn' );
    if ( ! btn ) return;

    const wrapper = btn.closest( '.nf-qty' );
    const input   = $( '.nf-qty__input', wrapper );
    if ( ! input ) return;

    const min  = parseInt( input.min  || '1',  10 );
    const max  = parseInt( input.max  || '999',10 );
    const step = parseInt( input.step || '1',  10 );
    const val  = parseInt( input.value || '1', 10 );

    if ( btn.classList.contains( 'nf-qty__btn--plus' ) ) {
      input.value = Math.min( max, val + step );
    } else {
      input.value = Math.max( min, val - step );
    }

    input.dispatchEvent( new Event( 'change', { bubbles: true } ) );
  } );

  // ==========================================================================
  // MOBILE NAV
  // ==========================================================================

  ( function initMobileNav() {
    const hamburger = $( '.nf-hamburger' );
    const nav       = $( '.nf-mobile-nav' );
    if ( ! hamburger || ! nav ) return;

    let releaseTrap;

    hamburger.addEventListener( 'click', () => {
      const expanded = hamburger.getAttribute( 'aria-expanded' ) === 'true';

      if ( expanded ) {
        hamburger.setAttribute( 'aria-expanded', 'false' );
        nav.classList.remove( 'is-open' );
        document.body.style.overflow = '';
        if ( releaseTrap ) releaseTrap();
      } else {
        hamburger.setAttribute( 'aria-expanded', 'true' );
        nav.classList.add( 'is-open' );
        document.body.style.overflow = 'hidden';
        releaseTrap = trapFocus( nav );
      }
    } );

    on( document, 'keydown', e => {
      if ( e.key === 'Escape' && nav.classList.contains( 'is-open' ) ) {
        hamburger.setAttribute( 'aria-expanded', 'false' );
        nav.classList.remove( 'is-open' );
        document.body.style.overflow = '';
        if ( releaseTrap ) releaseTrap();
        hamburger.focus();
      }
    } );
  } )();

  // ==========================================================================
  // BACK TO TOP
  // ==========================================================================

  ( function initBackToTop() {
    const btn = $( '.nf-back-to-top' );
    if ( ! btn ) return;

    let ticking = false;
    on( window, 'scroll', () => {
      if ( ! ticking ) {
        requestAnimationFrame( () => {
          btn.classList.toggle( 'is-visible', window.scrollY > 400 );
          ticking = false;
        } );
        ticking = true;
      }
    }, { passive: true } );

    on( btn, 'click', () => window.scrollTo( { top: 0, behavior: 'smooth' } ) );
  } )();

  // ==========================================================================
  // COUNTDOWN TIMER (for promo banners)
  // ==========================================================================

  ( function initCountdowns() {
    $$( '[data-countdown]' ).forEach( el => {
      const target = new Date( el.dataset.countdown );
      if ( isNaN( target ) ) return;

      const dd = el.querySelector( '.nf-cd-days' );
      const hh = el.querySelector( '.nf-cd-hours' );
      const mm = el.querySelector( '.nf-cd-minutes' );
      const ss = el.querySelector( '.nf-cd-seconds' );

      function update() {
        const diff = target - Date.now();
        if ( diff <= 0 ) {
          el.textContent = 'Offer ended';
          return;
        }
        const days    = Math.floor( diff / 86400000 );
        const hours   = Math.floor( ( diff % 86400000 ) / 3600000 );
        const minutes = Math.floor( ( diff % 3600000 )  / 60000 );
        const seconds = Math.floor( ( diff % 60000 )    / 1000 );

        if ( dd ) dd.textContent = String( days ).padStart( 2, '0' );
        if ( hh ) hh.textContent = String( hours ).padStart( 2, '0' );
        if ( mm ) mm.textContent = String( minutes ).padStart( 2, '0' );
        if ( ss ) ss.textContent = String( seconds ).padStart( 2, '0' );
      }

      update();
      setInterval( update, 1000 );
    } );
  } )();

} )();

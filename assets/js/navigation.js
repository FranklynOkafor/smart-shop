/**
 * SmartShop Navigation
 *
 * Handles mobile menu toggle and accessible keyboard navigation.
 * Zero dependencies — no jQuery.
 *
 * @package SmartShop
 */

( function () {
	'use strict';

	const SELECTORS = {
		toggle:  '.js-nav-toggle',
		close:   '.js-nav-close',
		drawer:  '#mobile-nav',
		overlay: '.mobile-nav__overlay',
	};

	const CLASSES = {
		navOpen:  'nav-open',
		drawerOpen: 'mobile-nav--open',
	};

	/** @type {HTMLElement|null} */
	const body   = document.body;
	/** @type {HTMLElement|null} */
	const toggle = document.querySelector( SELECTORS.toggle );
	/** @type {HTMLElement|null} */
	const drawer = document.querySelector( SELECTORS.drawer );

	if ( ! toggle || ! drawer ) return;

	/**
	 * Open the mobile navigation drawer.
	 */
	function openNav() {
		drawer.classList.add( CLASSES.drawerOpen );
		drawer.removeAttribute( 'aria-hidden' );
		toggle.setAttribute( 'aria-expanded', 'true' );
		toggle.setAttribute( 'aria-label', smartshopData.i18n.menuClose );
		body.classList.add( CLASSES.navOpen );

		// Move focus into the drawer for accessibility.
		const firstFocusable = drawer.querySelector( 'button, a, [tabindex="0"]' );
		if ( firstFocusable ) firstFocusable.focus();
	}

	/**
	 * Close the mobile navigation drawer.
	 */
	function closeNav() {
		drawer.classList.remove( CLASSES.drawerOpen );
		drawer.setAttribute( 'aria-hidden', 'true' );
		toggle.setAttribute( 'aria-expanded', 'false' );
		toggle.setAttribute( 'aria-label', smartshopData.i18n.menuOpen );
		body.classList.remove( CLASSES.navOpen );
		toggle.focus();
	}

	// Toggle on hamburger click.
	toggle.addEventListener( 'click', function () {
		const isOpen = drawer.classList.contains( CLASSES.drawerOpen );
		isOpen ? closeNav() : openNav();
	} );

	// Close buttons (X icon and overlay click).
	document.querySelectorAll( SELECTORS.close ).forEach( function ( el ) {
		el.addEventListener( 'click', closeNav );
	} );

	// Close on Escape key.
	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Escape' && drawer.classList.contains( CLASSES.drawerOpen ) ) {
			closeNav();
		}
	} );

	// Trap focus inside drawer when open.
	drawer.addEventListener( 'keydown', function ( e ) {
		if ( e.key !== 'Tab' ) return;

		const focusable = Array.from(
			drawer.querySelectorAll( 'button, a, input, [tabindex="0"]' )
		).filter( el => ! el.hasAttribute( 'disabled' ) );

		if ( ! focusable.length ) return;

		const first = focusable[0];
		const last  = focusable[ focusable.length - 1 ];

		if ( e.shiftKey && document.activeElement === first ) {
			e.preventDefault();
			last.focus();
		} else if ( ! e.shiftKey && document.activeElement === last ) {
			e.preventDefault();
			first.focus();
		}
	} );

} )();
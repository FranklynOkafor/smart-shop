<?php
/**
 * Template Part: Newsletter Signup Form
 *
 * Simple HTML form — wire up to your email provider later.
 * Action and method left as placeholders.
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="newsletter">

	<div class="newsletter__inner">

		<div class="newsletter__content">
			<span class="smartshop-eyebrow"><?php esc_html_e( 'Stay in the loop', 'smartshop' ); ?></span>
			<h2 class="newsletter__heading"><?php esc_html_e( 'Get Early Access to New Drops', 'smartshop' ); ?></h2>
			<p class="newsletter__desc"><?php esc_html_e( 'Join 12,000+ subscribers. No spam, unsubscribe anytime.', 'smartshop' ); ?></p>
		</div>

		<div class="newsletter__form-wrap">
			<form
				class="newsletter__form js-newsletter-form"
				method="post"
				action="#"
				novalidate
				aria-label="<?php esc_attr_e( 'Newsletter signup', 'smartshop' ); ?>"
			>
				<?php wp_nonce_field( 'smartshop_newsletter', 'smartshop_newsletter_nonce' ); ?>

				<div class="newsletter__field-group">
					<label for="newsletter-email" class="screen-reader-text">
						<?php esc_html_e( 'Email address', 'smartshop' ); ?>
					</label>
					<input
						type="email"
						id="newsletter-email"
						name="newsletter_email"
						class="newsletter__input"
						placeholder="<?php esc_attr_e( 'Enter your email address', 'smartshop' ); ?>"
						required
						autocomplete="email"
						aria-required="true"
						aria-describedby="newsletter-error"
					/>
					<button
						type="submit"
						class="btn btn--primary newsletter__submit"
						aria-label="<?php esc_attr_e( 'Subscribe to newsletter', 'smartshop' ); ?>"
					>
						<?php esc_html_e( 'Subscribe', 'smartshop' ); ?>
					</button>
				</div>

				<!-- Inline error message -->
				<p
					id="newsletter-error"
					class="newsletter__error"
					role="alert"
					aria-live="polite"
					hidden
				></p>

				<!-- Success message -->
				<p
					class="newsletter__success"
					role="status"
					aria-live="polite"
					hidden
				>
					<?php esc_html_e( "You're in! Check your inbox to confirm your subscription.", 'smartshop' ); ?>
				</p>

			</form>

			<p class="newsletter__disclaimer">
				<?php esc_html_e( 'By subscribing you agree to our privacy policy. Unsubscribe at any time.', 'smartshop' ); ?>
			</p>
		</div>

	</div><!-- .newsletter__inner -->

</div><!-- .newsletter -->
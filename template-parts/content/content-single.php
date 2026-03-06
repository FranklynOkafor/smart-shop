<?php
/**
 * Template part: Single post full article
 *
 * Called by single.php
 *
 * @package SmartShop
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>

	<!-- ── POST HEADER ── -->
	<header class="single-post__header">

		<!-- Category links -->
		<?php
		$categories = get_the_category();
		if ( $categories ) : ?>
		<div class="single-post__categories">
			<?php foreach ( $categories as $cat ) : ?>
				<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="single-post__category">
					<?php echo esc_html( $cat->name ); ?>
				</a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

		<!-- Title -->
		<h1 class="single-post__title"><?php the_title(); ?></h1>

		<!-- Meta: author + date -->
		<div class="single-post__meta">
			<span class="single-post__author">
				<?php
				printf(
					/* translators: %s: author display name */
					esc_html__( 'By %s', 'smartshop' ),
					'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">'
					. esc_html( get_the_author() )
					. '</a>'
				);
				?>
			</span>
			<span class="single-post__sep" aria-hidden="true">&middot;</span>
			<time class="single-post__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( get_the_date() ); ?>
			</time>
		</div>

	</header><!-- .single-post__header -->

	<!-- ── FEATURED IMAGE ── -->
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="single-post__thumbnail">
		<?php the_post_thumbnail( 'smartshop-product-hero', [
			'class'   => 'single-post__img',
			'loading' => 'eager',
			'alt'     => esc_attr( get_the_title() ),
		] ); ?>
	</div>
	<?php endif; ?>

	<!-- ── POST CONTENT ── -->
	<div class="single-post__content entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: post title */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'smartshop' ),
				[ 'span' => [ 'class' => [] ] ]
			),
			get_the_title()
		) );

		wp_link_pages( [
			'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'smartshop' ) . '">',
			'after'  => '</nav>',
		] );
		?>
	</div><!-- .single-post__content -->

	<!-- ── POST FOOTER: tags ── -->
	<?php
	$tags = get_the_tags();
	if ( $tags ) : ?>
	<footer class="single-post__footer">
		<div class="single-post__tags">
			<span class="single-post__tags-label"><?php esc_html_e( 'Tagged:', 'smartshop' ); ?></span>
			<?php foreach ( $tags as $tag ) : ?>
				<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="single-post__tag">
					<?php echo esc_html( $tag->name ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	</footer>
	<?php endif; ?>

	<!-- ── AUTHOR BIO ── -->
	<?php
	$author_bio = get_the_author_meta( 'description' );
	if ( $author_bio ) : ?>
	<div class="single-post__author-box">
		<div class="author-box">
			<div class="author-box__avatar">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 80, '', '', [
					'class' => 'author-box__img',
				] ); ?>
			</div>
			<div class="author-box__body">
				<h3 class="author-box__name">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
						<?php echo esc_html( get_the_author() ); ?>
					</a>
				</h3>
				<p class="author-box__bio"><?php echo esc_html( $author_bio ); ?></p>
			</div>
		</div>
	</div>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
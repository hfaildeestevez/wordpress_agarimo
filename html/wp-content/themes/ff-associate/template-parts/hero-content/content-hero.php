<?php
/**
 * Template part for displaying Hero Content
 *
 * @package FF Associate
 */
if ( ! ff_associate_gtm( 'ff_associate_hero_content_page' ) ) {
	return;
}

$ff_associate_args = array(
	'page_id'        => absint( ff_associate_gtm( 'ff_associate_hero_content_page' ) ),
	'posts_per_page' => 1,
	'post_type'      => 'page',
);

$ff_associate_loop = new WP_Query( $ff_associate_args );

while ( $ff_associate_loop->have_posts() ) :
	$ff_associate_loop->the_post();

	$ff_associate_content_align = ff_associate_gtm( 'ff_associate_hero_content_position' );
	$ff_associate_text_align    = ff_associate_gtm( 'ff_associate_hero_content_text_align' );
	$ff_associate_subtitle      = ff_associate_gtm( 'ff_associate_hero_content_custom_subtitle' );

	$classes[] = 'hero-content-section section';
	$classes[] = ff_associate_gtm( 'ff_associate_hero_content_position' );
	$classes[] = ff_associate_gtm( 'ff_associate_hero_content_text_align' );

	if ( ! has_post_thumbnail() ) {
		$classes[] = 'thumbnail-disable';
	}
	?>

	<div id="hero-content-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<div class="section-featured-page">
			<div class="container">
				<div class="row">
					<div class="hero-content-wrapper">
						<?php if ( has_post_thumbnail() ) : ?>
						<div class="ff-grid-6 featured-page-thumb">
							<div class=" featured-page-thumb-wrapper"><?php the_post_thumbnail( 'ff-associate-hero', array( 'class' => 'alignnone' ) );?>
						</div>
						</div>
						<?php endif; ?>

						<!-- .ff-grid-6 -->
						<div class="ff-grid-6 featured-page-content">
							<div class="featured-page-section">
								<div class="section-title-wrap text-alignleft">
									<?php if ( $ff_associate_subtitle ) : ?>
									<p class="section-top-subtitle"><?php echo esc_html( $ff_associate_subtitle ); ?></p>
									<?php endif; ?>

									<?php the_title( '<h2 class="section-title">', '</h2>' ); ?>

									<span class="divider"></span>
								</div>

								<?php ff_associate_display_content( 'hero_content' ); ?>
							</div><!-- .featured-page-section -->
						</div><!-- .ff-grid-6 -->
					</div><!-- .hero-content-wrapper -->

				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .section-featured-page -->
	</div><!-- .section -->
<?php
endwhile;

wp_reset_postdata();

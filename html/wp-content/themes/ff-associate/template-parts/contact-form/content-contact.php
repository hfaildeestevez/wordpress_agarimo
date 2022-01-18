<?php
/**
 * Template part for displaying Hero Content
 *
 * @package FF Associate
 */

if ( ! ff_associate_gtm( 'ff_associate_contact_form_page' ) ) {
	return;
}

$ff_associate_args = array(
	'page_id'        => absint( ff_associate_gtm( 'ff_associate_contact_form_page' ) ),
	'posts_per_page' => 1,
	'post_type'      => 'page',
);

$ff_associate_loop = new WP_Query( $ff_associate_args );

while ( $ff_associate_loop->have_posts() ) :
	$ff_associate_loop->the_post();

	$subtitle = ff_associate_gtm( 'ff_associate_contact_form_custom_subtitle' );
	?>
	<div id="contact-form-section" class="section no-map">
	<div class="section-contact clear-fix">
			<div class="container">
				<div class="custom-contact-form clear-fix">
				
				<div class="form-section ff-grid-6 no-margin">
					<div class="section-title-wrap text-alignleft">
						<?php if ( $subtitle ) : ?>
							<p class="section-top-subtitle"><?php echo esc_html( $subtitle ); ?></p>
						<?php endif; ?>

							<?php the_title( '<h2 class="section-title">', '</h2>' ); ?>

							<span class="divider"></span>
					</div><!-- .section-title-wrap -->

					<?php the_content(); ?>
				</div>
				<div class="ff-grid-6 contact-thumb no-padding no-margin pull-right">
					<?php ff_associate_post_thumbnail(); ?>
				</div>
			</div><!-- .custom-contact-form -->
			</div>
			<!-- .container -->
		</div><!-- .section-contact -->
	</div><!-- .section -->
<?php
endwhile;

wp_reset_postdata();

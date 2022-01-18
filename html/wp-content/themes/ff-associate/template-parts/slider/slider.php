<?php
/**
 * Template part for displaying Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF Associate
 */

$ff_associate_visibility = ff_associate_gtm( 'ff_associate_slider_visibility' );

if ( ! ff_associate_display_section( $ff_associate_visibility ) ) {
	return;
}

?>
<div id="slider-section" class="section slider-section no-padding overlay-enabled style-one zoom-disabled">
	<div class="swiper-wrapper">
		<?php get_template_part( 'template-parts/slider/post', 'type' ); ?>
	</div><!-- .swiper-wrapper -->


	<?php
	// Pagination.
	if ( ff_associate_gtm( 'ff_associate_slider_pagination' ) ) : ?>
    <div class="swiper-pagination"></div>
	<?php endif; ?>

    <?php
	// Navigation.
	if ( ff_associate_gtm( 'ff_associate_slider_navigation' ) ) : ?>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <?php endif; ?>
</div><!-- .main-slider -->

<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF Associate
 */

$ff_associate_visibility = ff_associate_gtm( 'ff_associate_wwd_visibility' );

if ( ! ff_associate_display_section( $ff_associate_visibility ) ) {
	return;
}

?>
<div id="wwd-section" class="wwd-section section page style-one">
	<div class="section-wwd">
		<div class="container">
			<?php ff_associate_section_title( 'wwd' ); ?>

			<?php get_template_part( 'template-parts/wwd/post-type' ); ?>
		</div><!-- .container -->
	</div><!-- .section-wwd  -->
</div><!-- .section -->

<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF Associate
 */

$ff_associate_visibility = ff_associate_gtm( 'ff_associate_featured_grid_visibility' );

if ( ! ff_associate_display_section( $ff_associate_visibility ) ) {
	return;
}

$ff_associate_classes[] = 'featured-grid-section section page style-one';
?>
<div id="featured-grid-section" class="featured-grid-section section page style-one">
	<div class="container">
		<?php ff_associate_section_title( 'featured_grid' ); ?>

		<?php get_template_part( 'template-parts/featured-grid/post-type' ); ?>

		<?php
		$ff_associate_button_text   = ff_associate_gtm( 'ff_associate_featured_grid_button_text' );
		$ff_associate_button_link   = ff_associate_gtm( 'ff_associate_featured_grid_button_link' );
		$ff_associate_button_target = ff_associate_gtm( 'ff_associate_featured_grid_button_target' ) ? '_blank' : '_self';

		if ( $ff_associate_button_text ) : ?>
			<div class="more-wrapper clear-fix">
				<a href="<?php echo esc_url($ff_associate_button_link); ?>" class="ff-button" target="<?php echo esc_attr( $ff_associate_button_target ); ?>"><?php echo esc_html($ff_associate_button_text); ?></a>
			</div><!-- .more-wrapper -->
		<?php endif; ?>
	</div><!-- .container -->
</div><!-- .latest-posts-section -->


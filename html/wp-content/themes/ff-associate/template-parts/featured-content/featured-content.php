<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF Associate
 */

$ff_associate_visibility = ff_associate_gtm( 'ff_associate_featured_content_visibility' );

if ( ! ff_associate_display_section( $ff_associate_visibility ) ) {
	return;
}

?>
<div id="featured-content-section" class="section featured-content-section style-one page">
	<div class="section-latest-posts">
		<div class="container">
			<?php 
				ff_associate_section_title( 'featured_content' );
				
				get_template_part( 'template-parts/featured-content/post-type' ); 
			?>
		</div><!-- .container -->
	</div><!-- .latest-posts-section -->
</div><!-- .section-latest-posts -->


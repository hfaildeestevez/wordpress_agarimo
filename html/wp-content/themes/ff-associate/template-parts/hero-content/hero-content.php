<?php
/**
 * Template part for displaying Hero Content
 *
 * @package FF Associate
 */

$ff_associate_enable = ff_associate_gtm( 'ff_associate_hero_content_visibility' );

if ( ! ff_associate_display_section( $ff_associate_enable ) ) {
	return;
}

get_template_part( 'template-parts/hero-content/content-hero' );

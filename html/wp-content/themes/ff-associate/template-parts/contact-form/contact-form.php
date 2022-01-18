<?php
/**
 * Template part for displaying Hero Content
 *
 * @package FF Associate
 */

$ff_associate_visibility = ff_associate_gtm( 'ff_associate_contact_form_visibility' );

if ( ! ff_associate_display_section( $ff_associate_visibility ) ) {
	return;
}

get_template_part( 'template-parts/contact-form/content-contact' );

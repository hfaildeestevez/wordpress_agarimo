<?php
/**
 * FF Associate Theme Customizer
 *
 * @package FF Associate
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ff_associate_sortable_sections( $wp_customize ) {
	$wp_customize->add_panel( 'ff_associate_sp_sortable', array(
		'title'       => esc_html__( 'Sections', 'ff-associate' ),
		'priority'    => 150,
	) );

	$default_sections = ff_associate_get_default_sortable_sections();

	$sortable_options = array();

	$sortable_order = ff_associate_gtm( 'ff_associate_ss_order' );

	if ( $sortable_order ) {
		$sortable_options = explode( ',', $sortable_order );
	}

	$sortable_sections = array_unique( $sortable_options + array_keys( $default_sections ) );
		
	foreach ( $sortable_sections as $section ) {
		if ( isset( $default_sections[$section] ) ) {
			// Add sections.
			$wp_customize->add_section( 'ff_associate_ss_' . $section,
				array(
					'title' => $default_sections[$section],
					'panel' => 'ff_associate_sp_sortable'
				)
			);
		}
		
		unset($default_sections[$section]);
	}

	if ( count( $default_sections ) ) {
		foreach ($default_sections as $key => $value) {
			// Add new sections.
			$wp_customize->add_section( 'ff_associate_ss_' . $key,
				array(
					'title' => $value,
					'panel' => 'ff_associate_sp_sortable'
				)
			);
		}
	}

	// Add hidden section for saving sorted sections.
	FF_Associate_Customizer_Utilities::register_option(
		array(
			'settings'          => 'ff_associate_ss_order',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Section layout', 'ff-associate' ),
			'section'           => 'ff_associate_ss_main_content',
		)
	);
}
add_action( 'customize_register', 'ff_associate_sortable_sections', 1 );

/**
 * Default sortable sections order
 * @return array
 */
function ff_associate_get_default_sortable_sections() {
	return $default_sections = array (
		'slider'           => esc_html__( 'Slider', 'ff-associate' ),
		'wwd'              => esc_html__( 'What We Do', 'ff-associate' ),
		'hero_content'     => esc_html__( 'Hero Content', 'ff-associate' ),
		'featured_grid'    => esc_html__( 'Featured Grid', 'ff-associate' ),
		'featured_content' => esc_html__( 'Featured Content', 'ff-associate' ),
		'contact_form'     => esc_html__( 'Contact Form', 'ff-associate' ),
	);
}

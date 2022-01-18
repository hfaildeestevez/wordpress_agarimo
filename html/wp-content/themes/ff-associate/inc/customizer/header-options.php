<?php
/**
 * Adds the header options sections, settings, and controls to the theme customizer
 *
 * @package FF Associate
 */

class FF_Associate_Header_Options {
	public function __construct() {
		// Register Header Options.
		add_action( 'customize_register', array( $this, 'register_header_options' ) );
	}

	/**
	 * Add header options section and its controls
	 */
	public function register_header_options( $wp_customize ) {
		// Add header options section.
		$wp_customize->add_section( 'ff_associate_header_options',
			array(
				'title' => esc_html__( 'Header Options', 'ff-associate' ),
				'panel' => 'ff_associate_theme_options'
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'ff_associate_header_email',
				'sanitize_callback' => 'sanitize_email',
				'label'             => esc_html__( 'Email', 'ff-associate' ),
				'section'           => 'ff_associate_header_options',
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'ff_associate_header_phone',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'label'             => esc_html__( 'Phone', 'ff-associate' ),
				'section'           => 'ff_associate_header_options',
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'ff_associate_header_address',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'label'             => esc_html__( 'Address', 'ff-associate' ),
				'section'           => 'ff_associate_header_options',
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'ff_associate_header_open_hours',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'label'             => esc_html__( 'Open Hours', 'ff-associate' ),
				'section'           => 'ff_associate_header_options',
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'ff_associate_header_button_text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'label'             => esc_html__( 'Button Text', 'ff-associate' ),
				'section'           => 'ff_associate_header_options',
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'url',
				'settings'          => 'ff_associate_header_button_link',
				'sanitize_callback' => 'esc_url_raw',
				'label'             => esc_html__( 'Button Link', 'ff-associate' ),
				'section'           => 'ff_associate_header_options',
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Associate_Toggle_Switch_Custom_control',
				'settings'          => 'ff_associate_header_button_target',
				'sanitize_callback' => 'ff_associate_switch_sanitization',
				'label'             => esc_html__( 'Open link in new tab?', 'ff-associate' ),
				'section'           => 'ff_associate_header_options',
			)
		);
	}
}

/**
 * Initialize class
 */
$ff_associate_theme_options = new FF_Associate_Header_Options();

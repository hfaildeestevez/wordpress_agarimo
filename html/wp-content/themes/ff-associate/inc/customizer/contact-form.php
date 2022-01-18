<?php
/**
 * Contact Form Options
 *
 * @package FF Associate
 */

class FF_Associate_Contact_Form_Options {
	public function __construct() {
		// Register Contact Form Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'ff_associate_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'ff_associate_contact_form_visibility' => 'disabled',
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add layouts section and its controls
	 */
	public function register_options( $wp_customize ) {
		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_contact_form_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'ff_associate_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'ff-associate' ),
				'section'           => 'ff_associate_ss_contact_form',
				'choices'           => FF_Associate_Customizer_Utilities::section_visibility(),
			)
		);

		// Add Edit Shortcut Icon.
		$wp_customize->selective_refresh->add_partial( 'ff_associate_contact_form_visibility', array(
			'selector' => '#contact-form-section',
		) );

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Associate_Dropdown_Posts_Custom_Control',
				'sanitize_callback' => 'absint',
				'settings'          => 'ff_associate_contact_form_page',
				'label'             => esc_html__( 'Select Page', 'ff-associate' ),
				'section'           => 'ff_associate_ss_contact_form',
				'active_callback'   => array( $this, 'is_section_visible' ),
				'input_attrs' => array(
					'post_type'      => 'page',
					'posts_per_page' => -1,
					'orderby'        => 'name',
					'order'          => 'ASC',
				),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'settings'          => 'ff_associate_contact_form_custom_subtitle',
				'label'             => esc_html__( 'Top Subtitle', 'ff-associate' ),
				'section'           => 'ff_associate_ss_contact_form',
				'active_callback'   => array( $this, 'is_section_visible' ),
			)
		);
	}

	/**
	 * Contact Form visibility active callback.
	 */
	public function is_section_visible( $control ) {
		return ( ff_associate_display_section( $control->manager->get_setting( 'ff_associate_contact_form_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$ff_associate_ss_contact_form = new FF_Associate_Contact_Form_Options();

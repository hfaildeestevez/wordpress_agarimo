<?php
/**
 * Featured Content Options
 *
 * @package FF Associate
 */

class FF_Associate_Featured_Content_Options {
	public function __construct() {
		// Register Featured Content Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'ff_associate_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'ff_associate_featured_content_visibility' => 'disabled',
			'ff_associate_featured_content_number'     => 3,
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
				'settings'          => 'ff_associate_featured_content_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'ff_associate_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_content',
				'choices'           => FF_Associate_Customizer_Utilities::section_visibility(),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'settings'          => 'ff_associate_featured_content_section_top_subtitle',
				'label'             => esc_html__( 'Section Top Sub-title', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_content',
				'active_callback'   => array( $this, 'is_featured_content_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_featured_content_section_title',
				'type'              => 'text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'label'             => esc_html__( 'Section Title', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_content',
				'active_callback'   => array( $this, 'is_featured_content_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_featured_content_section_subtitle',
				'type'              => 'text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'label'             => esc_html__( 'Section Subtitle', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_content',
				'active_callback'   => array( $this, 'is_featured_content_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_featured_content_number',
				'type'              => 'number',
				'label'             => esc_html__( 'Number', 'ff-associate' ),
				'description'       => esc_html__( 'Please refresh the customizer page once the number is changed.', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_content',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_featured_content_visible' ),
			)
		);

		$numbers = ff_associate_gtm( 'ff_associate_featured_content_number' );

		for( $i = 0, $j = 1; $i < $numbers; $i++, $j++ ) {
			FF_Associate_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'FF_Associate_Dropdown_Posts_Custom_Control',
					'sanitize_callback' => 'absint',
					'settings'          => 'ff_associate_featured_content_page_' . $i,
					'label'             => esc_html__( 'Select Page', 'ff-associate' ),
					'section'           => 'ff_associate_ss_featured_content',
					'active_callback'   => array( $this, 'is_featured_content_visible' ),
					'input_attrs' => array(
						'post_type'      => 'page',
						'posts_per_page' => -1,
						'orderby'        => 'name',
						'order'          => 'ASC',
					),
				)
			);
		}
	}

	/**
	 * Featured Content visibility active callback.
	 */
	public function is_featured_content_visible( $control ) {
		return ( ff_associate_display_section( $control->manager->get_setting( 'ff_associate_featured_content_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$ff_associate_ss_featured_content = new FF_Associate_Featured_Content_Options();

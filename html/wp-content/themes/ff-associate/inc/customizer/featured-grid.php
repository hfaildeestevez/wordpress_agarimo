<?php
/**
 * Featured Grid Options
 *
 * @package FF Associate
 */

class FF_Associate_Featured_Grid_Options {
	public function __construct() {
		// Register Featured Grid Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'ff_associate_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'ff_associate_featured_grid_visibility'  => 'disabled',
			'ff_associate_featured_grid_number'      => 3,
			'ff_associate_featured_grid_button_link' => '#',
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
				'settings'          => 'ff_associate_featured_grid_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'ff_associate_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_grid',
				'choices'           => FF_Associate_Customizer_Utilities::section_visibility(),
			)
		);

		// Add Edit Shortcut Icon.
		$wp_customize->selective_refresh->add_partial( 'ff_associate_featured_grid_visibility', array(
			'selector' => '#featured-grid-section',
		) );

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'settings'          => 'ff_associate_featured_grid_section_top_subtitle',
				'label'             => esc_html__( 'Section Top Sub-title', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_grid',
				'active_callback'   => array( $this, 'is_featured_grid_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_featured_grid_section_title',
				'type'              => 'text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'label'             => esc_html__( 'Section Title', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_grid',
				'active_callback'   => array( $this, 'is_featured_grid_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_featured_grid_section_subtitle',
				'type'              => 'text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'label'             => esc_html__( 'Section Subtitle', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_grid',
				'active_callback'   => array( $this, 'is_featured_grid_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_featured_grid_number',
				'type'              => 'number',
				'label'             => esc_html__( 'Number', 'ff-associate' ),
				'description'       => esc_html__( 'Please refresh the customizer page once the number is changed.', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_grid',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_featured_grid_visible' ),
			)
		);

		$numbers = ff_associate_gtm( 'ff_associate_featured_grid_number' );

		for( $i = 0, $j = 1; $i < $numbers; $i++, $j++ ) {
			FF_Associate_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'FF_Associate_Dropdown_Posts_Custom_Control',
					'sanitize_callback' => 'absint',
					'settings'          => 'ff_associate_featured_grid_page_' . $i,
					'label'             => esc_html__( 'Select Page', 'ff-associate' ),
					'section'           => 'ff_associate_ss_featured_grid',
					'active_callback'   => array( $this, 'is_featured_grid_visible' ),
					'input_attrs' => array(
						'post_type'      => 'page',
						'posts_per_page' => -1,
						'orderby'        => 'name',
						'order'          => 'ASC',
					),
				)
			);
		}

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'settings'          => 'ff_associate_featured_grid_button_text',
				'label'             => esc_html__( 'Button Text', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_grid',
				'active_callback'   => array( $this, 'is_featured_grid_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'url',
				'sanitize_callback' => 'esc_url_raw',
				'settings'          => 'ff_associate_featured_grid_button_link',
				'label'             => esc_html__( 'Button Link', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_grid',
				'active_callback'   => array( $this, 'is_featured_grid_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Associate_Toggle_Switch_Custom_control',
				'settings'          => 'ff_associate_featured_grid_button_target',
				'sanitize_callback' => 'ff_associate_switch_sanitization',
				'label'             => esc_html__( 'Open link in new tab?', 'ff-associate' ),
				'section'           => 'ff_associate_ss_featured_grid',
				'active_callback'   => array( $this, 'is_featured_grid_visible' ),
			)
		);
	}

	/**
	 * Featured Grid visibility active callback.
	 */
	public function is_featured_grid_visible( $control ) {
		return ( ff_associate_display_section( $control->manager->get_setting( 'ff_associate_featured_grid_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$ff_associate_ss_featured_grid = new FF_Associate_Featured_Grid_Options();

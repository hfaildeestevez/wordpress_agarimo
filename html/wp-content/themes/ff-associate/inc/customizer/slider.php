<?php
/**
 * Slider Options
 *
 * @package FF Associate
 */

class FF_Associate_Slider_Options {
	public function __construct() {
		// Register Slider Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 98 );

		// Add default options.
		add_filter( 'ff_associate_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'ff_associate_slider_visibility'     => 'disabled',
			'ff_associate_slider_number'         => 2,
			'ff_associate_slider_autoplay_delay' => 5000,
			'ff_associate_slider_pause_on_hover' => 1,
			'ff_associate_slider_navigation'     => 1,
			'ff_associate_slider_pagination'     => 1,
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add slider section and its controls
	 */
	public function register_options( $wp_customize ) {
		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_slider_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'ff_associate_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'ff-associate' ),
				'section'           => 'ff_associate_ss_slider',
				'choices'           => FF_Associate_Customizer_Utilities::section_visibility(),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'number',
				'settings'          => 'ff_associate_slider_number',
				'label'             => esc_html__( 'Number', 'ff-associate' ),
				'description'       => esc_html__( 'Please refresh the customizer page once the number is changed.', 'ff-associate' ),
				'section'           => 'ff_associate_ss_slider',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);

		$numbers = ff_associate_gtm( 'ff_associate_slider_number' );

		for( $i = 0, $j = 1; $i < $numbers; $i++, $j++ ) {
			FF_Associate_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'FF_Associate_Simple_Notice_Custom_Control',
					'sanitize_callback' => 'ff_associate_text_sanitization',
					'settings'          => 'ff_associate_slider_notice_' . $i,
					'label'             => esc_html__( 'Item #', 'ff-associate' )  . $j,
					'section'           => 'ff_associate_ss_slider',
					'active_callback'   => array( $this, 'is_slider_visible' ),
				)
			);

			FF_Associate_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'FF_Associate_Dropdown_Posts_Custom_Control',
					'sanitize_callback' => 'absint',
					'settings'          => 'ff_associate_slider_page_' . $i,
					'label'             => esc_html__( 'Select Page', 'ff-associate' ),
					'section'           => 'ff_associate_ss_slider',
					'active_callback'   => array( $this, 'is_slider_visible' ),
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
				'custom_control'    => 'FF_Associate_Toggle_Switch_Custom_control',
				'settings'          => 'ff_associate_slider_autoplay',
				'sanitize_callback' => 'ff_associate_switch_sanitization',
				'label'             => esc_html__( 'Autoplay', 'ff-associate' ),
				'section'           => 'ff_associate_ss_slider',
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_slider_autoplay_delay',
				'type'              => 'number',
				'sanitize_callback' => 'absint',
				'label'             => esc_html__( 'Autoplay Delay', 'ff-associate' ),
				'description'       => esc_html__( '(in ms)', 'ff-associate' ),
				'section'           => 'ff_associate_ss_slider',
				'input_attrs'           => array(
					'width' => '10px',
				),
				'active_callback'   => array( $this, 'is_slider_autoplay_on' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Associate_Toggle_Switch_Custom_control',
				'settings'          => 'ff_associate_slider_pause_on_hover',
				'sanitize_callback' => 'ff_associate_switch_sanitization',
				'label'             => esc_html__( 'Pause On Hover', 'ff-associate' ),
				'section'           => 'ff_associate_ss_slider',
				'active_callback'   => array( $this, 'is_slider_autoplay_on' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Associate_Toggle_Switch_Custom_control',
				'settings'          => 'ff_associate_slider_navigation',
				'sanitize_callback' => 'ff_associate_switch_sanitization',
				'label'             => esc_html__( 'Navigation', 'ff-associate' ),
				'section'           => 'ff_associate_ss_slider',
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Associate_Toggle_Switch_Custom_control',
				'settings'          => 'ff_associate_slider_pagination',
				'sanitize_callback' => 'ff_associate_switch_sanitization',
				'label'             => esc_html__( 'Pagination', 'ff-associate' ),
				'section'           => 'ff_associate_ss_slider',
				'active_callback'   => array( $this, 'is_slider_visible' ),
			)
		);
	}

	/**
	 * Slider visibility active callback.
	 */
	public function is_slider_visible( $control ) {
		return ( ff_associate_display_section( $control->manager->get_setting( 'ff_associate_slider_visibility' )->value() ) );
	}

	/**
	 * Slider autoplay check.
	 */
	public function is_slider_autoplay_on( $control ) {
		return ( $this->is_slider_visible( $control ) && $control->manager->get_setting( 'ff_associate_slider_autoplay' )->value() );
	}
}

/**
 * Initialize class
 */
$slider_ss_slider = new FF_Associate_Slider_Options();

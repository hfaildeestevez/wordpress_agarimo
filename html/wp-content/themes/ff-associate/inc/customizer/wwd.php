<?php
/**
 * WWD Options
 *
 * @package FF Associate
 */

class FF_Associate_WWD_Options {
	public function __construct() {
		// Register WWD Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'ff_associate_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'ff_associate_wwd_visibility'   => 'disabled',
			'ff_associate_wwd_number'       => 6,
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
				'settings'          => 'ff_associate_wwd_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'ff_associate_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'ff-associate' ),
				'section'           => 'ff_associate_ss_wwd',
				'choices'           => FF_Associate_Customizer_Utilities::section_visibility(),
			)
		);

		// Add Edit Shortcut Icon.
		$wp_customize->selective_refresh->add_partial( 'ff_associate_wwd_visibility', array(
			'selector' => '#wwd-section',
		) );

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'settings'          => 'ff_associate_wwd_section_top_subtitle',
				'label'             => esc_html__( 'Section Top Sub-title', 'ff-associate' ),
				'section'           => 'ff_associate_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_wwd_section_title',
				'type'              => 'text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'label'             => esc_html__( 'Section Title', 'ff-associate' ),
				'section'           => 'ff_associate_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_wwd_section_subtitle',
				'type'              => 'text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'label'             => esc_html__( 'Section Subtitle', 'ff-associate' ),
				'section'           => 'ff_associate_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_wwd_number',
				'type'              => 'number',
				'label'             => esc_html__( 'Number', 'ff-associate' ),
				'description'       => esc_html__( 'Please refresh the customizer page once the number is changed.', 'ff-associate' ),
				'section'           => 'ff_associate_ss_wwd',
				'sanitize_callback' => 'absint',
				'input_attrs'       => array(
					'min'   => 1,
					'max'   => 80,
					'step'  => 1,
					'style' => 'width:100px;',
				),
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Associate_Simple_Notice_Custom_Control',
				'sanitize_callback' => 'sanitize_text_field',
				'settings'          => 'ff_associate_wwd_icon_note',
				'label'             =>  esc_html__( 'Info', 'ff-associate' ),
				/* translators: 1: Link Start html, 2: Link end html. */
				'description'       =>  sprintf( esc_html__( 'If you want camera icon, save "fas fa-camera". For more classes, check %1$sthis%2$s', 'ff-associate' ), '<a href="' . esc_url( 'https://fontawesome.com/icons?d=gallery&m=free' ) . '" target="_blank">', '</a>' ),
				'section'           => 'ff_associate_ss_wwd',
				'active_callback'   => array( $this, 'is_wwd_visible' ),
			)
		);

		$numbers = ff_associate_gtm( 'ff_associate_wwd_number' );

		for( $i = 0, $j = 1; $i < $numbers; $i++, $j++ ) {
			FF_Associate_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'FF_Associate_Simple_Notice_Custom_Control',
					'sanitize_callback' => 'ff_associate_text_sanitization',
					'settings'          => 'ff_associate_wwd_notice_' . $i,
					'label'             => esc_html__( 'Item #', 'ff-associate' )  . $j,
					'section'           => 'ff_associate_ss_wwd',
					'active_callback'   => array( $this, 'is_wwd_visible' ),
				)
			);

			FF_Associate_Customizer_Utilities::register_option(
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'settings'          => 'ff_associate_wwd_custom_icon_' . $i,
					'label'             => esc_html__( 'Icon Class', 'ff-associate' ),
					'section'           => 'ff_associate_ss_wwd',
					'active_callback'   => array( $this, 'is_wwd_visible' ),
				)
			);

			FF_Associate_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'FF_Associate_Dropdown_Posts_Custom_Control',
					'sanitize_callback' => 'absint',
					'settings'          => 'ff_associate_wwd_page_' . $i,
					'label'             => esc_html__( 'Select Page', 'ff-associate' ),
					'section'           => 'ff_associate_ss_wwd',
					'active_callback'   => array( $this, 'is_wwd_visible' ),
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
	 * WWD visibility active callback.
	 */
	public function is_wwd_visible( $control ) {
		return ( ff_associate_display_section( $control->manager->get_setting( 'ff_associate_wwd_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$ff_associate_ss_wwd = new FF_Associate_WWD_Options();

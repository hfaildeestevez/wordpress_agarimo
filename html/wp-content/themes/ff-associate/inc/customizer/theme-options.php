<?php
/**
 * Adds the theme options sections, settings, and controls to the theme customizer
 *
 * @package FF Associate
 */

class FF_Associate_Theme_Options {
	public function __construct() {
		// Register our Panel.
		add_action( 'customize_register', array( $this, 'add_panel' ) );

		// Register Breadcrumb Options.
		add_action( 'customize_register', array( $this, 'register_breadcrumb_options' ) );

		// Register Excerpt Options.
		add_action( 'customize_register', array( $this, 'register_excerpt_options' ) );

		// Register Homepage Options.
		add_action( 'customize_register', array( $this, 'register_homepage_options' ) );

		// Register Layout Options.
		add_action( 'customize_register', array( $this, 'register_layout_options' ) );

		// Register Search Options.
		add_action( 'customize_register', array( $this, 'register_search_options' ) );

		// Add default options.
		add_filter( 'ff_associate_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			// Header Media.
			'ff_associate_header_image_visibility' => 'entire-site',

			// Breadcrumb
			'ff_associate_breadcrumb_show' => 1,

			// Layout Options.
			'ff_associate_default_layout'          => 'right-sidebar',
			'ff_associate_homepage_archive_layout' => 'no-sidebar-full-width',

			// Excerpt Options
			'ff_associate_excerpt_length'    => 30,
			'ff_associate_excerpt_more_text' => esc_html__( 'Continue reading', 'ff-associate' ),

			// Footer Options.
			'ff_associate_footer_editor_style'      => 'one-column',
			'ff_associate_footer_editor_text'       => sprintf( _x( 'Copyright &copy; %1$s %2$s. All Rights Reserved. %3$s', '1: Year, 2: Site Title with home URL, 3: Privacy Policy Link', 'ff-associate' ), '[the-year]', '[site-link]', '[privacy-policy-link]' ) . ' &#124; ' . esc_html__( 'FF Associate by', 'ff-associate' ). '&nbsp;<a target="_blank" href="'. esc_url( 'https://fireflythemes.com' ) .'">Firefly Themes</a>',
			'ff_associate_footer_editor_text_left'  => sprintf( _x( 'Copyright &copy; %1$s %2$s. All Rights Reserved. %3$s', '1: Year, 2: Site Title with home URL, 3: Privacy Policy Link', 'ff-associate' ), '[the-year]', '[site-link]', '[privacy-policy-link]' ),
			'ff_associate_footer_editor_text_right' => esc_html__( 'FF Associate by', 'ff-associate' ). '&nbsp;<a target="_blank" href="'. esc_url( 'https://fireflythemes.com' ) .'">Firefly Themes</a>',

			// Homepage/Frontpage Options.
			'ff_associate_front_page_category'   => '',
			'ff_associate_show_homepage_content' => 1,

			// Search Options.
			'ff_associate_search_text'         => esc_html__( 'Search...', 'ff-associate' ),
		);


		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Register the Customizer panels
	 */
	public function add_panel( $wp_customize ) {
		/**
		 * Add our Header & Navigation Panel
		 */
		 $wp_customize->add_panel( 'ff_associate_theme_options',
		 	array(
				'title' => esc_html__( 'Theme Options', 'ff-associate' ),
			)
		);
	}

	/**
	 * Add breadcrumb section and its controls
	 */
	public function register_breadcrumb_options( $wp_customize ) {
		// Add Excerpt Options section.
		$wp_customize->add_section( 'ff_associate_breadcrumb_options',
			array(
				'title' => esc_html__( 'Breadcrumb', 'ff-associate' ),
				'panel' => 'ff_associate_theme_options',
			)
		);

		if ( function_exists( 'bcn_display' ) ) {
			FF_Associate_Customizer_Utilities::register_option(
				array(
					'custom_control'    => 'FF_Associate_Simple_Notice_Custom_Control',
					'sanitize_callback' => 'sanitize_text_field',
					'settings'          => 'ff_multiputpose_breadcrumb_plugin_notice',
					'label'             =>  esc_html__( 'Info', 'ff-associate' ),
					'description'       =>  sprintf( esc_html__( 'Since Breadcrumb NavXT Plugin is installed, edit plugin\'s settings %1$shere%2$s', 'ff-associate' ), '<a href="' . esc_url( get_admin_url( null, 'options-general.php?page=breadcrumb-navxt' ) ) . '" target="_blank">', '</a>' ),
					'section'           => 'ff_multiputpose_breadcrumb_options',
				)
			);

			return;
		}

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Associate_Toggle_Switch_Custom_control',
				'settings'          => 'ff_associate_breadcrumb_show',
				'sanitize_callback' => 'ff_associate_switch_sanitization',
				'label'             => esc_html__( 'Display Breadcrumb?', 'ff-associate' ),
				'section'           => 'ff_associate_breadcrumb_options',
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Associate_Toggle_Switch_Custom_control',
				'settings'          => 'ff_associate_breadcrumb_show_home',
				'sanitize_callback' => 'ff_associate_switch_sanitization',
				'label'             => esc_html__( 'Show on homepage?', 'ff-associate' ),
				'section'           => 'ff_associate_breadcrumb_options',
			)
		);
	}

	/**
	 * Add layouts section and its controls
	 */
	public function register_layout_options( $wp_customize ) {
		// Add layouts section.
		$wp_customize->add_section( 'ff_associate_layouts',
			array(
				'title' => esc_html__( 'Layouts', 'ff-associate' ),
				'panel' => 'ff_associate_theme_options'
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'select',
				'settings'          => 'ff_associate_default_layout',
				'sanitize_callback' => 'ff_associate_sanitize_select',
				'label'             => esc_html__( 'Default Layout', 'ff-associate' ),
				'section'           => 'ff_associate_layouts',
				'choices'           => array(
					'right-sidebar'         => esc_html__( 'Right Sidebar', 'ff-associate' ),
					'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'ff-associate' ),
				),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'select',
				'settings'          => 'ff_associate_homepage_archive_layout',
				'sanitize_callback' => 'ff_associate_sanitize_select',
				'label'             => esc_html__( 'Homepage/Archive Layout', 'ff-associate' ),
				'section'           => 'ff_associate_layouts',
				'choices'           => array(
					'right-sidebar'         => esc_html__( 'Right Sidebar', 'ff-associate' ),
					'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'ff-associate' ),
				),
			)
		);
	}

	/**
	 * Add excerpt section and its controls
	 */
	public function register_excerpt_options( $wp_customize ) {
		// Add Excerpt Options section.
		$wp_customize->add_section( 'ff_associate_excerpt_options',
			array(
				'title' => esc_html__( 'Excerpt Options', 'ff-associate' ),
				'panel' => 'ff_associate_theme_options',
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'number',
				'settings'          => 'ff_associate_excerpt_length',
				'sanitize_callback' => 'absint',
				'label'             => esc_html__( 'Excerpt Length (Words)', 'ff-associate' ),
				'section'           => 'ff_associate_excerpt_options',
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'type'              => 'text',
				'settings'          => 'ff_associate_excerpt_more_text',
				'sanitize_callback' => 'sanitize_text_field',
				'label'             => esc_html__( 'Excerpt More Text', 'ff-associate' ),
				'section'           => 'ff_associate_excerpt_options',
			)
		);
	}

	/**
	 * Add Homepage/Frontpage section and its controls
	 */
	public function register_homepage_options( $wp_customize ) {
		FF_Associate_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Associate_Dropdown_Select2_Custom_Control',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'settings'          => 'ff_associate_front_page_category',
				'description'       => esc_html__( 'Filter Homepage/Blog page posts by following categories', 'ff-associate' ),
				'label'             => esc_html__( 'Categories', 'ff-associate' ),
				'section'           => 'static_front_page',
				'input_attrs'       => array(
					'multiselect' => true,
				),
				'choices'           => array( esc_html__( '--Select--', 'ff-associate' ) => FF_Associate_Customizer_Utilities::get_terms( 'category' ) ),
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'FF_Associate_Toggle_Switch_Custom_control',
				'settings'          => 'ff_associate_show_homepage_content',
				'sanitize_callback' => 'ff_associate_switch_sanitization',
				'label'             => esc_html__( 'Show Home Content/Blog', 'ff-associate' ),
				'section'           => 'static_front_page',
			)
		);
	}

	/**
	 * Add Homepage/Frontpage section and its controls
	 */
	public function register_search_options( $wp_customize ) {
		// Add Homepage/Frontpage Section.
		$wp_customize->add_section( 'ff_associate_search',
			array(
				'title' => esc_html__( 'Search', 'ff-associate' ),
				'panel' => 'ff_associate_theme_options',
			)
		);

		FF_Associate_Customizer_Utilities::register_option(
			array(
				'settings'          => 'ff_associate_search_text',
				'sanitize_callback' => 'ff_associate_text_sanitization',
				'label'             => esc_html__( 'Search Text', 'ff-associate' ),
				'section'           => 'ff_associate_search',
				'type'              => 'text',
			)
		);
	}
}

/**
 * Initialize class
 */
$ff_associate_theme_options = new FF_Associate_Theme_Options();

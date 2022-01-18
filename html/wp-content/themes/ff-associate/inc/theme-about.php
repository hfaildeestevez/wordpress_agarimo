<?php
/**
 * Adds Theme page
 *
 * @package JetBlack
 */

function ff_associate_about_admin_style( $hook ) {
	if ( 'appearance_page_ff-associate-about' === $hook ) {
		wp_enqueue_style( 'ff-associate-theme-about', get_theme_file_uri( 'css/theme-about.css' ), null, '1.0' );
	}
}
add_action( 'admin_enqueue_scripts', 'ff_associate_about_admin_style' );

/**
 * Add theme page
 */
function ff_associate_menu() {
	add_theme_page( esc_html__( 'About Theme', 'ff-associate' ), esc_html__( 'About Theme', 'ff-associate' ), 'edit_theme_options', 'ff-associate-about', 'ff_associate_about_display' );
}
add_action( 'admin_menu', 'ff_associate_menu' );

/**
 * Display About page
 */
function ff_associate_about_display() {
	$theme = wp_get_theme();
	?>
	<div class="wrap about-wrap full-width-layout">
		<h1><?php echo esc_html( $theme ); ?></h1>
		<div class="about-theme">
			<div class="theme-description">
				<p class="about-text">
					<?php
					// Remove last sentence of description.
					$description = explode( '. ', $theme->get( 'Description' ) );

					array_pop( $description );

					$description = implode( '. ', $description );

					echo esc_html( $description . '.' );
				?></p>
				<p class="actions">
					<a href="https://fireflythemes.com/themes/ff-associate" class="button button-secondary" target="_blank"><?php esc_html_e( 'Info', 'ff-associate' ); ?></a>

					<a href="https://fireflythemes.com/documentation/ff-associate/" class="button button-primary" target="_blank"><?php esc_html_e( 'Documentation', 'ff-associate' ); ?></a>

					<a href="https://demo.fireflythemes.com/ff-associate" class="button button-primary green" target="_blank"><?php esc_html_e( 'Demo', 'ff-associate' ); ?></a>

					<a href="https://fireflythemes.com/support" class="button button-secondary" target="_blank"><?php esc_html_e( 'Support', 'ff-associate' ); ?></a>
				</p>
			</div>

			<div class="theme-screenshot">
				<img src="<?php echo esc_url( $theme->get_screenshot() ); ?>" />
			</div>

		</div>

		<nav class="nav-tab-wrapper wp-clearfix" aria-label="<?php esc_attr_e( 'Secondary menu', 'ff-associate' ); ?>">
			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ff-associate-about' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['page'] ) && 'ff-associate-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'About', 'ff-associate' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'ff-associate-about', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['tab'] ) && 'changelog' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'Changelog', 'ff-associate' ); ?></a>
		</nav>

		<?php ff_associate_main_screen(); ?>

		<div class="return-to-dashboard">
			<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
				<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
					<?php is_multisite() ? esc_html_e( 'Return to Updates', 'ff-associate' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'ff-associate' ); ?>
				</a> |
			<?php endif; ?>
			<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'ff-associate' ) : esc_html_e( 'Go to Dashboard', 'ff-associate' ); ?></a>
		</div>
	</div>
	<?php
}

/**
 * Output the main about screen.
 */
function ff_associate_main_screen() {
	if ( isset( $_GET['page'] ) && 'ff-associate-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) {
	?>
		<div class="feature-section two-col">
			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Theme Customizer', 'ff-associate' ); ?></h2>
				<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'ff-associate' ) ?></p>
				<p><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize', 'ff-associate' ); ?></a></p>
			</div>

			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Got theme support question?', 'ff-associate' ); ?></h2>
				<p><?php esc_html_e( 'Get genuine support from genuine people. Whether it\'s customization or compatibility, our seasoned developers deliver tailored solutions to your queries.', 'ff-associate' ) ?></p>
				<p><a href="https://fireflythemes.com/support" class="button button-primary"><?php esc_html_e( 'Support Forum', 'ff-associate' ); ?></a></p>
			</div>
		</div>
	<?php
	}
}

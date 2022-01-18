<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package FF Associate
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses ff_associate_header_style()
 */
function ff_associate_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'ff_associate_custom_header_args', array(
		'default-image'      => get_parent_theme_file_uri( '/images/header-image.jpg' ),
		'default-text-color' => 'ececec',
		'width'              => 1920,
		'height'             => 1080,
		'flex-height'        => true,
		'wp-head-callback'   => 'ff_associate_header_style',
		'video'              => true,
	) ) );

	$header_images = array(
	    'default' => array(
	            'url'           => get_parent_theme_file_uri( '/images/header-image.jpg' ),
	            'thumbnail_url' => get_parent_theme_file_uri( '/images/header-image-275x155.jpg' ),
	    ),
	);
	register_default_headers( $header_images );
}
add_action( 'after_setup_theme', 'ff_associate_custom_header_setup' );



if ( ! function_exists( 'ff_associate_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see ff_associate_custom_header_setup().
	 */
	function ff_associate_header_style() {
		$header_image = get_header_image();

		if ( $header_image ) : ?>
			<style type="text/css" rel="header-image">
				#custom-header {
					background-image: url( <?php echo esc_url( $header_image ); ?>);
				}
			</style>
		<?php
		endif;
		
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
		// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

if ( ! function_exists( 'ff_associate_header_title' ) ) :
	/**
	 * Return main header title.
	 */
	function ff_associate_header_title() {
		if ( ! is_singular() && is_front_page() ) {
			?>
			<h2 class="page-title"><?php bloginfo( 'name' ); ?></h2>
			
			<?php
			$ff_associate_description = get_bloginfo( 'description', 'display' );
			if ( $ff_associate_description || is_customize_preview() ) : ?>
				<p class="site-description-inner"><?php echo esc_html( $ff_associate_description ); ?></p>
			<?php endif;
		} elseif ( is_singular() ) {
			the_title( '<h1 class="page-title">', '</h1>' );
			
			if ( is_single() ) : 
			?>
			<div class="entry-meta">
				<?php ff_associate_entry_header(); ?>
			</div>
			<?php
			endif;
		} elseif ( ! is_front_page() && is_home() ) {
			?>
			<h1 class="page-title"><?php echo esc_html( get_the_title( get_option('page_for_posts', true) ) ); ?></h1>
			<?php
		} elseif ( is_404() ) {
			?>
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'ff-associate' ); ?></h1>
			<?php
		} elseif ( is_search() ) {
			?>
			<h1 class="page-title">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'ff-associate' ), '<span>' . get_search_query() . '</span>' );
				?>
			</h1>
			<?php
		} elseif ( class_exists( 'WooCommerce' ) && is_shop() ) { 
			$shop_title = ff_associate_gtm( 'ff_associate_shop_page_title' );
			$shop_description = ff_associate_gtm( 'ff_associate_shop_page_description' );
			
			if ( $shop_title ) {
				echo '<h1 class="page-title">';
				echo esc_html( $shop_title );
				echo '</h1>';
			}

			if ( $shop_description ) {
				echo '<div class="archive-description">';
				echo esc_html( $shop_description );
				echo '</div>';
			}
		} else {
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
		}
	} // ff_associate_header_title.
endif;

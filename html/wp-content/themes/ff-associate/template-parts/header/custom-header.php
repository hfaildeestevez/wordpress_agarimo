<?php
/**
 * Displays header site branding
 *
 * @package FF Associate
 */

$ff_associate_enable = ff_associate_gtm( 'ff_associate_header_image_visibility' );

if ( ff_associate_display_section( $ff_associate_enable ) ) : ?>
<div id="custom-header">
	<?php is_header_video_active() && has_header_video() ? the_custom_header_markup() : ''; ?>

	<div class="custom-header-content">
		<div class="container">
			<?php ff_associate_header_title(); ?>
		</div> <!-- .container -->
	</div>  <!-- .custom-header-content -->
</div>
<?php
endif;

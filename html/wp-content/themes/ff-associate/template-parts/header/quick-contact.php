<?php
/**
 * Header Search
 *
 * @package FF Associate
 */

$ff_associate_phone      = ff_associate_gtm( 'ff_associate_header_phone' );
$ff_associate_email      = ff_associate_gtm( 'ff_associate_header_email' );
$ff_associate_address    = ff_associate_gtm( 'ff_associate_header_address' );
$ff_associate_open_hours = ff_associate_gtm( 'ff_associate_header_open_hours' );

if ( $ff_associate_phone || $ff_associate_email || $ff_associate_address || $ff_associate_open_hours ) : ?>
	<div class="inner-quick-contact">
		<ul>
			<?php if ( $ff_associate_phone ) : ?>
				<li class="quick-call">
					<span><?php esc_html_e( 'Phone', 'ff-associate' ); ?></span><a href="tel:<?php echo preg_replace( '/\s+/', '', esc_attr( $ff_associate_phone ) ); ?>"><?php echo esc_html( $ff_associate_phone ); ?></a> </li>
			<?php endif; ?>

			<?php if ( $ff_associate_email ) : ?>
				<li class="quick-email"><span><?php esc_html_e( 'Email', 'ff-associate' ); ?></span><a href="<?php echo esc_url( 'mailto:' . esc_attr( antispambot( $ff_associate_email ) ) ); ?>"><?php echo esc_html( antispambot( $ff_associate_email ) ); ?></a> </li>
			<?php endif; ?>

			<?php if ( $ff_associate_address ) : ?>
				<li class="quick-address"><span><?php esc_html_e( 'Address', 'ff-associate' ); ?></span><?php echo esc_html( $ff_associate_address ); ?></li>
			<?php endif; ?>

			<?php if ( $ff_associate_open_hours ) : ?>
				<li class="quick-open-hours"><span><?php esc_html_e( 'Open Hours', 'ff-associate' ); ?></span><?php echo esc_html( $ff_associate_open_hours ); ?></li>
			<?php endif; ?>
		</ul>
	</div><!-- .inner-quick-contact -->
<?php endif; ?>


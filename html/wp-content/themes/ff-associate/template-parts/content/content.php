<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF Associate
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'grid-item' ); ?>>
	<div class="hentry-inner">
		<div class="post-thumbnail">
			<?php ff_associate_post_thumbnail(); ?>
			
			<?php ff_associate_posted_cats(); ?>
		</div><!-- .post-thumbnail -->

		<div class="entry-container">
			<header class="entry-header">
				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;
				?>
			</header><!-- .entry-header -->

			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php ff_associate_entry_header(); ?>
				</div>
			<?php endif; ?>

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>
		</div><!-- .entry-container -->
	</div><!-- .hentry-inner -->
</article><!-- #post-<?php the_ID(); ?> -->

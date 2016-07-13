<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package maketador
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div>
		<?php the_post_thumbnail( 'maketador_featured', array( 'class'=>'img-responsive') ); ?>
	</div>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php maketador_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php maketador_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

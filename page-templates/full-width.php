<?php
/**
 * Template Name: Full Width
 * @package maketador
 */

get_header(); ?>
	<div id="primary" class="content-area <?php echo Maketador_Customizer::options( 'full_width_class' )  ?>">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main>
	</div>

<?php
get_footer();

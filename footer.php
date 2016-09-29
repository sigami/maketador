<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package maketador
 */
?>
	</div><?php //#content ?>
	<?php echo is_page_template( 'page-templates/fluid-row.php' ) ? '' : '</div>'; //.container ?>
<?php
if(  ! Maketador_Customizer::hide_footer() ): ?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<?php if ( is_active_sidebar( 'sidebar-footer' ) ): ?>
				<div class="row">
					<div class="col-sm-12">
						<?php dynamic_sidebar( 'sidebar-footer' ); ?>
					</div>
				</div>
			<?php endif; ?>
			<?php echo apply_filters( 'maketador_footer_text', Maketador_Customizer::options( 'footer_text' ) ) ?>
		</div>
	</footer>
<?php endif; ?>
</div><?php //.site ?>
<?php wp_footer(); ?>
</body>
</html>

<?php
/**
 * Jetpack Compatibility Class.
 *
 * @link https://jetpack.com/
 *
 * @package maketador
 */
class Maketador_Jetpack{
	static function hooks(){
		/** @see Maketador_JetPack::after_setup_theme */
		add_action( 'after_setup_theme', __CLASS__.'::after_setup_theme' );
	}
	/**
	 * Jetpack setup function.
	 *
	 * See: https://jetpack.com/support/infinite-scroll/
	 * See: https://jetpack.com/support/responsive-videos/
	 */
	static function after_setup_theme(){
		// Add theme support for Infinite Scroll.
		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => __CLASS__.'::infinite_scroll_render',
			'footer'    => 'page',
			'footer_callback' => __CLASS__.'::infinite_scroll_footer'
		) );

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );
	}
	/**
	 * Custom render function for Infinite Scroll.
	 */
	static function infinite_scroll_render(){
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) :
				get_template_part( 'template-parts/content', 'search' );
			else :
				get_template_part( 'template-parts/content', get_post_format() );
			endif;
		}
	}
	function infinite_scroll_footer($content){
		?>
		<div id="infinite-footer">
			<div class="container">
				<?php echo apply_filters('maketador_footer_text',Maketador_Customizer::options( 'footer_text' )) ?>
			</div>
		</div>
		<?php
	}
}

<?php

/**
 * Class Name: Maketador_Customizer
 * GitHub URI: https://github.com/sigami/maketador/
 * Description: Handles all customizer options on the SIGAMI Maketador theme it can be replaced on child theme
 * Version: 1.0
 * Author: Miguel Sirvent
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @since Maketador 0.8
 */
class Maketador_Customizer {
	private static $options = null;

	static function hooks() {
		// Setup the Custom Header
		add_action( 'after_setup_theme', __CLASS__ . '::custom_header' );

		// Setup the Theme Customizer settings and controls...
		add_action( 'customize_register', __CLASS__ . '::register' );

		// Output custom CSS to live site
		add_action( 'wp_head', __CLASS__ . '::header_output' );
	}

	/**
	 * This hooks into 'customize_register' (available as of WP 3.4) and allows
	 * you to add new sections and controls to the Theme Customize screen.
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom
	 * javascript. See live_preview() for more.
	 *
	 * @see   add_action('customize_register',$func)
	 *
	 * @param \WP_Customize_Manager $wp_customize
	 *
	 * @link  http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since Maketador 0.8
	 */
	public static function register( $wp_customize ) {

		$sizes = apply_filters( 'maketador_sizes',
			array(
				'1'  => 1,
				'2'  => 2,
				'3'  => 3,
				'4'  => 4,
				'5'  => 5,
				'6'  => 6,
				'7'  => 7,
				'8'  => 8,
				'9'  => 9,
				'10' => 10,
				'11' => 11,
				'12' => 12,
			)
		);

		$wp_customize->add_panel( 'maketador_panel', array(
			'title'       => __( 'Maketador', 'maketador' ),
			'description' => '<p>' . __( 'Theme specific options', 'maketador' ) . '.</p>',
			'priority'    => 1,
		) );

		$wp_customize->add_section( 'header',
			array(
				'panel'       => 'maketador_panel',
				'title'       => __( 'Header', 'maketador' ),
				'priority'    => 1,
				'capability'  => 'edit_theme_options',
				'description' => __( 'Choose header type, colors, etc.', 'maketador' ),
			)
		);

		$wp_customize->add_setting( 'header_type',
			array(
				'default'           => self::get_defaults( 'header_type' ),
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_setting( 'logo',
			array(
				'default'           => self::get_defaults( 'logo' ),
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
			'header_type',
			array(
				'label'    => __( 'Header Type', 'maketador' ),
				'section'  => 'header',
				'settings' => 'header_type',
				'type'     => 'select',
				'choices'  => array(
					'navbar-static-top' => __( 'Static', 'maketador' ),
					'navbar-fixed-top'  => __( 'Fixed', 'maketador' ),
					'normal'            => __( 'Normal', 'maketador' ),
					'normal-affix'      => __( 'Normal then fixed navbar', 'maketador' ),
				),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'logo',
				array(
					'label'    => __( 'Logo Image', 'maketador' ),
					'section'  => 'header',
					'settings' => 'logo',
					'context'  => 'your_setting_context'
				)
			)
		);

		$wp_customize->add_section( 'layout',
			array(
				'panel'       => 'maketador_panel',
				'title'       => __( 'Layout', 'maketador' ),
				'priority'    => 2,
				'capability'  => 'edit_theme_options',
				'description' => __( 'Layout options', 'maketador' ),
			)
		);

		$wp_customize->add_setting( 'layout_type',
			array(
				'default'           => self::get_defaults( 'layout_type' ),
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
			'layout_type',
			array(
				'label'    => __( 'Layout Type', 'maketador' ),
				'section'  => 'layout',
				'settings' => 'layout_type',
				'type'     => 'select',
				'choices'  => array(
					'content-sidebar' => __( 'Content Sidebar', 'maketador' ),
					'sidebar-content' => __( 'Sidebar Content', 'maketador' ),
					'no-sidebar'      => __( 'No Sidebar', 'maketador' ),
				),
			)
		);

		$wp_customize->add_setting( 'content_size',
			array(
				'default'           => self::get_defaults( 'content_size' ),
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);


		$wp_customize->add_control(
			'content_size',
			array(
				'label'    => __( 'Content Size', 'maketador' ),
				'section'  => 'layout',
				'settings' => 'content_size',
				'type'     => 'select',
				'choices'  => $sizes,
			)
		);

		$wp_customize->add_setting( 'sidebar_size',
			array(
				'default'           => self::get_defaults( 'sidebar_size' ),
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
			'sidebar_size',
			array(
				'label'    => __( 'Sidebar Size', 'maketador' ),
				'section'  => 'layout',
				'settings' => 'sidebar_size',
				'type'     => 'select',
				'choices'  => $sizes,
			)
		);

		$wp_customize->add_setting( 'full_width_class',
			array(
				'default'           => self::get_defaults( 'full_width_class' ),
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
			'full_width_class',
			array(
				'label'    => __( 'Full width class', 'maketador' ),
				'section'  => 'layout',
				'settings' => 'full_width_class',
				'type'     => 'text',
			)
		);

		$wp_customize->add_section( 'footer',
			array(
				'panel'       => 'maketador_panel',
				'title'       => __( 'Footer', 'maketador' ),
				'priority'    => 3,
				'capability'  => 'edit_theme_options',
				'description' => __( 'Footer options', 'maketador' ),
			)
		);

		$wp_customize->add_setting( 'footer_text',
			array(
				'default'           => self::get_defaults( 'footer_text' ),
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'sanitize_callback' => 'wp_kses_post'
			)
		);

		$wp_customize->add_control(
			'footer_text',
			array(
				'label'    => __( 'Footer Text', 'maketador' ),
				'section'  => 'footer',
				'settings' => 'footer_text',
				'type'     => 'textarea',

			)
		);

	}

	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 *
	 * Used by hook: 'wp_head'
	 *
	 * @see   add_action('wp_head',$func)
	 * @since Maketador 0.8
	 */
	public static function header_output() {
		ob_start();

		if ( self::options( 'header_type' ) == 'navbar-fixed-top' ) {
			echo 'body{padding-top: 50px;}';
		}

		if ( ! display_header_text() ) {
			echo '#site-title,.site-description{position: absolute;clip: rect(1px, 1px, 1px, 1px);}';
		} else {
			self::generate_css( '#site-title', 'color', 'header_textcolor', '#' );
		}
		$extra_css = apply_filters( 'maketador_header_output', ob_get_clean() );
		if ( ! empty( $extra_css ) ) {
			echo '<style type="text/css">' . $extra_css . '</style>';
		}
		?>
		<?php
	}

	/**
	 * This will generate a line of CSS for use in header output. If the setting
	 * ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @uses  get_theme_mod()
	 *
	 * @param string $selector CSS selector
	 * @param string $style    The name of the CSS *property* to modify
	 * @param string $mod_name The name of the 'theme_mod' option to fetch
	 * @param string $prefix   Optional. Anything that needs to be output before the CSS property
	 * @param string $postfix  Optional. Anything that needs to be output after the CSS property
	 * @param bool   $echo     Optional. Whether to print directly to the page (default: true).
	 *
	 * @return string Returns a single line of CSS with selectors and a property.
	 * @since Maketador 0.8
	 */
	public static function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {
		$return = '';
		$mod    = self::options( $mod_name );
		if ( ! empty( $mod ) && $mod != self::get_defaults( $mod_name ) ) {
			$return = sprintf( '%s{%s:%s;}',
				$selector,
				$style,
				$prefix . $mod . $postfix
			);
			if ( $echo ) {
				echo $return;
			}
		}

		return $return;
	}

	/**
	 * @param string $default Value to search
	 *
	 * @return bool|string|array Default value of theme_mods or false.
	 */
	static function get_defaults( $default = '' ) {
		$defaults = array(
			'header_type'      => 'navbar-static-top',
			'header_textcolor' => '5e5e5e',
			'layout_type'      => 'content-sidebar',
			'logo'             => '',
			'content_size'     => '8',
			'sidebar_size'     => '4',
			'full_width_class' => 'col-sm-10 col-sm-offset-1',
			'footer_text'      => '<div class="row">
	<div class="col-sm-6">
		<a href="' . get_home_url() . '"> ' . get_bloginfo( 'name' ) . ' &copy; ' . date( 'Y' ) . '</a>
	</div>
	<div class="col-sm-6">
		<a href="http://github.com/sigami/maketador">' . __( 'created with maketador theme', 'maketador' ) . '</a>
	</div>
</div>',
		);
		if ( empty( $default ) ) {
			return $defaults;
		} else {
			return isset( $defaults[ $default ] ) ? $defaults[ $default ] : false;
		}

	}

	static function options( $option = '' ) {
		if ( self::$options == null ) {
			foreach ( self::get_defaults() as $default => $value ) {
				self::$options[ $default ] = get_theme_mod( $default, $value );
			}
		}
		if ( empty( $option ) ) {
			return self::$options;
		} else {
			return isset( self::$options[ $option ] ) ? self::$options[ $option ] : get_theme_mod( self::$options[ $option ], false );
		}
	}

	static function custom_header() {
		add_theme_support( 'custom-header', apply_filters( 'maketador_custom_header_args', array(
			'default-image'      => '',
			'default-text-color' => self::get_defaults( 'header_textcolor' ),
			'width'              => 1140,
			'height'             => 250,
			'flex-height'        => true,
		) ) );
		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'maketador_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
	}

	static function primary_div_class() {
		$classes      = self::options( 'full_width_class' );
		$content_size = self::options( 'content_size' );
		$sidebar_size = self::options( 'sidebar_size' );
		$layout       = self::options( 'layout_type' );
		if ( is_active_sidebar( 'sidebar-1' ) && ( $layout !== 'no-sidebar' ) ) {
			$inverse_layout = is_page_template( 'page-templates/inverse-sidebar.php' );
			if ( $inverse_layout ) {
				if ( $layout == 'content-sidebar' ) {
					$classes = "col-sm-$content_size col-sm-push-$sidebar_size";
				} else {
					$classes = "col-sm-$content_size";
				}
			} else {
				if ( $layout == 'sidebar-content' ) {
					$classes = "col-sm-$content_size col-sm-push-$sidebar_size";
				} else {
					$classes = "col-sm-$content_size";
				}
			}
		}


		echo $classes;
	}

	static function secondary_div_class() {
		$content_size   = self::options( 'content_size' );
		$sidebar_size   = self::options( 'sidebar_size' );
		$layout         = self::options( 'layout_type' );
		$inverse_layout = is_page_template( 'page-templates/inverse-sidebar.php' );
		$classes        = "col-sm-$sidebar_size";
		if ( ( $layout == 'sidebar-content' ) && ( ! $inverse_layout ) ) {
			$classes .= " col-sm-pull-$content_size";
		} elseif ( $layout == 'content-sidebar' && $inverse_layout ) {
			$classes .= " col-sm-pull-$content_size";
		}
		echo $classes;
	}

	static function hide_header(){
		if(!is_page())
			return false;
		if(get_post_meta(get_queried_object_id(),'_maketador_hide_header',true) == 'on')
			return true;
		return false;
	}
	static function hide_footer(){
		if(!is_page())
			return false;
		if(get_post_meta(get_queried_object_id(),'_maketador_hide_footer',true) == 'on')
			return true;
		return false;
	}

	static function get_full_width_class($post_id=null){
		if($post_id === null){
			$post_id = get_queried_object_id();
		}
		$full_width_class = get_post_meta($post_id,'_maketador_full_width_class',true);
		if(empty($full_width_class)){
			$full_width_class = self::options( 'full_width_class' );
		}
		return $full_width_class;
	}

}


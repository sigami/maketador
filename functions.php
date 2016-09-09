<?php
/**
 * Main theme class most functions come from underscore.me, also includes all necessary files.
 *
 * It can be overwriten with plugins.
 *
 * Class Sigami_Maketador
 *
 */
class  Sigami_Maketador {
	static function hooks() {
		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 */
		add_action( 'after_setup_theme', __CLASS__ . '::' . 'after_setup_theme' );
		/**
		 * Register widget area.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
		 */
		add_action( 'widgets_init', __CLASS__ . '::' . 'widgets_init' );
		/**
		 * Enqueue scripts and styles.
		 */
		add_filter( 'wp_enqueue_scripts', __CLASS__ . '::' . 'wp_enqueue_scripts' );
		/**
		 * Registers an editor stylesheet for the theme.
		 */
		add_filter( 'admin_init', __CLASS__ . '::' . 'admin_init' );
		/**
		 * Show all image sizes available.
		 */
		add_filter( 'image_size_names_choose', __CLASS__ . '::' . 'image_size_names_choose', 11, 1 );

	}

	static function after_setup_theme() {
		load_theme_textdomain( 'maketador', get_template_directory() . '/languages' );

		/** Add default posts and comments RSS feed links to head. */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/** This theme uses wp_nav_menu() in one location. */
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'maketador' ),
		) );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/**
		 * Enable support for Post Formats.
		 * @link https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats',      // post formats
			array(
				'aside',   // title less blurb
				'gallery', // gallery of images
				'link',    // quick link to other site
				'image',   // an image
				'quote',   // a quick quote
				'status',  // a Facebook like status update
				'video',   // video
				'audio',   // audio
				'chat'     // chat transcript
			)
		);

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @global int $content_width
		 */
		$GLOBALS['content_width'] = apply_filters( 'maketador_content_width', 900 );

		/*
		 * Custom image sized added by maketador
		 */
		add_image_size( 'maketador_featured', 880, 430, true );
		add_image_size( 'maketador_banner', 1200, 500, true );
	}

	static function widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'maketador' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'maketador' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer Sidebar', 'maketador' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Add widgets here.', 'maketador' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}

	static function wp_enqueue_scripts() {
		wp_enqueue_style( 'maketador-style', get_stylesheet_directory_uri() . '/dist/css/main.min.css' );

		wp_enqueue_script( 'maketador-script', get_stylesheet_directory_uri() . '/dist/js/main.min.js', array( 'jquery' ), '1.0' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	static function admin_init() {
		add_editor_style( get_stylesheet_directory_uri().'/dist/css/main.min.css' );
	}

	static function image_size_names_choose( $sizes ) {
		$new_sizes   = array();
		$added_sizes = get_intermediate_image_sizes();
		foreach ( $added_sizes as $key => $value ) {
			$new_sizes[ $value ] = ucwords( str_replace( array( '_', '-' ), array( ' ' ), $value ) );
		}
		$new_sizes = array_merge( $new_sizes, $sizes );

		return $new_sizes;
	}
}
/**
 * Include all theme files with child theme support.
 *
 * Custom functions that act independently of the theme templates.
 * Load Jetpack compatibility file.
 * Bootstrap support.
 * Custom template tags for this theme.
 * Customizer additions.
 * Navbar Walker.
 * Bootstrap Pagination support.
 */
$includes = array(
'/inc/extras.php',
'/inc/maketador_bootstrap.php',
'/inc/maketador_customizer.php',
'/inc/maketador_jetpack.php',
'/inc/template-tags.php',
'/inc/wp-bootstrap-navwalker.php',
'/inc/wp_bootstrap_pagination.php',
);
foreach ( $includes as $include ) {
	/** @noinspection PhpIncludeInspection */
	require( locate_template( $include ) );
}
/** @noinspection PhpIncludeInspection */
require(locate_template('inc/updater.php'));

new ThemeUpdateChecker(
    'maketador', //Theme slug. Usually the same as the name of its directory.
    'https://draoomedia.com/update-api/?action=get_metadata&slug=maketador&site_installed=https://sigami.net/' //Metadata URL.
);

Sigami_Maketador::hooks();
Maketador_Jetpack::hooks();
Maketador_Bootstrap::hooks();
Maketador_Customizer::hooks();
wp_boostrap_pagination::hooks();



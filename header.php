<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package maketador
 */
$pingback = trim( get_bloginfo( 'pingback_url', 'display' ) );
$header_type      = Maketador_Customizer::options( 'header_type' );
$is_normal_header = ( $header_type == 'normal' ) || ( $header_type == 'normal-affix' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( !empty($pingback) ) : ?>
			<link rel="pingback" href="<?php echo $pingback ?>"><?php endif; ?>
		<?php wp_head(); ?>
	</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'maketador' ); ?></a>
	<header id="masthead" class="site-header" role="banner">
		<?php
		if(  ! Maketador_Customizer::hide_header() ){
			if ( $is_normal_header ) {
				get_template_part( 'template-parts/header', 'normal' );
			} else {
				get_template_part( 'template-parts/header', 'navbar' );
			}
		}
		?>
	</header>
<?php if ( is_page_template( 'page-templates/fluid-row.php' ) ): ?>
	<div id="content" class="site-content row-fluid">
<?php else : ?>
	<div class="container">
	<div id="content" class="site-content row">
<?php endif; ?>
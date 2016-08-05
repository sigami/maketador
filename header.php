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
$description      = get_bloginfo( 'description', 'display' );
$header_type      = Maketador_Customizer::options( 'header_type' );
$header_logo      = Maketador_Customizer::options( 'logo' );
$pingback_url     = trim( get_bloginfo( 'pingback_url' ) );
$is_normal_header = ( $header_type == 'normal' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( ! empty( $pingback_url ) ) : ?><link rel="pingback" href="<?php echo $pingback_url ?>"><?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'maketador' ); ?></a>
	<header id="masthead" class="site-header" role="banner">

		<?php if ( $is_normal_header || $header_type == 'normal-affix' ): ?>
			<div id="normal-header" class="container">
				<br>

				<div class="row">
					<div
						class="site-branding <?php echo empty( $header_logo ) ? '' : 'sr-only' ?> <?php echo ( get_header_image() === false ) ? 'col-sm-12' : 'col-sm-4' ?>">
						<a id="site-title" class="brand h1" title="<?php echo $description ?>"
						   href="<?php echo home_url(); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
						<?php if ( $description || is_customize_preview() ) : ?>
							<p class="site-description"><?php echo $description ?></p>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $header_logo ) ) : ?>
						<div class="col-sm-4">
							<a title="<?php bloginfo( 'name' ); ?>"
							   href="<?php echo home_url(); ?>" rel="home">
								<img class="img-responsive" src="<?php echo $header_logo ?>"
								     alt="<?php bloginfo( 'name' ); ?>"></a><br>
						</div>
					<?php endif; ?>
					<?php if ( get_header_image() !== false ) : ?>
						<div class="col-sm-7 col-sm-offset-1">
							<img class="img-responsive" src="<?php header_image(); ?>" alt=""><br>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php echo ( $is_normal_header ) ? '<div class="container">' : '' ?>
		<nav <?php echo $header_type == 'normal-affix' ? 'id="fixed-nav"' : '' ?> class="navbar navbar-default <?php echo $is_normal_header ? '' : $header_type == 'normal-affix' ? 'navbar-static-top' : $header_type ?>">
			<?php echo ( ! $is_normal_header ) ? '<div class="container">' : '' ?>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
				        data-target="#maketador_navbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php if ( ! $is_normal_header && $header_type != 'normal-affix' ): ?>
					<?php if ( ! empty( $header_logo ) ) : ?>
						<a class="navbar-brand" title="<?php echo $description ?>"
						   href="<?php echo home_url(); ?>" rel="home">
							<img class="img-responsive" src="<?php echo $header_logo ?>" alt="">
						</a>
					<?php else : ?>
						<div class="site-branding <?php echo empty( $header_logo ) ? '' : 'sr-only' ?>">
							<a id="site-title" class="navbar-brand" title="<?php echo $description ?>"
							   href="<?php echo home_url(); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<?php
			wp_nav_menu( array(
					'menu'            => 'primary',
					'theme_location'  => 'primary',
					'depth'           => 2,
					'container'       => 'div',
					'container_class' => 'collapse navbar-collapse',
					'container_id'    => 'maketador_navbar',
					'menu_class'      => 'nav navbar-nav',
					'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
					'walker'          => new wp_bootstrap_navwalker()
				)
			);
			?>
			<?php echo ! $is_normal_header ? '</div>' : '' //.container ?>
		</nav>

		<?php echo $is_normal_header ? '</div>' : '' //.container?>
		<?php if ( ! $is_normal_header && $header_type != 'normal-affix' && get_header_image() && ( is_front_page() || is_singular( 'post' ) ) ) : ?>
			<aside class="container">
				<div class="row">
					<div class="col-sm-12">
						<img class="img-responsive" src="<?php header_image(); ?>" alt=""><br>
					</div>
				</div>
			</aside>
		<?php endif; // End header image check. ?>
	</header>
	<?php echo is_page_template( 'page-templates/blank-no-container.php' ) ? '' : '<div class="container">'; ?>
	<div id="content" class="site-content row<?php echo is_page_template( 'page-templates/blank-no-container.php' ) ? '-fluid' : ''; ?>">
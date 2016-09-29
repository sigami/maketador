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
$description = get_bloginfo( 'description', 'display' );
$header_type = Maketador_Customizer::options( 'header_type' );
$header_logo = Maketador_Customizer::options( 'logo' );
?>
	<nav class="navbar navbar-default <?php echo $header_type ?>">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#maketador_navbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="site-branding <?php echo empty( $header_logo ) ? '' : 'sr-only' ?>">
					<a id="site-title" class="navbar-brand" title="<?php echo $description ?>"
					   href="<?php echo home_url(); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</div>
				<?php if ( ! empty( $header_logo ) ) : ?>
					<a class="navbar-brand" title="<?php echo $description ?>"
					   href="<?php echo home_url(); ?>" rel="home">
						<img class="img-responsive" src="<?php echo $header_logo ?>" alt="logo">
					</a>
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
		</div>
	</nav>

<?php if ( get_header_image() && ( is_front_page() || is_singular( 'post' ) ) ) : ?>
	<aside class="container">
		<div class="row">
			<div class="col-sm-12">
				<img class="img-responsive" src="<?php header_image(); ?>" alt=""><br>
			</div>
		</div>
	</aside>
<?php endif; // End header image check. ?>
<?php
$description  = get_bloginfo( 'description', 'display' );
$header_type  = Maketador_Customizer::options( 'header_type' );
$header_logo  = Maketador_Customizer::options( 'logo' );
$header_image = get_header_image();
?>
<div id="normal-header">
	<div class="container">
		<br>
		<div class="row">
			<div class="site-branding <?php echo empty( $header_logo ) ? '' : 'sr-only' ?> <?php echo ( $header_image === false ) ? 'col-sm-12' : 'col-sm-4' ?>">
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
			<?php if ( $header_image !== false ) : ?>
				<div class="col-sm-7 col-sm-offset-1">
					<img class="img-responsive" src="<?php echo esc_attr( $header_image ) ?>" alt=""><br>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="container">
	<nav <?php echo $header_type == 'normal-affix' ? 'id="fixed-nav"' : '' ?>
		class="navbar navbar-default <?php echo $header_type == 'normal-affix' ? 'navbar-static-top' : $header_type ?>">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
			        data-target="#maketador_navbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
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
	</nav>
</div>
</header>
<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package xMag
 * @since xMag 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	
<div id="page" class="hfeed site">
	
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'xmag' ); ?></a>
	
	<aside id="mobile-header" class="mobile-header">
		<a class="menu-toggle" id="menu-toggle" href="#" title="<?php esc_attr_e( 'Menu', 'xmag' ); ?>"><span class="button-toggle"></span></a>
		<a class="mobile-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
	</aside>
	<div id="mobile-sidebar" class="mobile-sidebar"> 
		<nav id="mobile-navigation" class="mobile-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Main Menu', 'xmag' ); ?>"></nav>
	</div>

	<header id="masthead" class="site-header" role="banner">
		
		<div class="header-top collapse">
			<div class="container">
				<div class="row">
						<div class="site-branding">
							<?php if ( is_front_page() && is_home() ) : ?>
									<h1 class="site-title text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
								<?php else : ?>
									<p class="site-title text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php endif; ?>
							
							<?php $description = get_bloginfo( 'description', 'display' ); ?>
							<?php if ( $description || is_customize_preview() ) { ?>
									<p class="site-description"><?php echo $description; ?></p>
							<?php } ?>
						</div>
				</div>
			</div>
		</div><!-- .header-top -->
		
		<?php
		// Header image
		if ( get_header_image() ) { xmag_header_image();
		} ?>
		
		<div id="main-navbar" class="main-navbar">
			<div class="container">
				<?php if ( get_theme_mod( 'xmag_home_icon', 1 ) ) : ?>
					<div class="home-link">
	                     <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><span class="icon-home"></span></a>
	                </div>
				<?php endif; // Home icon ?>

				<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Main Menu', 'xmag' ); ?>">
					<?php 
						wp_nav_menu( array( 
							'theme_location' => 'main_navigation', 
							'menu_id' => 'main-menu', 
							'menu_class' => 'main-menu', 
							'container' => false,
							'fallback_cb' => 'xmag_fallback_menu'
							) ); 
						// Main menu
					?>
				</nav>
			</div>
		</div>
	
	</header><!-- .site-header -->
	
	<div id="content" class="site-content">
		<div class="container">
			

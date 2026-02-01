<?php
/**
 * The header for the theme
 *
 * This is the template that displays all of the <head> section and everything up until <main>
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="https://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>

		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'bookstore-theme' ); ?></a>

			<!-- Header Section -->
			<header id="masthead" class="site-header">
				<div class="header-wrapper">
					<!-- Logo and Site Title -->
					<div class="site-branding">
						<?php
						// Custom Logo
						$custom_logo_id = get_theme_mod( 'custom_logo' );
						if ( $custom_logo_id ) {
							echo wp_get_attachment_image( $custom_logo_id, 'medium', false, array(
								'class' => 'site-logo',
							) );
						} else {
							?>
							<h1 class="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php echo esc_html__( 'Bookstore', 'bookstore-theme' ); ?>
								</a>
							</h1>
							<?php
						}

						$blog_description = get_bloginfo( 'description', 'display' );
						if ( $blog_description ) {
							?>
							<p class="site-description"><?php echo wp_kses_post( $blog_description ); ?></p>
							<?php
						}
						?>
					</div>

					<!-- Mobile Menu Toggle -->
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<span class="hamburger-icon">
							<span></span>
							<span></span>
							<span></span>
						</span>
						<?php esc_html_e( 'Menu', 'bookstore-theme' ); ?>
					</button>
				</div>

				<!-- Primary Navigation -->
				<nav id="site-navigation" class="site-navigation">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary-menu',
						'menu_id'        => 'primary-menu',
						'container'      => false,
					'fallback_cb'    => 'bookstore_default_primary_menu',
						'depth'          => 2,
					) );
					?>
				</nav>
			</header>

			<!-- Main Content -->
			<main id="main" class="site-main">

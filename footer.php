<?php
/**
 * The footer for the theme
 *
 * Contains the closing of the "main" div and all content after.
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
			</main>

			<!-- Sidebar -->
			<aside id="secondary" class="widget-area">
				<?php
				if ( is_active_sidebar( 'primary-sidebar' ) ) {
					dynamic_sidebar( 'primary-sidebar' );
				}
				?>
			</aside>

			<!-- Footer -->
			<footer id="colophon" class="site-footer">
				<div class="footer-content">
					<div class="footer-widgets">
						<?php
						if ( is_active_sidebar( 'footer-sidebar-1' ) ) {
							echo '<div class="footer-widget-column">';
							dynamic_sidebar( 'footer-sidebar-1' );
							echo '</div>';
						}

						if ( is_active_sidebar( 'footer-sidebar-2' ) ) {
							echo '<div class="footer-widget-column">';
							dynamic_sidebar( 'footer-sidebar-2' );
							echo '</div>';
						}

						if ( is_active_sidebar( 'footer-sidebar-3' ) ) {
							echo '<div class="footer-widget-column">';
							dynamic_sidebar( 'footer-sidebar-3' );
							echo '</div>';
						}
						?>
					</div>

					<!-- Footer Navigation -->
					<nav id="footer-navigation" class="footer-navigation">
						<?php
						wp_nav_menu( array(
							'theme_location' => 'footer-menu',
							'menu_id'        => 'footer-menu',
							'container'      => false,
							'fallback_cb'    => false,
							'depth'          => 1,
						) );
						?>
					</nav>

					<!-- Footer Credits -->
					<div class="site-info">
						<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
						<p><?php esc_html_e( 'Powered by WordPress', 'bookstore-theme' ); ?> &amp; <strong><?php esc_html_e( 'Bookstore Theme', 'bookstore-theme' ); ?></strong></p>
					</div>
				</div>
			</footer>
		</div>

		<?php wp_footer(); ?>
	</body>
</html>

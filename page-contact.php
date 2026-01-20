<?php
/**
 * Page template for Contact page
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrapper page-contact">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content' ); ?>>
				<header class="page-header">
					<h1 class="page-title"><?php the_title(); ?></h1>
				</header>

				<div class="contact-content">
					<div class="contact-info">
						<?php
						the_content();

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bookstore-theme' ),
							'after'  => '</div>',
						) );
						?>
					</div>

					<?php
					// Display sidebar for contact forms or additional info
					if ( is_active_sidebar( 'primary-sidebar' ) ) {
						echo '<div class="contact-sidebar">';
						dynamic_sidebar( 'primary-sidebar' );
						echo '</div>';
					}
					?>
				</div>
			</article>

			<?php
			// Display comments if enabled
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
	}
	?>
</div>

<?php
get_footer();

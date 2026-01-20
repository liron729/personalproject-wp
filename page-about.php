<?php
/**
 * Page template for About page
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrapper page-about">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content' ); ?>>
				<header class="page-header">
					<h1 class="page-title"><?php the_title(); ?></h1>
				</header>

				<?php
				if ( has_post_thumbnail() ) {
					echo '<div class="page-image">';
					the_post_thumbnail( 'large' );
					echo '</div>';
				}
				?>

				<div class="page-content-text">
					<?php
					the_content();

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bookstore-theme' ),
						'after'  => '</div>',
					) );
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

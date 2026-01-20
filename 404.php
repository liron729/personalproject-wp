<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrapper error-404 not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Oops! That page can\'t be found.', 'bookstore-theme' ); ?></h1>
	</header>

	<div class="page-content">
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'bookstore-theme' ); ?></p>

		<?php get_search_form(); ?>

		<div class="error-404-actions">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
				<?php esc_html_e( 'Go to Homepage', 'bookstore-theme' ); ?>
			</a>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'book' ) ); ?>" class="btn btn-secondary">
				<?php esc_html_e( 'Browse Books', 'bookstore-theme' ); ?>
			</a>
		</div>

		<!-- Recent Books -->
		<div class="recent-items">
			<h3><?php esc_html_e( 'Recent Books', 'bookstore-theme' ); ?></h3>
			<?php
			$recent_books = new WP_Query( array(
				'post_type'      => 'book',
				'posts_per_page' => 3,
				'orderby'        => 'date',
				'order'          => 'DESC',
			) );

			if ( $recent_books->have_posts() ) {
				echo '<ul>';
				while ( $recent_books->have_posts() ) {
					$recent_books->the_post();
					echo '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
				}
				echo '</ul>';
				wp_reset_postdata();
			}
			?>
		</div>
	</div>
</div>

<?php
get_footer();

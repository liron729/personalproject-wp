<?php
/**
 * The template for displaying the book archive
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrapper archive-books">
	<div class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Our Books', 'bookstore-theme' ); ?></h1>
		<p class="archive-description"><?php esc_html_e( 'Browse our complete collection of books.', 'bookstore-theme' ); ?></p>
	</div>

	<?php
	if ( have_posts() ) {
		echo '<div class="books-grid">';

		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/book-card' );
		}

		echo '</div>';

		// Pagination
		the_posts_pagination( array(
			'mid_size'  => 2,
			'prev_text' => esc_html__( 'Previous', 'bookstore-theme' ),
			'next_text' => esc_html__( 'Next', 'bookstore-theme' ),
		) );
	} else {
		?>
		<div class="no-posts-found">
			<h2><?php esc_html_e( 'No Books Found', 'bookstore-theme' ); ?></h2>
			<p><?php esc_html_e( 'Sorry, but there are no books available at the moment.', 'bookstore-theme' ); ?></p>
		</div>
		<?php
	}
	?>
</div>

<?php
get_footer();

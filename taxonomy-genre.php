<?php
/**
 * The template for displaying genre archive pages
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrapper taxonomy-archive">
	<div class="page-header">
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
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
			<h2><?php esc_html_e( 'No Books Found in This Genre', 'bookstore-theme' ); ?></h2>
			<p><?php esc_html_e( 'Sorry, but there are no books available in this genre.', 'bookstore-theme' ); ?></p>
		</div>
		<?php
	}
	?>
</div>

<?php
get_footer();

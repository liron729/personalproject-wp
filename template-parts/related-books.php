<?php
/**
 * Template part for displaying related books
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get current book's genres
$current_book_id = get_the_ID();
$genres          = wp_get_post_terms( $current_book_id, 'genre', array( 'fields' => 'ids' ) );

if ( empty( $genres ) ) {
	return;
}

// Query related books
$related_books = new WP_Query( array(
	'post_type'      => 'book',
	'posts_per_page' => 3,
	'post__not_in'   => array( $current_book_id ),
	'tax_query'      => array(
		array(
			'taxonomy' => 'genre',
			'field'    => 'term_id',
			'terms'    => $genres,
		),
	),
	'orderby'        => 'rand',
) );

if ( $related_books->have_posts() ) {
	?>
	<section class="related-books">
		<h3><?php esc_html_e( 'Related Books', 'bookstore-theme' ); ?></h3>
		<div class="books-grid">
			<?php
			while ( $related_books->have_posts() ) {
				$related_books->the_post();
				get_template_part( 'template-parts/book-card' );
			}
			?>
		</div>
	</section>
	<?php
	wp_reset_postdata();
}

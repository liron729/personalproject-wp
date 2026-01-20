<?php
/**
 * Template part for displaying book card
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'book-card' ); ?>>
	<div class="book-card-inner">
		<?php
		// Display featured image (book cover)
		if ( has_post_thumbnail() ) {
			echo '<div class="book-card-image">';
			echo '<a href="' . esc_url( get_permalink() ) . '">';
			the_post_thumbnail( 'medium' );
			echo '</a>';
			echo '</div>';
		}
		?>

		<div class="book-card-content">
			<h3 class="book-card-title">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php the_title(); ?>
				</a>
			</h3>

			<?php
			// Display authors
			$book_authors = get_the_terms( get_the_ID(), 'author' );
			if ( ! empty( $book_authors ) && ! is_wp_error( $book_authors ) ) {
				echo '<p class="book-authors">';
				foreach ( $book_authors as $author ) {
					echo '<a href="' . esc_url( get_term_link( $author->term_id, 'author' ) ) . '">' . esc_html( $author->name ) . '</a> ';
				}
				echo '</p>';
			}

			// Display excerpt
			if ( has_excerpt() ) {
				echo '<p class="book-excerpt">' . wp_kses_post( get_the_excerpt() ) . '</p>';
			}

			// Display genres
			$book_genres = get_the_terms( get_the_ID(), 'genre' );
			if ( ! empty( $book_genres ) && ! is_wp_error( $book_genres ) ) {
				echo '<div class="book-genres">';
				foreach ( $book_genres as $genre ) {
					echo '<a href="' . esc_url( get_term_link( $genre->term_id, 'genre' ) ) . '" class="genre-badge">' . esc_html( $genre->name ) . '</a> ';
				}
				echo '</div>';
			}
			?>

			<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-small">
				<?php esc_html_e( 'View Details', 'bookstore-theme' ); ?>
			</a>
		</div>
	</div>
</article>

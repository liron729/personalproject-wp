<?php
/**
 * The template for displaying single books
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrapper single-book">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-book-content' ); ?>>
				<div class="book-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</div>

				<div class="book-meta-section">
					<?php
					// Display featured image (book cover)
					if ( has_post_thumbnail() ) {
						echo '<div class="book-cover">';
						the_post_thumbnail( 'large' );
						echo '</div>';
					}
					?>

					<div class="book-info">
						<?php
						// Display book authors
						$book_authors = get_the_terms( get_the_ID(), 'author' );
						if ( ! empty( $book_authors ) && ! is_wp_error( $book_authors ) ) {
							echo '<div class="book-authors">';
							echo '<strong>' . esc_html__( 'Author(s): ', 'bookstore-theme' ) . '</strong>';
							foreach ( $book_authors as $author ) {
								echo '<a href="' . esc_url( get_term_link( $author->term_id, 'author' ) ) . '">' . esc_html( $author->name ) . '</a> ';
							}
							echo '</div>';
						}

						// Display book genres
						$book_genres = get_the_terms( get_the_ID(), 'genre' );
						if ( ! empty( $book_genres ) && ! is_wp_error( $book_genres ) ) {
							echo '<div class="book-genres">';
							echo '<strong>' . esc_html__( 'Genre(s): ', 'bookstore-theme' ) . '</strong>';
							foreach ( $book_genres as $genre ) {
								echo '<a href="' . esc_url( get_term_link( $genre->term_id, 'genre' ) ) . '">' . esc_html( $genre->name ) . '</a> ';
							}
							echo '</div>';
						}

						// Display book format
						$book_formats = get_the_terms( get_the_ID(), 'format' );
						if ( ! empty( $book_formats ) && ! is_wp_error( $book_formats ) ) {
							echo '<div class="book-format">';
							echo '<strong>' . esc_html__( 'Format: ', 'bookstore-theme' ) . '</strong>';
							foreach ( $book_formats as $format ) {
								echo '<span class="format-tag">' . esc_html( $format->name ) . '</span> ';
							}
							echo '</div>';
						}

						// Display publication date (if stored in excerpt or custom field)
						if ( get_the_excerpt() ) {
							echo '<div class="book-description">';
							echo '<strong>' . esc_html__( 'Description: ', 'bookstore-theme' ) . '</strong>';
							echo '<p>' . wp_kses_post( get_the_excerpt() ) . '</p>';
							echo '</div>';
						}
						?>
					</div>
				</div>

				<div class="entry-content">
					<?php
					the_content( sprintf(
						wp_kses(
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'bookstore-theme' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bookstore-theme' ),
						'after'  => '</div>',
					) );
					?>
				</div>
			</article>

			<?php
			// Display comments
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
	}

	// Display related books
	get_template_part( 'template-parts/related-books' );
	?>
</div>

<?php
get_footer();

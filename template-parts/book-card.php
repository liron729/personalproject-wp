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
		// Display featured image (book cover) as a background on the div
		if ( has_post_thumbnail() ) {
			$thumb_url = esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) );
			$thumb_alt = esc_attr( get_the_title() );
			echo '<div class="book-card-image" data-bg="' . $thumb_url . '">';
			echo '<a href="' . esc_url( get_permalink() ) . '">';
			// Provide an accessible fallback image (visually hidden) for screen readers
			echo '<img src="' . $thumb_url . '" alt="' . $thumb_alt . '" class="book-cover-fallback" aria-hidden="true" />';
			echo '</a>';
			echo '</div>';
		} else {
			// Try to find a matching image in the theme's assets/images folder as a fallback
			$found = '';
			$images_dir = get_template_directory() . '/assets/images/';
			if ( is_dir( $images_dir ) ) {
				$files = scandir( $images_dir );
				if ( $files && is_array( $files ) ) {
					// Build title words and remove common stopwords to avoid false matches like "the"
					$raw_title_words = preg_split( '/[^a-z0-9]+/i', strtolower( get_the_title() ) );
					$stopwords = array( 'the', 'a', 'an', 'and', 'of', 'in', 'on', 'for', 'to', 'with', 'by', 'at' );
					$title_words = array();
					foreach ( $raw_title_words as $w ) {
						if ( $w && ! in_array( $w, $stopwords, true ) ) {
							$title_words[] = $w;
						}
					}

					// If removing stopwords leaves us empty, fall back to raw words
					if ( empty( $title_words ) ) {
						$title_words = array_filter( $raw_title_words );
					}

					foreach ( $files as $f ) {
						if ( in_array( $f, array( '.', '..' ), true ) ) {
							continue;
						}
						// Support jpg, jpeg, png, gif, svg
						$ext = strtolower( pathinfo( $f, PATHINFO_EXTENSION ) );
						if ( ! in_array( $ext, array( 'jpg', 'jpeg', 'png', 'gif', 'svg' ), true ) ) {
							continue;
						}
						$fname = strtolower( pathinfo( $f, PATHINFO_FILENAME ) );
						$matchCount = 0;
						foreach ( $title_words as $w ) {
							if ( $w && strpos( $fname, $w ) !== false ) {
								$matchCount++;
							}
						}
						// require at least one non-stopword match (or half of words when many)
						$threshold = max( 1, floor( count( $title_words ) / 2 ) );
						if ( $matchCount >= $threshold ) {
							$found = $f;
							break;
						}
					}
				}
			}

			if ( $found ) {
				$thumb_url = esc_url( get_template_directory_uri() . '/assets/images/' . $found );
				$thumb_alt = esc_attr( get_the_title() );
				echo '<div class="book-card-image" data-bg="' . $thumb_url . '">';
				echo '<a href="' . esc_url( get_permalink() ) . '">';
				echo '<img src="' . $thumb_url . '" alt="' . $thumb_alt . '" class="book-cover-fallback" aria-hidden="true" />';
				echo '</a>';
				echo '</div>';
			} else {
				// No matching image found — generate a simple SVG placeholder data-URI with title initials
				$title = get_the_title();
				$words = preg_split( '/[^a-z0-9]+/i', $title );
				$initials = '';
				foreach ( $words as $w ) {
					if ( $w && ! in_array( strtolower( $w ), array( 'the', 'a', 'an', 'and', 'of', 'in', 'on', 'for', 'to', 'with', 'by', 'at' ), true ) ) {
						$initials .= strtoupper( mb_substr( $w, 0, 1 ) );
						if ( strlen( $initials ) >= 3 ) {
							break;
						}
					}
				}
				if ( empty( $initials ) ) {
					// fallback to first letters of raw words
					foreach ( $words as $w ) {
						if ( $w ) {
							$initials .= strtoupper( mb_substr( $w, 0, 1 ) );
							if ( strlen( $initials ) >= 3 ) {
								break;
							}
						}
					}
				}

				$initials = $initials ? $initials : 'BK';

				$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 1600">'
					. '<defs><linearGradient id="g" x1="0" x2="1"><stop offset="0" stop-color="#667eea"/><stop offset="1" stop-color="#764ba2"/></linearGradient></defs>'
					. '<rect width="100%" height="100%" fill="url(#g)" />'
					. '<text x="50%" y="54%" text-anchor="middle" dominant-baseline="middle" font-family="Helvetica, Arial, sans-serif" font-size="220" fill="#ffffff" font-weight="700">' . esc_html( $initials ) . '</text>'
					. '</svg>';

				$thumb_url = 'data:image/svg+xml;utf8,' . rawurlencode( $svg );
				$thumb_alt = esc_attr( $title );
				echo '<div class="book-card-image" data-bg="' . esc_attr( $thumb_url ) . '">';
				echo '<a href="' . esc_url( get_permalink() ) . '">';
				echo '<img src="' . esc_attr( $thumb_url ) . '" alt="' . $thumb_alt . '" class="book-cover-fallback" aria-hidden="true" />';
				echo '</a>';
				echo '</div>';
			}
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

			<?php
			// Display edit link for logged-in users
			edit_post_link(
				esc_html__( 'Edit', 'bookstore-theme' ),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</div>
	</div>
</article>

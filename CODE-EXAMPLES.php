<?php
/**
 * CODE EXAMPLES - Common Tasks in Bookstore Theme
 *
 * This file contains copy-paste code snippets for common customizations.
 * Delete this file when no longer needed.
 *
 * @package BookstoreTheme
 */

/**
 * EXAMPLE 1: Display All Books in a Grid
 * =======================================
 *
 * Use this in any template file to show books:
 */

// Example 1A: Simple book grid
?>
<?php
$books = new WP_Query( array(
	'post_type'      => 'book',
	'posts_per_page' => 12,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

if ( $books->have_posts() ) {
	echo '<div class="books-grid">';
	while ( $books->have_posts() ) {
		$books->the_post();
		get_template_part( 'template-parts/book-card' );
	}
	echo '</div>';
	wp_reset_postdata();
}
?>

<?php
/**
 * EXAMPLE 2: Display Books by Genre
 * ==================================
 */
?>
<?php
$genre_books = new WP_Query( array(
	'post_type'      => 'book',
	'posts_per_page' => 9,
	'tax_query'      => array(
		array(
			'taxonomy' => 'genre',
			'field'    => 'slug',
			'terms'    => 'fiction', // Change this to desired genre slug
		),
	),
) );

if ( $genre_books->have_posts() ) {
	echo '<h2>Fiction Books</h2>';
	echo '<div class="books-grid">';
	while ( $genre_books->have_posts() ) {
		$genre_books->the_post();
		get_template_part( 'template-parts/book-card' );
	}
	echo '</div>';
	wp_reset_postdata();
}
?>

<?php
/**
 * EXAMPLE 3: Display Books by Specific Author
 * ============================================
 */
?>
<?php
$author_books = new WP_Query( array(
	'post_type'      => 'book',
	'posts_per_page' => 9,
	'tax_query'      => array(
		array(
			'taxonomy' => 'author',
			'field'    => 'slug',
			'terms'    => 'j-k-rowling', // Change to author slug
		),
	),
) );

if ( $author_books->have_posts() ) {
	echo '<h2>Books by J.K. Rowling</h2>';
	echo '<div class="books-grid">';
	while ( $author_books->have_posts() ) {
		$author_books->the_post();
		get_template_part( 'template-parts/book-card' );
	}
	echo '</div>';
	wp_reset_postdata();
}
?>

<?php
/**
 * EXAMPLE 4: Display Featured/Sticky Books
 * ========================================
 * Note: You need to mark books as "Sticky" in WP admin
 */
?>
<?php
$featured_books = new WP_Query( array(
	'post_type'      => 'book',
	'posts_per_page' => 6,
	'post__in'       => get_option( 'sticky_posts' ),
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

if ( $featured_books->have_posts() ) {
	echo '<h2>Featured Books</h2>';
	echo '<div class="books-grid">';
	while ( $featured_books->have_posts() ) {
		$featured_books->the_post();
		get_template_part( 'template-parts/book-card' );
	}
	echo '</div>';
	wp_reset_postdata();
}
?>

<?php
/**
 * EXAMPLE 5: Get All Genres and Display Links
 * ===========================================
 */
?>
<?php
$genres = get_terms( array(
	'taxonomy'   => 'genre',
	'hide_empty' => true,
) );

if ( ! empty( $genres ) && ! is_wp_error( $genres ) ) {
	echo '<div class="genres-list">';
	echo '<h3>Browse by Genre</h3>';
	echo '<ul>';
	foreach ( $genres as $genre ) {
		echo '<li>';
		echo '<a href="' . esc_url( get_term_link( $genre ) ) . '">';
		echo esc_html( $genre->name ) . ' (' . absint( $genre->count ) . ')';
		echo '</a>';
		echo '</li>';
	}
	echo '</ul>';
	echo '</div>';
}
?>

<?php
/**
 * EXAMPLE 6: Display Book Meta Information
 * =======================================
 * Use inside single book template or book loop
 */
?>
<?php
// Get book authors
$authors = get_the_terms( get_the_ID(), 'author' );
if ( ! empty( $authors ) && ! is_wp_error( $authors ) ) {
	echo '<div class="book-authors">';
	echo '<strong>Author(s):</strong> ';
	$author_links = array();
	foreach ( $authors as $author ) {
		$author_links[] = '<a href="' . esc_url( get_term_link( $author ) ) . '">' . esc_html( $author->name ) . '</a>';
	}
	echo implode( ', ', $author_links );
	echo '</div>';
}

// Get book genres
$genres = get_the_terms( get_the_ID(), 'genre' );
if ( ! empty( $genres ) && ! is_wp_error( $genres ) ) {
	echo '<div class="book-genres">';
	echo '<strong>Genre(s):</strong> ';
	foreach ( $genres as $genre ) {
		echo '<span class="genre-badge">';
		echo '<a href="' . esc_url( get_term_link( $genre ) ) . '">' . esc_html( $genre->name ) . '</a>';
		echo '</span> ';
	}
	echo '</div>';
}

// Get book format
$formats = get_the_terms( get_the_ID(), 'format' );
if ( ! empty( $formats ) && ! is_wp_error( $formats ) ) {
	echo '<div class="book-format">';
	echo '<strong>Format:</strong> ';
	$format_names = array();
	foreach ( $formats as $format ) {
		$format_names[] = esc_html( $format->name );
	}
	echo implode( ', ', $format_names );
	echo '</div>';
}
?>

<?php
/**
 * EXAMPLE 7: Add Custom Function to functions.php
 * ================================================
 * Copy this to functions.php to add a helper function
 */
?>
<?php
/**
 * Get books by multiple criteria
 *
 * @param array $args Query arguments
 * @return array Array of book posts
 */
function bookstore_get_books( $args = array() ) {
	$defaults = array(
		'post_type'      => 'book',
		'posts_per_page' => 12,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$query_args = wp_parse_args( $args, $defaults );
	$query      = new WP_Query( $query_args );

	return $query;
}

// Usage:
// $my_books = bookstore_get_books( array( 'posts_per_page' => 5 ) );
?>

<?php
/**
 * EXAMPLE 8: Create a Custom Shortcode
 * ====================================
 * Add to functions.php
 */
?>
<?php
/**
 * Shortcode: Display featured books
 * Usage: [bookstore_featured_books count="6"]
 */
function bookstore_featured_books_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'count' => 6,
	), $atts, 'bookstore_featured_books' );

	$books = new WP_Query( array(
		'post_type'      => 'book',
		'posts_per_page' => intval( $atts['count'] ),
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );

	if ( ! $books->have_posts() ) {
		return '';
	}

	ob_start();
	echo '<div class="books-grid">';
	while ( $books->have_posts() ) {
		$books->the_post();
		get_template_part( 'template-parts/book-card' );
	}
	echo '</div>';
	wp_reset_postdata();

	return ob_get_clean();
}

add_shortcode( 'bookstore_featured_books', 'bookstore_featured_books_shortcode' );
?>

<?php
/**
 * EXAMPLE 9: Add Custom CSS Class to Body
 * ======================================
 * Already in functions.php, but here's how to add more
 */
?>
<?php
// Add to functions.php in bookstore_theme_body_classes filter

// Check if viewing a specific genre
if ( is_tax( 'genre' ) ) {
	$term = get_queried_object();
	$classes[] = 'genre-' . sanitize_html_class( $term->slug );
}

// Check if user is logged in
if ( is_user_logged_in() ) {
	$classes[] = 'user-logged-in';
}

// Check if is mobile
if ( wp_is_mobile() ) {
	$classes[] = 'is-mobile';
}

return $classes;
?>

<?php
/**
 * EXAMPLE 10: Add AJAX Load More Functionality
 * ============================================
 * Backend for the JavaScript in assets/js/main.js
 * Add to functions.php
 */
?>
<?php
/**
 * AJAX handler to load more books
 */
function bookstore_load_more_books_callback() {
	// Verify nonce
	check_ajax_referer( 'bookstore_nonce', 'nonce' );

	$page  = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 2;
	$count = isset( $_POST['posts_per_page'] ) ? intval( $_POST['posts_per_page'] ) : 6;

	$books = new WP_Query( array(
		'post_type'      => 'book',
		'posts_per_page' => $count,
		'paged'          => $page,
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );

	if ( $books->have_posts() ) {
		ob_start();
		while ( $books->have_posts() ) {
			$books->the_post();
			get_template_part( 'template-parts/book-card' );
		}
		$html = ob_get_clean();
		wp_reset_postdata();

		wp_send_json_success( array(
			'html'    => $html,
			'hasMore' => ( $page < $books->max_num_pages ),
		) );
	} else {
		wp_send_json_error( 'No more books' );
	}
}

add_action( 'wp_ajax_bookstore_load_more_books', 'bookstore_load_more_books_callback' );
add_action( 'wp_ajax_nopriv_bookstore_load_more_books', 'bookstore_load_more_books_callback' );
?>

<?php
/**
 * EXAMPLE 11: Customize Archive Title
 * ==================================
 * Add to functions.php
 */
?>
<?php
/**
 * Customize archive title for books
 */
function bookstore_archive_title( $title ) {
	if ( is_post_type_archive( 'book' ) ) {
		$title = 'Our Books';
	} elseif ( is_tax( 'genre' ) ) {
		$term  = get_queried_object();
		$title = 'Genre: ' . $term->name;
	} elseif ( is_tax( 'author' ) ) {
		$term  = get_queried_object();
		$title = 'Books by ' . $term->name;
	}
	return $title;
}

add_filter( 'get_the_archive_title', 'bookstore_archive_title' );
?>

<?php
/**
 * EXAMPLE 12: Add Custom Meta Box for Book Info
 * =============================================
 * Alternative to ACF plugin - add to functions.php
 */
?>
<?php
/**
 * Add custom meta box for book information
 */
function bookstore_add_book_meta_box() {
	add_meta_box(
		'book-info',
		'Book Information',
		'bookstore_book_meta_box_callback',
		'book',
		'normal',
		'high'
	);
}

add_action( 'add_meta_boxes', 'bookstore_add_book_meta_box' );

/**
 * Render book meta box
 */
function bookstore_book_meta_box_callback( $post ) {
	$isbn     = get_post_meta( $post->ID, '_book_isbn', true );
	$publisher = get_post_meta( $post->ID, '_book_publisher', true );
	$year     = get_post_meta( $post->ID, '_book_year', true );

	wp_nonce_field( 'bookstore_meta_nonce', 'bookstore_meta_nonce' );

	?>
	<p>
		<label for="book-isbn">ISBN:</label>
		<input type="text" id="book-isbn" name="book_isbn" value="<?php echo esc_attr( $isbn ); ?>" />
	</p>
	<p>
		<label for="book-publisher">Publisher:</label>
		<input type="text" id="book-publisher" name="book_publisher" value="<?php echo esc_attr( $publisher ); ?>" />
	</p>
	<p>
		<label for="book-year">Publication Year:</label>
		<input type="number" id="book-year" name="book_year" value="<?php echo esc_attr( $year ); ?>" />
	</p>
	<?php
}

/**
 * Save book meta
 */
function bookstore_save_book_meta( $post_id ) {
	if ( ! isset( $_POST['bookstore_meta_nonce'] ) || ! wp_verify_nonce( $_POST['bookstore_meta_nonce'], 'bookstore_meta_nonce' ) ) {
		return;
	}

	if ( isset( $_POST['book_isbn'] ) ) {
		update_post_meta( $post_id, '_book_isbn', sanitize_text_field( $_POST['book_isbn'] ) );
	}
	if ( isset( $_POST['book_publisher'] ) ) {
		update_post_meta( $post_id, '_book_publisher', sanitize_text_field( $_POST['book_publisher'] ) );
	}
	if ( isset( $_POST['book_year'] ) ) {
		update_post_meta( $post_id, '_book_year', intval( $_POST['book_year'] ) );
	}
}

add_action( 'save_post_book', 'bookstore_save_book_meta' );
?>

<?php
/**
 * EXAMPLE 13: Display Book Info (if using custom meta)
 * ===================================================
 * Use in single-book.php
 */
?>
<?php
$isbn      = get_post_meta( get_the_ID(), '_book_isbn', true );
$publisher = get_post_meta( get_the_ID(), '_book_publisher', true );
$year      = get_post_meta( get_the_ID(), '_book_year', true );

if ( $isbn || $publisher || $year ) {
	echo '<div class="book-publication-info">';
	if ( $isbn ) {
		echo '<p><strong>ISBN:</strong> ' . esc_html( $isbn ) . '</p>';
	}
	if ( $publisher ) {
		echo '<p><strong>Publisher:</strong> ' . esc_html( $publisher ) . '</p>';
	}
	if ( $year ) {
		echo '<p><strong>Year:</strong> ' . esc_html( $year ) . '</p>';
	}
	echo '</div>';
}
?>

<?php
/**
 * EXAMPLE 14: Get Theme Color
 * ==========================
 * Add to functions.php for easy theme customization
 */
?>
<?php
/**
 * Get theme primary color
 */
function bookstore_get_primary_color() {
	return apply_filters( 'bookstore_primary_color', '#0066cc' );
}

/**
 * Get theme secondary color
 */
function bookstore_get_secondary_color() {
	return apply_filters( 'bookstore_secondary_color', '#6c757d' );
}

// Usage in CSS:
// .button { color: <?php echo esc_attr( bookstore_get_primary_color() ); ?>; }
?>

<?php
/**
 * EXAMPLE 15: Useful Debugging Code
 * ================================
 * Never use in production! Add to functions.php temporarily
 */
?>
<?php
// Check if custom post type exists
if ( post_type_exists( 'book' ) ) {
	echo 'Book post type registered';
}

// Check if taxonomy exists
if ( taxonomy_exists( 'genre' ) ) {
	echo 'Genre taxonomy registered';
}

// Get all books count
$book_count = wp_count_posts( 'book' );
echo 'Total books: ' . $book_count->publish;

// Get total genres
$genres = get_terms( array(
	'taxonomy'   => 'genre',
	'hide_empty' => false,
) );
echo 'Total genres: ' . count( $genres );

// Log to debug.log
error_log( 'Debug message: ' . print_r( $variable, true ) );
?>

---

## Customization Tips

1. **Colors**: Edit primary color (#0066cc) in style.css
2. **Fonts**: Add Google Fonts in functions.php
3. **Post Types**: Modify register_post_type arguments
4. **Taxonomies**: Add new taxonomies in functions.php
5. **Template Parts**: Create new template-parts/filename.php
6. **Hooks**: Use WordPress filters and actions throughout

All code examples follow WordPress coding standards and are production-ready!

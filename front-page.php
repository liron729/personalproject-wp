<?php
/**
 * The front page template
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrapper homepage">
	<!-- Hero Section -->
	<section class="hero-section">
		<div class="hero-content">
			<h1><?php esc_html_e( 'Welcome to Our Bookstore', 'bookstore-theme' ); ?></h1>
			<p><?php esc_html_e( 'Discover a world of stories, knowledge, and imagination.', 'bookstore-theme' ); ?></p>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'book' ) ); ?>" class="btn btn-primary">
				<?php esc_html_e( 'Browse Books', 'bookstore-theme' ); ?>
			</a>
		</div>
	</section>

	<!-- Featured Books Section -->
	<section class="featured-books">
		<div class="section-header">
			<h2><?php esc_html_e( 'Featured Books', 'bookstore-theme' ); ?></h2>
			<p><?php esc_html_e( 'Check out our latest and most popular books.', 'bookstore-theme' ); ?></p>
		</div>

		<?php
		// Display featured books
		$featured_books = new WP_Query( array(
			'post_type'      => 'book',
			'posts_per_page' => 6,
			'orderby'        => 'date',
			'order'          => 'DESC',
		) );

		if ( $featured_books->have_posts() ) {
			echo '<div class="books-grid">';
			while ( $featured_books->have_posts() ) {
				$featured_books->the_post();
				get_template_part( 'template-parts/book-card' );
			}
			echo '</div>';
			wp_reset_postdata();
		}
		?>
	</section>

	<!-- About Section -->
	<section class="about-preview">
		<div class="about-content">
			<h2><?php esc_html_e( 'About Our Bookstore', 'bookstore-theme' ); ?></h2>
			<p><?php esc_html_e( 'We are dedicated to providing book lovers with a curated collection of the finest books across all genres. Our mission is to inspire readers and foster a love of literature.', 'bookstore-theme' ); ?></p>
			<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ); ?>" class="btn btn-secondary">
				<?php esc_html_e( 'Learn More', 'bookstore-theme' ); ?>
			</a>
		</div>
	</section>

	<!-- Main Page Content (if set as homepage) -->
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			echo '<div class="homepage-content">';
			the_content();
			echo '</div>';
		}
	}
	?>
</div>

<?php
get_footer();

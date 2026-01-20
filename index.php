<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrapper">
	<?php
	if ( have_posts() ) {
		// Display page title for archives
		if ( is_home() || is_archive() || is_search() ) {
			echo '<div class="page-header">';
			if ( is_home() ) {
				echo '<h1 class="page-title">' . esc_html__( 'Latest Posts', 'bookstore-theme' ) . '</h1>';
			} elseif ( is_search() ) {
				echo '<h1 class="page-title">';
				printf( esc_html__( 'Search Results for: %s', 'bookstore-theme' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
				echo '</h1>';
			} else {
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
			}
			echo '</div>';
		}

		// Begin the loop
		while ( have_posts() ) {
			the_post();

			// Include template part for post content
			get_template_part( 'template-parts/content', get_post_type() );
		}

		// Pagination
		the_posts_pagination( array(
			'mid_size'  => 2,
			'prev_text' => esc_html__( 'Previous', 'bookstore-theme' ),
			'next_text' => esc_html__( 'Next', 'bookstore-theme' ),
		) );
	} else {
		// No posts found
		?>
		<div class="no-posts-found">
			<h2><?php esc_html_e( 'Nothing Found', 'bookstore-theme' ); ?></h2>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'bookstore-theme' ); ?></p>
			<?php get_search_form(); ?>
		</div>
		<?php
	}
	?>
</div>

<?php
get_footer();

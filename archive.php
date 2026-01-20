<?php
/**
 * The template for displaying generic archives
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrapper archive">
	<?php
	if ( have_posts() ) {
		// Display page title for archives
		echo '<div class="page-header">';
		the_archive_title( '<h1 class="page-title">', '</h1>' );
		the_archive_description( '<div class="archive-description">', '</div>' );
		echo '</div>';

		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', get_post_type() );
		}

		// Pagination
		the_posts_pagination( array(
			'mid_size'  => 2,
			'prev_text' => esc_html__( 'Previous', 'bookstore-theme' ),
			'next_text' => esc_html__( 'Next', 'bookstore-theme' ),
		) );
	} else {
		?>
		<div class="no-posts-found">
			<h2><?php esc_html_e( 'Nothing Found', 'bookstore-theme' ); ?></h2>
			<p><?php esc_html_e( 'Sorry, but there is nothing to display here.', 'bookstore-theme' ); ?></p>
		</div>
		<?php
	}
	?>
</div>

<?php
get_footer();

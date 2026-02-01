<?php
/**
 * Template Name: Blogs
 * Description: A simple page template that lists recent blog posts with pagination.
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrapper page-blogs">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Blog', 'bookstore-theme' ); ?></h1>
	</header>

	<?php
	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$blogs_query = new WP_Query( array(
		'post_type'      => 'post',
		'posts_per_page' => 10,
		'paged'          => $paged,
	) );

	if ( $blogs_query->have_posts() ) :
		echo '<div class="blog-posts-list">';

		while ( $blogs_query->have_posts() ) : $blogs_query->the_post();
			get_template_part( 'template-parts/content', 'post' );
		endwhile;

		echo '</div>';

		// Pagination
		the_posts_pagination( array(
			'prev_text' => esc_html__( 'Previous', 'bookstore-theme' ),
			'next_text' => esc_html__( 'Next', 'bookstore-theme' ),
		) );

		wp_reset_postdata();

	else :
		echo '<p>' . esc_html__( 'No posts found.', 'bookstore-theme' ) . '</p>';
	endif;
	?>
</div>

<?php
get_footer();
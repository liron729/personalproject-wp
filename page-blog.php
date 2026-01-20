<?php
/**
 * Page template for Blog page
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrapper page-blog">
	<?php
	// Get page content
	if ( have_posts() ) {
		the_post();
		?>
		<header class="page-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header>

		<div class="page-intro">
			<?php the_content(); ?>
		</div>
		<?php
	}

	// Display blog posts
	$blog_query = new WP_Query( array(
		'post_type'      => 'post',
		'posts_per_page' => 10,
		'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
	) );

	if ( $blog_query->have_posts() ) {
		echo '<div class="blog-posts-list">';

		while ( $blog_query->have_posts() ) {
			$blog_query->the_post();
			get_template_part( 'template-parts/content', 'post' );
		}

		echo '</div>';

		// Pagination
		the_posts_pagination( array(
			'query' => $blog_query,
		) );

		wp_reset_postdata();
	} else {
		echo '<p>' . esc_html__( 'No posts found.', 'bookstore-theme' ) . '</p>';
	}
	?>
</div>

<?php
get_footer();

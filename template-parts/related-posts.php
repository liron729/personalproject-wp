<?php
/**
 * Template part for displaying related posts
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get current post's categories
$current_post_id = get_the_ID();
$categories      = wp_get_post_categories( $current_post_id, array( 'fields' => 'ids' ) );

if ( empty( $categories ) ) {
	return;
}

// Query related posts
$related_posts = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 3,
	'post__not_in'   => array( $current_post_id ),
	'category__in'   => $categories,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

if ( $related_posts->have_posts() ) {
	?>
	<section class="related-posts">
		<h3><?php esc_html_e( 'Related Posts', 'bookstore-theme' ); ?></h3>
		<div class="posts-list">
			<?php
			while ( $related_posts->have_posts() ) {
				$related_posts->the_post();
				?>
				<article class="related-post-item">
					<h4>
						<a href="<?php echo esc_url( get_permalink() ); ?>">
							<?php the_title(); ?>
						</a>
					</h4>
					<div class="post-date">
						<?php echo esc_html( get_the_date() ); ?>
					</div>
				</article>
				<?php
			}
			?>
		</div>
	</section>
	<?php
	wp_reset_postdata();
}

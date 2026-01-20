<?php
/**
 * The template for displaying single posts
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-wrapper single-post">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-content' ); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<div class="entry-meta">
						<?php
						// Display post date
						printf(
							'<span class="posted-on">' . esc_html__( 'Posted on %s', 'bookstore-theme' ) . '</span>',
							'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><time class="entry-date published" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time></a>'
						);
						?>

						<?php
						// Display author
						printf(
							'<span class="byline"> ' . esc_html__( 'by %s', 'bookstore-theme' ) . '</span>',
							'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
						);
						?>

						<?php
						// Display post categories
						$categories = get_the_category();
						if ( ! empty( $categories ) ) {
							echo '<span class="cat-links">';
							foreach ( $categories as $category ) {
								echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a> ';
							}
							echo '</span>';
						}
						?>
					</div>
				</header>

				<?php
				// Display featured image
				if ( has_post_thumbnail() ) {
					echo '<div class="entry-image">';
					the_post_thumbnail( 'large' );
					echo '</div>';
				}
				?>

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

				<?php
				// Display tags
				$tags = get_the_tags();
				if ( ! empty( $tags ) ) {
					echo '<div class="entry-tags">';
					echo '<strong>' . esc_html__( 'Tags: ', 'bookstore-theme' ) . '</strong>';
					foreach ( $tags as $tag ) {
						echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="tag-link">' . esc_html( $tag->name ) . '</a> ';
					}
					echo '</div>';
				}
				?>
			</article>

			<?php
			// Display comments
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
	}
	?>
</div>

<?php
// Display related posts (optional)
get_template_part( 'template-parts/related-posts' );

get_footer();

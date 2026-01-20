<?php
/**
 * Template part for displaying a post (used in archives and blog pages)
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-preview' ); ?>>
	<div class="post-preview-inner">
		<?php
		// Display featured image
		if ( has_post_thumbnail() ) {
			echo '<div class="post-image">';
			echo '<a href="' . esc_url( get_permalink() ) . '">';
			the_post_thumbnail( 'medium' );
			echo '</a>';
			echo '</div>';
		}
		?>

		<div class="post-content">
			<header class="entry-header">
				<h2 class="entry-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php the_title(); ?>
					</a>
				</h2>

				<div class="entry-meta">
					<?php
					printf(
						'<span class="posted-on">' . esc_html__( 'Posted on %s', 'bookstore-theme' ) . '</span>',
						'<a href="' . esc_url( get_permalink() ) . '"><time class="entry-date" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time></a>'
					);
					?>

					<?php
					printf(
						'<span class="byline"> ' . esc_html__( 'by %s', 'bookstore-theme' ) . '</span>',
						'<span class="author"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
					);
					?>
				</div>
			</header>

			<div class="entry-excerpt">
				<?php
				the_excerpt( sprintf(
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
				?>
			</div>

			<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-small">
				<?php esc_html_e( 'Read More', 'bookstore-theme' ); ?>
			</a>
		</div>
	</div>
</article>

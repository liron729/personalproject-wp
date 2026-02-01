<?php
/**
 * Comments template
 *
 * Displays the list of comments and the comment form. Adds a solid fallback
 * for AJAX submission (handled in `assets/js/main.js`) so the "Post Comment"
 * button works even if the default flow is broken by JS/CSS.
 *
 * @package BookstoreTheme
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			printf( // WPCS: XSS OK.
				esc_html( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'bookstore-theme' ) ),
				number_format_i18n( get_comments_number() )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 56,
			) );
			?>
		</ol>

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
	// If comments are closed and there are comments, display a note.
	if ( ! comments_open() && get_comments_number() ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'bookstore-theme' ); ?></p>
		<?php
	endif;
	?>

	<?php
	// Display comment form with clear classes and accessible submit button
	comment_form( array(
		'title_reply'    => esc_html__( 'Leave a Comment', 'bookstore-theme' ),
		'label_submit'   => esc_html__( 'Post Comment', 'bookstore-theme' ),
		'class_submit'   => 'btn btn-primary',
		'id_form'        => 'commentform',
		'format'         => 'html5',
		'submit_field'   => '<p class="form-submit">%1$s %2$s</p>',
	) );
	?>

</div>

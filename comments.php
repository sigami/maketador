<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package maketador
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area well well-sm">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			printf( // WPCS: XSS OK.
				esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'maketador' ) ),
				number_format_i18n( get_comments_number() ),
				'<span>' . get_the_title() . '</span>'
			);
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<?php wp_boostrap_pagination::comments_simple() ?>
			</nav><!-- #comment-nav-above -->
		<?php endif; ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'callback' => 'Maketador_Bootstrap::comments',
			) );

			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<?php //paginate_comments_links(); TODO ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<?php wp_boostrap_pagination::comments_simple() ?>
			</nav><!-- #comment-nav-below -->
			<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'maketador' ); ?></p>
		<?php
	endif;

	$title_reply   = ( function_exists( 'is_product' ) && is_product() ) ? __( "Review this product", 'maketador' ) : __( "Leave a Reply", 'maketador' );
	$comment_field = '<div class="form-group"><label for="comment" class="sr-only">'
	                 . ( ( function_exists( 'is_product' ) && is_product() ) ? __( "Review", 'maketador' ) : __( "Reply", 'maketador' ) )
	                 . ' </label>'
	                 . '<textarea class="form-control" role="textbox" aria-multiline="true" name="comment" id="comment" rows="8" placeholder="'
	                 . __( "Your Comment Here...", 'maketador' )
	                 . '"></textarea></div>';
	comment_form(
		array(
			'comment_notes_before' => '',
			'comment_field'        => $comment_field,
			'title_reply'          => $title_reply,
			'class_submit'         => 'btn btn-primary'
		)
	);
	?>

</div><!-- #comments -->

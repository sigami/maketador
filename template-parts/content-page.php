<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package maketador
 */
$hide_title = ( get_post_meta( get_the_ID(), '_maketador_hide_title', true ) == 'on' ) ? 'hide' : '';
$show_date  = ( get_post_meta( get_the_ID(), '_maketador_show_date', true ) == 'on' ) ? maketador_page_posted_on() : '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header page-header <?php echo $hide_title ?>">
		<?php
		the_title( '<h1 class="entry-title">', '</h1>' );
		echo $show_date;
		?>
	</header>
	<div class="entry-content">
		<?php
		the_content();
		wp_link_pages();
		?>
	</div>
	<footer class="entry-footer">
		<?php maketador_edit_link() ?>
	</footer>
</article>

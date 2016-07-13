<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package maketador
 */
$hide = is_page_template('page-templates/blank-no-container.php') || is_page_template('page-templates/blank.php') ? ' hide' : (is_page_template('page-templates/full-width.php') ? 'text-center' : '');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header page-header <?php echo $hide ?>">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
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

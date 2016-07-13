<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package maketador
 */
if ( ! is_active_sidebar( 'sidebar-1' ) || (get_theme_mod('layout_type') == 'no-sidebar') )
	return;
?>
<br>
<aside id="secondary" class="widget-area <?php Maketador_Customizer::secondary_div_class() ?>" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>

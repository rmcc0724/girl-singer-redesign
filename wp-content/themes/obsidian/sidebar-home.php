<?php
/**
 * The template containing the home widget area.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<div id="secondary" class="home-widgets widget-area" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">

	<?php do_action( 'obsidian_home_widgets_top' ); ?>

	<div class="block-grid block-grid--gutters block-grid-3">
		<?php dynamic_sidebar( 'home-widgets' ); ?>
	</div>

	<?php do_action( 'obsidian_home_widgets_bottom' ); ?>

</div>

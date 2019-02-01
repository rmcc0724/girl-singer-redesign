<?php
/**
 * The template for displaying the site header.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<header id="masthead" class="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

	<?php do_action( 'obsidian_header_top' ); ?>

	<?php obsidian_site_branding(); ?>

	<nav id="site-navigation" class="site-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<button class="site-navigation-toggle"><?php esc_html_e( 'Menu', 'obsidian' ); ?></button>
		<?php endif; ?>

		<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'menu',
			'fallback_cb'    => false,
			'depth'          => 3,
		) );
		?>
	</nav>

	<?php do_action( 'obsidian_header_bottom' ); ?>

</header>

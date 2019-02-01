<?php
/**
 * Helper methods for loading or displaying template partials.
 *
 * These are typically miscellaneous template parts used outside the loop.
 * Although if the partial requires any sort of set up or tearddown, moving that
 * logic into a helper keeps the parent template a little more lean, clean,
 * reusable and easier to override in child themes.
 *
 * Loading these partials within an action hook will allow them to be easily
 * added, removed, or reordered without changing the parent template file.
 *
 * Take a look at obsidian_register_template_parts() to see where most of these
 * are inserted.
 *
 * This approach tries to blend the two common approaches to theme development
 * (hooks or partials).
 *
 * @package Obsidian
 * @since 1.0.0
 */

/**
 * Display the home widgets sidebar area.
 *
 * @since 1.0.0
 */
function obsidian_front_page_sidebar() {
	if ( ! is_active_sidebar( 'home-widgets' ) ) {
		return;
	}

	get_sidebar( 'home' );
}

/**
 * Print a background overlay element.
 *
 * @since 1.0.0
 */
function obsidian_background_overlay() {
	echo '<div class="obsidian-background-overlay"></div>';
}

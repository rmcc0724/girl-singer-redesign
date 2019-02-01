<?php
/**
 * Custom template tags.
 *
 * @package Obsidian
 * @since 1.0.0
 */

if ( ! function_exists( 'obsidian_site_branding' ) ) :
/**
 * Display the site logo, title, and description.
 *
 * @since 1.0.0
 */
function obsidian_site_branding() {
	$output = '';

	// Site logo.
	$output .= obsidian_theme()->logo->html();

	// Replace the site logo on the front page.
	if ( is_front_page() && ( $logo_url = get_theme_mod( 'front_page_logo_url' ) ) ) {
		$output = sprintf(
			'<a href="%1$s" class="site-logo-link site-logo-anchor"><img src="%2$s" alt="" class="site-logo" data-size="full"></a>',
			esc_url( home_url( '/' ) ),
			esc_url( $logo_url )
		);
	}

	// Site title.
	$output .= sprintf(
		'<h1 class="site-title"><a href="%1$s" rel="home">%2$s</a></h1>',
		esc_url( home_url( '/' ) ),
		esc_html( get_bloginfo( 'name', 'display' ) )
	);

	// Site description.
	$output .= '<div class="site-description screen-reader-text">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</div>';

	echo '<div class="site-branding">' . $output . '</div>'; // XSS OK
}
endif;

/**
 * Wrapper for the_archive_title() to help maintain consistent markup.
 *
 * @since 1.0.0
 */
function obsidian_archive_title() {
	the_archive_title(
		'<header class="page-header"><h1 class="page-title" itemprop="title"><a href="' . esc_url( obsidian_get_archive_link() ) . '" itemprop="url">',
		'</a></h1></header>'
	);
}

if ( ! function_exists( 'obsidian_comment_navigation' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since 1.0.0
 */
function obsidian_comment_navigation() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() < 2 || ! get_option( 'page_comments' ) ) {
		return;
	}
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'obsidian' ); ?></h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'obsidian' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', obsidian_allowed_tags( $prev_link ) );
				endif;

				if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'obsidian' ) ) ) :
					printf( '<div class="nav-next">%s</div>', obsidian_allowed_tags( $next_link ) );
				endif;
			?>
		</div>
	</nav>
	<?php
}
endif;

if ( ! function_exists( 'obsidian_content_navigation' ) ) :
/**
 * Display navigation to next/previous posts when applicable.
 *
 * @since 1.0.0
 */
function obsidian_content_navigation() {
	if ( is_singular() ) :
		the_post_navigation( array(
			'prev_text' => _x( 'Prev <span class="screen-reader-text">Post: %title</span>', 'Previous post link', 'obsidian' ),
			'next_text' => _x( 'Next <span class="screen-reader-text">Post: %title</span>', 'Next post link', 'obsidian' ),
		) );
	else :
		the_posts_pagination( array(
			'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page', 'obsidian' ) . ' </span>',
		) );
	endif;
}
endif;

if ( ! function_exists( 'obsidian_page_links' ) ) :
/**
 * Wrapper for wp_link_pages() to maintain consistent markup.
 *
 * @since 1.0.0
 *
 * @return string
 */
function obsidian_page_links() {
	if ( ! is_singular() ) {
		return;
	}

	wp_link_pages( array(
		'before'      => '<nav class="page-links"><span class="page-links-title">' . esc_html__( 'Pages', 'obsidian' ) . '</span>',
		'after'       => '</nav>',
		'link_before' => '<span class="page-links-number">',
		'link_after'  => '</span>',
		'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'obsidian' ) . ' </span>%',
		'separator'   => '<span class="screen-reader-text">, </span>',
	) );
}
endif;


if ( ! function_exists( 'obsidian_post_type_navigation' ) ) :
/**
 * Display navigation menu for a post type archive.
 *
 * Navigation menus need to be registered using register_nav_menus() with the
 * location name set as the post type name.
 *
 * @since 1.0.0
 *
 * @param string $post_type Optional. Post type string.
 */
function obsidian_post_type_navigation( $post_type = '' ) {
	if ( ! $post_type ) {
		$post_type = get_post_type();
	}

	$args = apply_filters( 'obsidian_post_type_navigation_args', array(
		'theme_location' => $post_type,
		'container'      => false,
		'menu_class'     => 'menu',
		'depth'          => 1,
		'fallback_cb'    => false,
	) );

	if ( ! $args['theme_location'] || ! has_nav_menu( $args['theme_location'] ) ) {
		return;
	}
	?>
	<nav class="navigation post-type-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php echo esc_html( obsidian_get_nav_menu_name( $args['theme_location'] ) ); ?></h2>
		<?php wp_nav_menu( $args );	?>
	</nav>
	<?php
}
endif;

if ( ! function_exists( 'obsidian_get_nav_menu_name' ) ) :
/**
 * Get the name of a nav menu as set in the admin panel.
 *
 * @since 1.0.0
 *
 * @param string $theme_location Location of the corresponding menu.
 * @return string Name of the nav menu.
 */
function obsidian_get_nav_menu_name( $theme_location ) {
	$locations = get_nav_menu_locations();

	if ( empty( $locations[ $theme_location ] ) ) {
		return '';
	}

	$menu = get_term( $locations[ $theme_location ], 'nav_menu' );

	return ( ! $menu || empty( $menu->name ) ) ? '' : $menu->name;
}
endif;

if ( ! function_exists( 'obsidian_entry_title' ) ) :
/**
 * Display entry title with permalink on archive type pages.
 *
 * @since 1.0.0
 */
function obsidian_entry_title() {
	$format = get_post_format();
	$title  = get_the_title();

	if ( ! $title ) {
		return;
	}

	if ( ! is_singular() || 'link' === $format ) {
		$title = sprintf(
			'<a class="permalink" href="%1$s" rel="bookmark" itemprop="url">%2$s</a>',
			esc_url( ( 'link' === $format ) ? obsidian_theme()->post_media->get_link_url() : get_permalink() ),
			$title
		);
	}

	printf( '<h1 class="entry-title" itemprop="headline">%s</h1>', obsidian_allowed_tags( $title ) );
}
endif;

if ( ! function_exists( 'obsidian_get_entry_author' ) ) :
/**
 * Retrieve entry author.
 *
 * @since 1.0.0
 *
 * @return string
 */
function obsidian_get_entry_author() {
	$html  = '<span class="entry-author author vcard" itemprop="author" itemscope itemtype="http://schema.org/Person">';
	$html .= sprintf(
		'<a class="url fn n" href="%1$s" rel="author" itemprop="url"><span itemprop="name">%2$s</span></a>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
	$html .= '</span>';

	return $html;
}
endif;

if ( ! function_exists( 'obsidian_get_entry_date' ) ) :
/**
 * Retrieve HTML with meta information for the current post-date/time.
 *
 * @since 1.0.0
 *
 * @param bool $updated Optional. Whether to print the updated time, too. Defaults to true.
 * @return string
 */
function obsidian_get_entry_date( $updated = true ) {
	$time_string = '<time class="entry-time published" datetime="%1$s" itemprop="datePublished">%2$s</time>';

	// To appease rich snippets, an updated class needs to be defined.
	// Default to the published time if the post has not been updated.
	if ( $updated ) {
		if ( get_the_time( 'U' ) === get_the_modified_time( 'U' ) ) {
			$time_string .= '<time class="entry-time updated" datetime="%1$s">%2$s</time>';
		} else {
			$time_string .= '<time class="entry-time updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';
		}
	}

	return sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
}
endif;

if ( ! function_exists( 'obsidian_posted_by' ) ) :
/**
 * Display post author byline.
 *
 * @since 1.0.0
 */
function obsidian_posted_by() {
	?>
	<span class="posted-by byline">
		<?php
		/* translators: %s: Author name */
		printf( esc_html__( 'by %s', 'obsidian' ), obsidian_get_entry_author() );
		?>
	</span>
	<?php
}
endif;

if ( ! function_exists( 'obsidian_posted_on' ) ) :
/**
 * Display post date/time with link.
 *
 * @since 1.0.0
 */
function obsidian_posted_on() {
	?>
	<span class="posted-on">
		<?php
		$html = sprintf(
			'<span class="entry-date"><a href="%1$s" rel="bookmark">%2$s</a></span>',
			esc_url( get_permalink() ),
			obsidian_get_entry_date()
		);

		/* translators: %s: Publish date */
		echo obsidian_allowed_tags( sprintf( __( '<span class="sep">on</span> %s', 'obsidian' ), $html ) );
		?>
	</span>
	<?php
}
endif;

if ( ! function_exists( 'obsidian_entry_comments_link' ) ) :
/**
 * Display linked entry comment count.
 *
 * @since 1.0.0
 */
function obsidian_entry_comments_link() {
	if ( is_singular() || post_password_required() || ! comments_open() || ! get_comments_number() ) {
		return;
	}

	echo '<span class="entry-comments-link">';
	comments_popup_link(
		__( 'Leave a comment', 'obsidian' ),
		__( '1 Comment', 'obsidian' ),
		__( '% Comments', 'obsidian' )
	);
	echo '</span>';
}
endif;

if ( ! function_exists( 'obsidian_entry_terms' ) ) :
/**
 * Display terms for a given taxonomy.
 *
 * @since 1.0.0
 *
 * @param array $taxonomies Optional. List of taxonomy objects with labels.
 */
function obsidian_entry_terms( $taxonomies = array() ) {
	if ( ! is_singular() || post_password_required() ) {
		return;
	}

	echo obsidian_get_entry_terms( $taxonomies );
}
endif;

if ( ! function_exists( 'obsidian_get_entry_terms' ) ) :
/**
 * Retrieve terms for a given taxonomy.
 *
 * @since 1.0.0
 *
 * @param array $taxonomies Optional. List of taxonomy objects with labels.
 * @param int|WP_Post $post Optional. Post ID or object. Defaults to the current post.
 */
function obsidian_get_entry_terms( $taxonomies = array(), $post = null ) {
	$default = array(
		'category' => esc_html__( 'Posted In:', 'obsidian' ),
		'post_tag' => esc_html__( 'Tagged:', 'obsidian' ),
	);

	// Set default taxonomies if empty or not an array.
	if ( ! $taxonomies || ! is_array( $taxonomies ) ) {
		$taxonomies = $default;
	}

	// Allow plugins and themes to override taxonomies and labels.
	$taxonomies = apply_filters( 'obsidian_entry_terms_taxonomies', $taxonomies );

	// Return early if the taxonomies are empty or not an array.
	if ( ! $taxonomies || ! is_array( $taxonomies ) ) {
		return;
	}

	$post   = get_post( $post );
	$output = '';

	// Get object taxonomy list to validate taxonomy later on.
	$object_taxonomies = get_object_taxonomies( get_post_type() );

	// Loop through each taxonomy and set up term list html.
	foreach ( (array) $taxonomies as $taxonomy => $label ) {
		// Continue if taxonomy is not in the object taxonomy list.
		if ( ! in_array( $taxonomy, $object_taxonomies ) ) {
			continue;
		}

		// Get term list
		$term_list = get_the_term_list( $post->ID, $taxonomy, '<li>', '</li><li>', '</li>' );

		// Continue if there is not one or more terms in the taxonomy.
		if ( ! $term_list || ! obsidian_theme()->template->has_multiple_terms( $taxonomy ) ) {
			continue;
		}

		if ( $label ) {
			$label = sprintf( '<h3 class="term-title">%s</h3>', $label );
		}

		$term_list = sprintf( '<ul class="term-list">%s</ul>', $term_list );

		// Set term list output html.
		$output .= sprintf(
			'<div class="term-group term-group--%1$s">%2$s%3$s</div>',
			esc_attr( $taxonomy ),
			$label,
			$term_list
		);
	}

	// Return if no term lists were created.
	if ( empty( $output ) ) {
		return;
	}

	printf( '<div class="entry-terms">%s</div>', wp_kses_post( $output ) );
}
endif;

/**
 * Print classes needed to render a block grid.
 *
 * @since 1.0.0
 *
 * @param array $classes List of HTML classes.
 */
function obsidian_block_grid_classes( $classes = array() ) {
	// Split a string.
	if ( ! empty( $classes ) && ! is_array( $classes ) ) {
		$classes = preg_split( '#\s+#', $classes );
	}

	array_unshift( $classes, 'block-grid', 'block-grid--gutters' );
	$classes = apply_filters( 'obsidian_block_grid_classes', $classes );

	echo esc_attr( implode( ' ', $classes ) );
}

if ( ! function_exists( 'obsidian_has_main_sidebar' ) ) :
/**
 * Whether a page should show the main sidebar.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function obsidian_has_main_sidebar() {
	$show_sidebar = false;

	// Singular pages.
	if (
		is_singular( array( 'post', 'page', 'attachment' ) ) &&
		! obsidian_is_full_width_layout() &&
		! is_page_template( 'templates/no-sidebar.php' )
	) {
		$show_sidebar = true;
	}
	// Archive pages.
	elseif (
		is_home() ||
		is_archive() ||
		is_search()
	) {
		$show_sidebar = true;
	}

	return apply_filters( 'obsidian_has_main_sidebar', $show_sidebar );
}
endif;

if ( ! function_exists( 'obsidian_is_full_width_layout' ) ) :
/**
 * Boolean function to check if page has a full width layout.
 *
 * @since 1.0.0
 */
function obsidian_is_full_width_layout() {
	$is_full_width    = false;
	$is_page_on_front = is_front_page() && 'page' === get_option( 'show_on_front' );

	if (
		$is_page_on_front
		|| is_page_template( 'templates/full-width.php' )
		|| obsidian_is_page_type_archive()
	) {
		$is_full_width = true;
	}

	return apply_filters( 'obsidian_is_full_width_layout', $is_full_width );
}
endif;

/**
 * Retrieve the permalink for an archive.
 *
 * @since 1.0.0
 *
 * @param int|WP_Post $post Optional. Post to get the archive link for. Defaults to the current post.
 * @return string
 */
function obsidian_get_archive_link( $post = null ) {
	return obsidian_theme()->get_archive_link( $post );
}

if ( ! function_exists( 'obsidian_get_mapped_column_number' ) ) :
/**
 * Map number of columns greater than 5 to a new column count.
 *
 * @since 1.0.0
 */
function obsidian_get_mapped_column_number( $columns = 3 ) {
	$columns_map = array(
		'6'  => 3,
		'7'  => 4,
		'8'  => 4,
		'9'  => 3,
		'10' => 5,
	);

	if ( $columns > 5 ) {
		$columns = array_key_exists( $columns, $columns_map ) ? $columns_map[ $columns ] : 3;
	}

	return $columns;
}
endif;

/**
 * Determine if a page is the singular page of a registered type.
 *
 * @since 1.3.0
 *
 * @param string $type A registered page type.
 * @return bool
 */
function obsidian_is_page_type( $type = '' ) {
	return obsidian_theme()->page_types->is_type( $type );
}

/**
 * Determine if a page is the archive page of a registered type.
 *
 * @since 1.3.0
 *
 * @param string $type A registered page type.
 * @return bool
 */
function obsidian_is_page_type_archive( $type = '' ) {
	return obsidian_theme()->page_types->is_archive( $type );
}

/**
 * Retrieve a WP Query object with pages for a specific page type.
 *
 * @since 1.3.0
 *
 * @param int|WP_Post $post Optional. Post ID or object. Defaults to the current post.
 * @param array       $args           Optional. Default WP Query arguments. Default empty array.
 * @return object WP Query
 */
function obsidian_page_type_query( $post = 0, $args = array() ) {
	$post = get_post( $post );

	$args = wp_parse_args( $args, array(
		'post_type'      => 'page',
		'post_parent'    => $post->ID,
		'posts_per_page' => 50,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	) );

	$args = apply_filters( 'obsidian_page_type_query_args', $args );

	if ( 'date' === $args['orderby'] ) {
		$args['order'] = 'DESC';
	}

	return new WP_Query( $args );
}

/**
 * Return new WP Query object with child pages for a specific page type.
 *
 * @since 1.3.0
 *
 * @param int|WP_Post $post Optional. Post ID or object. Defaults to the current post.
 * @return object WP Query
 */
function obsidian_page_type_notice() {
	echo esc_html( sprintf(
		_x( 'There are currently not any %s available.', 'archive template label', 'obsidian' ),
		esc_html( get_the_title() )
	) );

	if ( current_user_can( 'publish_posts' ) ) :
		$notice = sprintf(
			/* translators: there is a space at the beginning of this sentence. */
			_x( ' Create a <a href="%1$s">new page</a> with this page as its <a href="%2$s">parent</a>.', 'archive template label; create page link', 'obsidian' ),
			esc_url( add_query_arg( 'post_type', 'page', admin_url( 'post-new.php' ) ) ),
			esc_url( 'https://en.support.wordpress.com/pages/page-attributes/#parent' )
		);

		echo obsidian_allowed_tags( wpautop( $notice ) ); // WPCS: XSS OK.
	endif;
}

/**
 * Display body schema markup.
 *
 * @since 1.1.0
 */
function obsidian_body_schema() {
	$schema = 'http://schema.org/';
	$type   = 'WebPage';

	if ( is_home() || is_singular( 'post' ) || is_category() || is_tag() ) {
		$type = 'Blog';
	} elseif ( is_author() ) {
		$type = 'ProfilePage';
	} elseif ( is_search() ) {
		$type = 'SearchResultsPage';
	}

	$type = apply_filters( 'obsidian_body_schema', $type );

	printf(
		'itemscope="itemscope" itemtype="%1$s%2$s"',
		esc_attr( $schema ),
		esc_attr( $type )
	);
}

if ( ! function_exists( 'obsidian_allowed_tags' ) ) :
/**
 * Allow only the allowedtags array in a string.
 *
 * @since 1.0.1
 *
 * @link https://www.tollmanz.com/wp-kses-performance/
 *
 * @param  string $string The unsanitized string.
 * @return string         The sanitized string.
 */
function obsidian_allowed_tags( $string ) {
	global $allowedtags;

	$theme_tags = array(
		'a'    => array(
			'href'     => true,
			'itemprop' => true,
			'rel'      => true,
			'title'    => true,
		),
		'span' => array(
			'class' => true,
		),
		'time' => array(
			'class'    => true,
			'datetime' => true,
			'itemprop' => true,
		),
	);

	return wp_kses( $string, array_merge( $allowedtags, $theme_tags ) );
}
endif;

if ( ! function_exists( 'obsidian_credits' ) ) :
/**
 * Theme credits text.
 *
 * @since 1.0.0
 */
function obsidian_credits() {
	echo obsidian_get_credits();
}
endif;

if ( ! function_exists( 'obsidian_get_credits' ) ) :
/**
 * Retrieve theme credits text.
 *
 * @since 1.0.0
 *
 * @param string $text Text to display.
 * @return string
 */
function obsidian_get_credits() {
	$text = sprintf( esc_html__( '%s by AudioTheme.', 'obsidian' ),
		'<a href="https://audiotheme.com/view/obsidian/">Obsidian music theme</a>'
	);

	return apply_filters( 'obsidian_credits', $text );
}
endif;

<?php
/**
 * The template for displaying a message when there aren't any videos.
 *
 * @package Obsidian
 * @since 1.0.0
 */

$post_type        = 'audiotheme_video';
$post_type_object = get_post_type_object( $post_type );
?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'obsidian' ); ?></h1>
		<?php obsidian_post_type_navigation( $post_type ); ?>
	</header>

	<div class="page-content">
		<?php if ( current_user_can( 'publish_posts' ) ) : ?>
			<p>
				<?php
				echo obsidian_allowed_tags( sprintf( _x( 'Ready to publish your first video? <a href="%1$s">Get started here</a>.', 'add post type link', 'obsidian' ),
					esc_url( add_query_arg( 'post_type', $post_type_object->name, admin_url( 'post-new.php' ) ) )
				) );
				?>
			</p>
		<?php else : ?>
			<p>
				<?php esc_html_e( "There currently aren't any videos available.", 'obsidian' ); ?>
			</p>
		<?php endif; ?>
	</div>
</section>

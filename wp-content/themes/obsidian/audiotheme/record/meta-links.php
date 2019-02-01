<?php
/**
 * The template used for displaying a meta links on single record pages.
 *
 * @package Obsidian
 * @since 1.0.0
 */

if ( $links = get_audiotheme_record_links() ) :
?>

	<div class="meta-links">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Record Links', 'obsidian' ); ?></h2>
		<ul>
			<?php foreach ( $links as $link ) : ?>
				<li>
					<a class="button js-maybe-external" href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['name'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

<?php
endif;

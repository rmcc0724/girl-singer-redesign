<?php
/**
 * Template to display a Recent Posts widget in the Home Widgets widget area.
 *
 * @package Obsidian
 * @since 1.0.0
 */
?>

<div class="recent-posts-wrapper">
	<?php
	if ( ! empty( $title ) ) :
		echo $before_title . esc_html( $title ) . $after_title;
	endif;
	?>

	<span class="recent-posts-links">
		<?php
		if ( $show_feed_link ) :
			printf( '<a class="recent-posts-feed-link" href="%s" title="%1$s"><span class="screen-reader-text">%2$s</span></a>',
				esc_url( $feed_link ),
				esc_html__( 'Feed', 'obsidian' )
			);
		endif;
		?>

		<?php
		printf( '<a class="recent-posts-archive-link" href="%s">%s</a>',
			esc_url( get_post_type_archive_link( $post_type ) ),
			esc_html( get_post_type_object( $post_type )->labels->all_items )
		);
		?>
	</span>

	<?php if ( $loop->have_posts() ) : ?>

		<?php
		$columns = obsidian_get_mapped_column_number( $number );

		$classes = array(
			'block-grid',
			'block-grid--gutters',
			'block-grid-' . absint( $columns ),
		);

		if ( 'audiotheme_video' === $post_type ) {
			$classes[] = 'block-grid--16x9';
		}

		$classes = array_unique( apply_filters( 'obsidian_audiotheme_widget_recent_posts_classes', $classes ) );
		?>

		<ul class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

				<li class="block-grid-item">
					<?php
					if ( 'audiotheme_record' === $post_type || 'audiotheme_video' === $post_type ) {
						$size = 'audiotheme_video' === $post_type ? 'obsidian-16x9' : 'post-thumbnail';
						printf( '<a class="block-grid-item-thumbnail" href="%s">%s</a>',
							esc_url( get_permalink() ),
							get_the_post_thumbnail( get_the_ID(), $size )
						);
					}
					?>

					<?php the_title( '<h3 class="block-grid-item-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>

					<?php
					if ( $show_date ) :
						if ( 'audiotheme_record' === get_post_type() ) :
							$date_html = '';

							if ( $release_year = get_audiotheme_record_release_year() ) :
								$date_html = sprintf( '<span class="published"><span class="prefix">%s</span> %s</span>',
									__( 'Released', 'obsidian' ),
									$release_year
								);
							endif;
						else :
							$date_html = obsidian_get_entry_date();
						endif;

						printf( '<div class="block-grid-item-meta">%s</div>',
							obsidian_allowed_tags( apply_filters( 'audiotheme_widget_recent_posts_date_html', $date_html, $instance ) )
						);
					endif;
					?>

					<?php
					if ( $show_excerpts ) :
						$excerpt = wpautop( wp_html_excerpt( get_the_excerpt(), $excerpt_length, '&hellip;' ) );
						$excerpt = apply_filters( 'audiotheme_widget_recent_posts_excerpt', $excerpt, $loop->post, $instance );

						printf( '<div class="block-grid-item-summary">%s</div>',
							wp_kses( $excerpt, array( 'p' => array() ) )
						);
					endif;
					?>
				</li>

			<?php endwhile; ?>

		</ul>

	<?php endif; ?>
</div>

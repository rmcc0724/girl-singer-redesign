<?php
/**
 * Track widget.
 *
 * Display a selected track in a widget area.
 *
 * @package   AudioTheme\Widgets
 * @copyright Copyright 2012 AudioTheme
 * @license   GPL-2.0+
 * @link      https://audiotheme.com/
 * @since     1.0.0
 */

/**
 * Track widget class.
 *
 * @package AudioTheme\Widgets
 * @since   1.0.0
 */
class AudioTheme_Widget_Track extends WP_Widget {
	/**
	 * Setup widget options.
	 *
	 * @since 1.0.0
	 * @see WP_Widget::construct()
	 */
	public function __construct() {
		$widget_options = array(
			'classname'                   => 'widget_audiotheme_track',
			'customize_selective_refresh' => true,
			'description'                 => __( 'Display a track.', 'audiotheme' )
		);

		parent::__construct( 'audiotheme-track', __( 'Track (AudioTheme)', 'audiotheme' ), $widget_options );
	}

	/**
	 * Default widget front end display method.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Args specific to the widget area (sidebar).
	 * @param array $instance Widget instance settings.
	 */
	public function widget( $args, $instance ) {
		if ( empty( $instance['post_id'] ) ) {
			return;
		}

		$instance['title_raw'] = $instance['title'];
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? get_the_title( $instance['post_id'] ) : $instance['title'], $instance, $this->id_base );
		$instance['title'] = apply_filters( 'audiotheme_widget_title', $instance['title'], $instance, $args, $this->id_base );

		echo $args['before_widget'];

			// Output filter is for backwards compatibility.
		if ( $output = apply_filters( 'audiotheme_widget_track_output', '', $instance, $args ) ) {
			echo ( empty( $instance['title'] ) ) ? '' : $args['before_title'] . $instance['title'] . $args['after_title'];
			echo $output;
		} else {
			$post = get_post( $instance['post_id'] );

			$image_size = apply_filters( 'audiotheme_widget_track_image_size', 'thumbnail', $instance, $args );
			$image_size = apply_filters( 'audiotheme_widget_track_image_size-' . $args['id'], $image_size, $instance, $args );

			$data                 = array();
			$data['args']         = $args;
			$data['after_title']  = $args['after_title'];
			$data['before_title'] = $args['before_title'];
			$data['image_size']   = $image_size;
			$data['post']         = get_post( $instance['post_id'] );
			$data                 = array_merge( $instance, $data );

			$template = audiotheme_locate_template( array( "widgets/{$args['id']}_track.php", 'widgets/track.php' ) );
			audiotheme_load_template( $template, $data );
		}

		echo $args['after_widget'];
	}

	/**
	 * Form to modify widget instance settings.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Current widget instance settings.
	 */
	public function form( $instance ) {
		global $wpdb;

		$instance = wp_parse_args( (array) $instance, array(
			'link_text' => '',
			'post_id'   => '',
			'text'      => '',
			'title'     => '',
		) );

		$title = wp_strip_all_tags( $instance['title'] );

		$tracks = $wpdb->get_results( "SELECT p.ID, p.post_title, p2.post_title AS record
			FROM $wpdb->posts p
			INNER JOIN $wpdb->posts p2 ON p.post_parent=p2.ID
			WHERE p.post_type='audiotheme_track'
			ORDER BY p2.post_title ASC, p.post_title ASC" );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'audiotheme' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_id' ); ?>"><?php _e( 'Track:', 'audiotheme' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'post_id' ); ?>" id="<?php echo $this->get_field_id( 'post_id' ); ?>" class="widefat">
				<option value=""></option>
				<?php
				$last_record = '';
				foreach ( $tracks as $key => $track ) {
					echo ( 0 !== $key && $last_record !== $track->record ) ? '</optgroup>' : '';
					echo ( $last_record !== $track->record ) ? '<optgroup label="' . esc_attr( $track->record ) . '">' : '';
					$last_record = $track->record;

					printf(
						'<option value="%s"%s>%s</option>',
						$track->ID,
						selected( $instance['post_id'], $track->ID, false ),
						esc_html( $track->post_title )
					);
				}
				echo '</optgroup>';
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Description:', 'audiotheme' ); ?></label>
			<textarea name="<?php echo $this->get_field_name( 'text' ); ?>" id="<?php echo $this->get_field_id( 'text' ); ?>" cols="20" rows="5" class="widefat"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_text' ); ?>"><?php _e( 'More Link Text:', 'audiotheme' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'link_text' ); ?>" id="<?php echo $this->get_field_id( 'link_text' ); ?>" value="<?php echo esc_attr( $instance['link_text'] ); ?>" class="widefat">
		</p>
		<style type="text/css">
		optgroup option { margin-left: 12px;}
		</style>
		<?php
	}

	/**
	 * Save widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance New widget settings.
	 * @param array $old_instance Old widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = wp_parse_args( $new_instance, $old_instance );

		$instance['title'] = wp_strip_all_tags( $new_instance['title'] );
		$instance['text'] = wp_kses_data( $new_instance['text'] );
		$instance['link_text'] = wp_kses_data( $new_instance['link_text'] );

		return $instance;
	}
}

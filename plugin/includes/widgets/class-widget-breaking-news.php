<?php
/**
 * Breaking News Widget
 */
class HelpOfAi_Breaking_News_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'helpofai_breaking_news',
			'HelpOfAi: Breaking News',
			array( 'description' => 'Displays the latest breaking news headlines.' )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$query = new WP_Query( array(
			'posts_per_page' => 5,
			'post_status'    => 'publish',
		) );

		if ( $query->have_posts() ) {
			echo '<ul style="list-style: none; padding: 0;">';
			while ( $query->have_posts() ) {
				$query->the_post();
				echo '<li style="margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(0,0,0,0.05);">';
				echo '<a href="' . get_permalink() . '" style="text-decoration: none; color: inherit; font-weight: 500; font-size: 0.95rem;">' . get_the_title() . '</a>';
				echo '</li>';
			}
			echo '</ul>';
		}
		wp_reset_postdata();

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : 'Breaking News';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}
}

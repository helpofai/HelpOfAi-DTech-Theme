<?php
/**
 * Recent Posts with Thumbnails Widget
 */
class HelpOfAi_Recent_Posts_Thumbnails_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'helpofai_recent_posts_thumbs',
			'HelpOfAi: Recent Posts + Thumbnails',
			array( 'description' => 'Displays latest posts with featured images.' )
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
			echo '<div class="helpofai-recent-posts-list">';
			while ( $query->have_posts() ) {
				$query->the_post();
				?>
				<div class="recent-post-item">
					<div class="recent-post-thumb">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array(80, 80) ); ?></a>
						<?php else : ?>
							<div class="thumb-placeholder"></div>
						<?php endif; ?>
					</div>
					<div class="recent-post-info">
						<a href="<?php the_permalink(); ?>" class="recent-post-title"><?php the_title(); ?></a>
						<span class="recent-post-date"><?php echo get_the_date(); ?></span>
					</div>
				</div>
				<?php
			}
			echo '</div>';
		}
		wp_reset_postdata();

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : 'Recent Posts';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}
}

<?php
/**
 * Categories with Icons Widget
 */
class HelpOfAi_Categories_Icons_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'helpofai_categories_icons',
			'HelpOfAi: Categories + Icons',
			array( 'description' => 'Displays categories with professional icons.' )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$categories = get_categories( array(
			'orderby' => 'name',
			'order'   => 'ASC',
            'hide_empty' => 0
		) );

		if ( ! empty( $categories ) ) {
			echo '<ul class="helpofai-category-list">';
			foreach ( $categories as $category ) {
                $icon = 'dashicons-category';
                $slug = strtolower($category->slug);
                if (strpos($slug, 'tech') !== false) $icon = 'dashicons-laptop';
                elseif (strpos($slug, 'news') !== false) $icon = 'dashicons-megaphone';
                elseif (strpos($slug, 'business') !== false) $icon = 'dashicons-chart-bar';
                elseif (strpos($slug, 'design') !== false) $icon = 'dashicons-art';
                
				echo '<li>';
				echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">';
                echo '<span class="cat-icon dashicons ' . $icon . '"></span>';
                echo '<span class="cat-name">' . esc_html( $category->name ) . '</span>';
                echo '<span class="cat-count">' . $category->count . '</span>';
                echo '</a>';
				echo '</li>';
			}
			echo '</ul>';
		}

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : 'Categories';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}
}

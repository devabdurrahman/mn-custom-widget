<?php  

class Mn_Custom_Widget extends WP_Widget{
	//Constructor
	public function __construct(){
		parent::__construct(
			"Mn_Custom_Widget",
			"MN Custom Widget",
			array(
				"description" => "display recent posts or static message"
			)
		);
	}

	//Display widget to admin panel
	public function form($instance){

		$mn_title = !empty($instance['title']) ? $instance['title'] : " ";
		$mn_display_type = !empty($instance['display_type']) ? $instance['display_type'] : " ";
		$mn_posts_number = !empty($instance['posts_number']) ? $instance['posts_number'] : " ";
		$mn_message = !empty($instance['message']) ? $instance['message'] : " ";

		?>
		<p>
			<label for="<?php echo $this->get_field_name('title'); ?>">Title</label>
			<input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" class="widefat" value="<?php echo $mn_title; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_name('display_type'); ?>">Display Type</label>
			<select name="<?php echo $this->get_field_name('display_type'); ?>" 
			        id="<?php echo $this->get_field_id('display_type'); ?>" 
			        class="widefat mn_dd_options" value="<?php echo $mn_display_type; ?>">
			    <option value="recent_posts">Recent Posts</option>
			    <option value="static_message">Static Message</option>
			</select>

		</p>

		<p id="mn_display_recent_posts">
			<label for="<?php echo $this->get_field_name('posts_number'); ?>">Number of Posts</label>
			<input type="number" name="<?php echo $this->get_field_name('posts_number'); ?>" id="<?php echo $this->get_field_id('posts_number'); ?>" value="<?php echo $mn_posts_number; ?>" class="widefat">
		</p>

		<p id="Mn_Custom_Widget_static_message">
			<label for="<?php echo $this->get_field_name('message'); ?>">Your Message</label>
			<input type="text" name="<?php echo $this->get_field_name('message'); ?>" id="<?php echo $this->get_field_id('message'); ?>" class="widefat" value="<?php echo $mn_message; ?>">
		</p>

		<?php
	}

	// save widget settings to wordpress
	public function update( $new_instance, $old_instance){

		$instance = []; //title, display_type, posts_number, message

		$instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : " ";

		$instance['display_type'] = !empty($new_instance['display_type']) ? sanitize_text_field($new_instance['display_type']) : " ";

		$instance['posts_number'] = !empty($new_instance['posts_number']) ? sanitize_text_field($new_instance['posts_number']) : " ";

		$instance['message'] = !empty($new_instance['message']) ? sanitize_text_field($new_instance['message']) : " ";

		return $instance;
	}

	// Display widget to frontend
	public function widget( $args, $instance ){

    $title = apply_filters( "widget_title", $instance['title'] );

    echo $args['before-widget'];
        echo $args['before-title'];
            echo $title;
        echo $args['after-title'];

        // Check for display type
        if($instance['display_type'] == 'static_message'){
            echo '<br><p>' . $instance['message'] . '</p>';
        } elseif($instance['display_type'] == 'recent_posts'){

            // Correct WP_Query
            $query = new WP_Query(array(
                "posts_per_page" => $instance['posts_number'],  // How many posts to display
                "post_type"      => "post",  // Type of posts (standard posts)
                "post_status"    => "publish"  // Only published posts
            ));

            if($query->have_posts()){
                echo '<ul>';
                while($query->have_posts()){
                    $query->the_post();
                    ?>
                    <li>
                        <a href="<?php echo get_the_permalink();?>"><?php echo get_the_title(); ?></a>
                    </li>
                    <?php
                }
                echo '</ul>';
            } else {
                echo "no posts found";
            }
            wp_reset_postdata();  // Reset post data after custom query
        }
    echo $args['after-widget'];
}


}
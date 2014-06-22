<?php
defined('ABSPATH') or die('No !');

if ( ! defined( 'IFW_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

class JM_IFW_Widget extends WP_Widget {

	public $textdomain = 'jm-ifw';
	
	// constructor
	function __construct() {
		
		$widget_ops = array('classname' => 'ifw-widget', 'description' => __( 'This widget adds your Instagram Feed to your website.', $this->textdomain ) );
		$control_ops = array();
		parent::WP_Widget( 'ifw', __('Instagram Feed Widget', $this->textdomain ) , $widget_ops, $control_ops );
		
		
		add_action('wp_enqueue_scripts', array( $this, 'basic_styles') );
		
	}



	// widget form creation
	function form($instance) {	
		
		// Check values if( $instance) 
		$title 	  		= $instance ? esc_attr($instance['title']) : ''; 
		$number   		= $instance ? (int) $instance['number'] : 1;
		$cache    		= $instance ? (int) $instance['cache'] : 1800;
		$access_token 	= $instance ? esc_attr( $instance['access_token'] ) : '';
		$user_id 		= $instance ? (int) $instance['user_id'] : '';
		$user_name 		= $instance ? esc_attr( $instance['user_name'] ) : '';
		?>
		
		
		<!--
		
		TITLE
		
		
		
		-->
		
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', $this->textdomain); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
		
		
		<!--
		
		
		USER NAME
		
		
		-->
		
		
		<p>
		<label for="<?php echo $this->get_field_id('user_name'); ?>"><?php _e('Enter your user name (Instagram account)', $this->textdomain); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('user_name'); ?>" name="<?php echo $this->get_field_name('user_name'); ?>" type="text" value="<?php echo $user_name; ?>" />
		</p>
		
		<!--
		
		
		USER ID
		
		
		-->
		
		<p>
		<label for="<?php echo $this->get_field_id('user_id'); ?>"><?php _e('Enter user ID', $this->textdomain); ?></label> <a href="<?php echo esc_url('//wordpress.org/plugins/jm-instagram-feed-widget/faq/');?>" title="<?php esc_attr_e('See FAQ', $this->textdomain);?>"><span class="dashicons-before dashicons-editor-help"></span></a>
		<input class="widefat" id="<?php echo $this->get_field_id('user_id'); ?>" name="<?php echo $this->get_field_name('user_id'); ?>" type="text" value="<?php echo $user_id; ?>" />
		</p>
		
		
		
		<!--
		
		
		ACCESS TOKEN
		
		
		-->
		
		<p>
		<label for="<?php echo $this->get_field_id('access_token'); ?>"><?php _e('Enter access token', $this->textdomain); ?></label> <a href="<?php echo esc_url('//wordpress.org/plugins/jm-instagram-feed-widget/faq/');?>" title="<?php esc_attr_e('See FAQ', $this->textdomain);?>"><span class="dashicons-before dashicons-editor-help"></span></a>
		<input class="widefat" id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" type="text" value="<?php echo $access_token; ?>" />
		</p>
		
		<!--
		
		
		NUMBER
		
		
		-->
		
		<p>
		<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('How many pics do you want to show?', $this->textdomain); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" min="1" name="<?php echo $this->get_field_name('number'); ?>" type="number" value="<?php echo $number; ?>" />
		</p>
		
		<!--
		
		CACHE
		
		
		-->
		
		<p>
		<label for="<?php echo $this->get_field_id('cache'); ?>"><?php _e('Set cache ( mininum : 30 min )', $this->textdomain); ?></label>
		<select style="width:300px;" id="<?php echo $this->get_field_id('cache'); ?>" name="<?php echo $this->get_field_name('cache'); ?>">
		<option value="1800" <?php selected($cache, '1800'); ?>><?php _e('Low (refresh every 30 min)',$this->textdomain);?> </option>
		<option value="14400" <?php selected($cache, '14400'); ?>><?php _e('Normal (refresh every 4 hours)',$this->textdomain);?> </option>
		<option value="43200" <?php selected($cache, '43200'); ?>><?php _e('Aggressive (refresh only 2 times per day)',$this->textdomain);?> </option>			
		<option value="86400" <?php selected($cache, '86400'); ?>><?php _e('Very Aggressive (refresh only once a day)',$this->textdomain);?> </option>
		</select>
		</p>
		
		
		<?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		
		$instance = $old_instance;
		
		// Fields
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['access_token']	= strip_tags( esc_attr( $new_instance['access_token'] ) );
		$instance['user_name']		= strip_tags( esc_attr( $new_instance['user_name'] ) );
		$instance['user_id']		= (int) $new_instance['user_id'];
		$instance['number'] 		= (int) $new_instance['number'];
		$instance['cache'] 			= (int) $new_instance['cache'];
		
		$this->delete_cache();
		
		return $instance;
		
	}

	// widget display
	function widget($args, $instance) {
		
		
		echo $args['before_widget'];
		
		
		// Display the widget
		echo '<!-- JM Instagram Feed Widget '.IFW_VERSION.' -->'."\n";
		echo '<div class="widget-text jm-ifw">';
		
		$cached = get_site_transient( '_instagram_feed' );
		
		// Check if code exist in cache.
		if( $cached === false ) {
			
			// these are the widget options
			$title 				= apply_filters('widget_title', $instance['title']);
			$num_items			= $instance['number'];
			$time_cache			= $instance['cache'];
			$user_name			= $instance['user_name'];
			$user_id			= $instance['user_id'];
			$access_token		= $instance['access_token'];
			
			ob_start();
			
			// Check if title is set
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'] ;
			}
			
			//Supply a user id and an access token
			echo $this->get_pics($user_id, $access_token, $num_items, $user_name);
			
			echo '</div>';
			
			$cached = ob_get_contents();
			ob_end_clean();

			// Add to cache
			set_site_transient( '_instagram_feed', $cached, $time_cache );
			
		}
		
		echo $cached;
		
		echo '<!-- /JM Instagram Feed Widget '.IFW_VERSION.' -->'."\n";	
		
		echo $args['after_widget'];
	}
	
	
	// get pics from Instagram
	private function get_pics($user_id, $access_token, $num_items, $user_name){

		// use the appropriate APIs to make the call
		$call 	= wp_remote_retrieve_body(wp_remote_get("https://api.instagram.com/v1/users/{$user_id}/media/recent?access_token={$access_token}", array("timeout" => 120) ) );
		$result = json_decode($call);
		
		$output = '';
		
		// User datas
		foreach ( (array) $result->data as $info ) {
			
			$output .= '<a href="http://instagram.com/'.$user_name.'" title="'.esc_attr__('See my profile on Instagram', $this->textdomain).'"><img width="'.apply_filters('instagram_img_size', 32).'" height="'.apply_filters('instagram_img_size', 32).'" src="'.$info->user->profile_picture.'"/> '.$info->user->username.'</a>';
			break;
		}
		
		
		$output .= '<ul class="'.apply_filters('instagram_feed_container_class', 'instagram-feed-container').'">';
		
		// let's do it differently becaus this time we may need more than 1 element
		$i   	= 1;
		foreach ( (array) $result->data as $info ) {
			
			// User pics
			
			if ( $info->type == 'image' ) {
				
				$output .= '<li class="'.apply_filters('instagram_list_items_class', 'instagram-list-items').'"><a href="'. $info->link.'"><figure><img class="'.apply_filters('instagram_img_class', 'instagram-img').'" src="'.$info->images->standard_resolution->url.'"><figcaption>'.$info->caption.'</figcaption></figure></a></li>';	
				
				$i++;
				if ($i > $num_items) break;// this could have been done in a more accurate way with the parameter count of the GET /users/user-id/media/recent
				
			}
			
		}
		
		$output .= '</ul>';
		
		$badge   = '<a href="http://instagram.com/'.$user_name.'?ref=badge" class="ig-b- ig-b-v-24"><img src="'.esc_url('//badges.instagram.com/static/images/ig-badge-view-24.png').'" alt="Instagram" /></a>';
		
		$output .= apply_filters('instagram_show_badge', $badge);
		
		return $output;
		
	}
	
	
	// add basic styles
	public function basic_styles(){
		
		wp_register_style('basic-instagram-widget-styles', IFW_CSS_URL.'basic-styles.css');
		wp_enqueue_style('basic-instagram-widget-styles');
		
	}
	
	
	// when cache need to be deleted
	private function delete_cache() {
		
		delete_site_transient( '_instagram_feed' );
		
	}


}
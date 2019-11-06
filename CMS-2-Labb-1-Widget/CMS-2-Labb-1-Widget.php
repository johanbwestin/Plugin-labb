<?php
/*
Plugin Name: CMS 2 Labb 1 Widget
Description: Labb uppgift 2
Author: Johan Westin
Version: 1.0
*/

// Registrera att widget klassen finns.
add_action( 'widgets_init', function(){
	register_widget( 'YouTube_Widget' );
});

// RSS_Widget klass som extendar WP_Widget klassen. 
class YouTube_Widget extends WP_Widget {
	
	// Konstruktor
    function __construct(){
		
		// Anropa förälder konstruktorn i WP_Widget klassen
        parent::__construct(
            'uppgift_widget', // ID för widgeten
            esc_html__('YouTube Widget', 'youtube-widget'), // Namn på widgeten
            array('description' => esc_html__('En widget som visar youtube videos', 'youtube-widget'),  // Beskrivning av widget
            )
        );    
    }

	// Funktion som ritar ut widgeten i frontend
    public function widget($args, $instance){
		
		// Om ingen ID är angiven i admin. Avbryt direkt
        if ( empty($instance['id']) ){
			echo '<b>FEL: Ingen ID angiven för YouTube Widget!</b>';
            return;
        }
		
		// Skriv ut element före widget
		echo $args['before_widget'];
	  
		// Skriv ut titel på widgeten
		echo $args['before_title'] . apply_filters('widget_title', esc_html__('YouTube Widget', 'youtube-widget') ) . $args['after_title'];
		
		// TODO - Gör något med feeden
		$id = $instance['id'];
		$autoplay = $instance['autoplay'];
		$controls = $instance['controls'];

		if (!$controls) {
			$controls = 0;
		}

		if (!$autoplay) {
			$autoplay = 0;
		}

 		echo '<p><b>RSS ID: </b>' . $id . '</p>';
		echo '<p><b># autoplay: </b>' . $autoplay . '</p>';
		echo '<p><b># controls: </b>' . $controls . '</p>';
		
		echo '<iframe 
			width="560" 
			height="315" 
			src="https://www.youtube.com/embed/'.$id.'?controls='.$controls.'&autoplay='.$autoplay.'" 
			frameborder="0" 
			allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
			allowfullscreen>
		</iframe>';
		// Skriv ut element efter widget
		echo $args['after_widget'];
    }

	// Funktion som ritar ut formuläret i admin för Widgeten
	public function form( $instance ) {
		
		// Hämta tidigare sparat värde för antal element. Om inget finns sätt värdet till 5.
		$autoplay = ! empty( $instance['autoplay'] ) ? 1 : 0;
		$controls = ! empty( $instance['controls'] ) ? 1 : 0;
		
		// Admin fält för altal element
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); // ID på widget fältet ?>">
				<?php esc_attr_e( 'Autoplay', 'youtube-widget' ); // Skriver ut översatt text i youtube-widget scope ?>
			</label> 
			<input class="widefat" 
				id="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); // ID på widget fältet ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'autoplay' ) ); // Namn på widget fältet ?>" 
				type="checkbox" 
				<?php checked(isset($instance['autoplay']) ? $instance['autoplay'] : 0); ?>>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'controls' ) ); // ID på widget fältet ?>">
				<?php esc_attr_e( 'Controls', 'youtube-widget' ); // Skriver ut översatt text i youtube-widget scope ?>
			</label> 
			<input class="widefat" 
				id="<?php echo esc_attr( $this->get_field_id( 'controls' ) ); // ID på widget fältet ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'controls' ) ); // Namn på widget fältet ?>" 
				type="checkbox" 
				<?php checked(isset($instance['controls']) ? $instance['controls'] : 0); ?>>
		</p>
		<?php 
        
		// Hämta sparad ID annars sätt till default text 
		$id = ! empty( $instance['id'] ) ? $instance['id'] : esc_html__( 'ID till Youtube', 'youtube-widget' );
		
		// Admin fält för ID.
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>">
				<?php esc_attr_e( 'ID till Youtube:', 'youtube-widget' ); ?>
			</label> 
			<input class="widefat" 
				id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>" 
				type="text" 
				value="<?php echo esc_attr( $id ); ?>">
		</p>
		<?php 
    }
    
	// Funktion som körs när admin formuläret sparas
    public function update($new_instance, $old_instance){
		
		// Hämta nytt antal element om det finns. Annars sätt till false.
		$instance['autoplay'] = (! empty($new_instance['autoplay']) ? 1 : 0 );
		
        $instance['controls'] = (! empty($new_instance['controls']) ? 1 : 0 );
		
		// Hämta ny ID om det finns en. Annars sätt till tom sträng
        $instance['id'] = (!empty($new_instance['id']) ? $new_instance['id'] : '' );
		
        return $instance;
    }
}

// Style
// function wpse_load_plugin_css() {
//     $plugin_id = plugin_dir_id( __FILE__ );

//     wp_enqueue_style( 'style', $plugin_id . 'css/style.css' );
// }
// add_action( 'wp_enqueue_scripts', 'wpse_load_plugin_css', 11 );
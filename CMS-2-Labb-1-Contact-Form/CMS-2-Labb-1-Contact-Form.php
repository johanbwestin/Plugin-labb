<?php
/*
Plugin Name: CMS 2 Labb 1 Contact Form
Description: Labb uppgift 3
Author: Johan Westin
Version: 1.0
*/


add_shortcode( 'contact', 'contact_form_func' );
function contact_form_func ( $atts, $content = null) {
	$a = shortcode_atts( array(
		'placeholder' => 'Skriv ett meddelande',
		'receiver' => '',
		'success-text' => 'Ditt mail har skickats!',
	), $atts );
	$placeholder = $a['placeholder'];
	$receiver = $a['receiver'];
	$success_text = $a['success-text'];
	$nonce_field = wp_nonce_field( 'msf_form_submit', 'msf_nonce', true, false );

	$display = '<h4 class="description">' . $content . '</h4>
	<form method="post" class="msf-form" action="' . admin_url( 'admin-post.php' ) . '">
		<label for="subject">Subject</label> <br>
		<input id="subject" type="text" required="required" name="subject"> <br>
		<label for="message">Message</label>
		<textarea placeholder="' . $placeholder . '" id="message" name="message" rows="8" cols="80"></textarea>
		<input type="submit" value="Subscribe Now">
		<input type="hidden" name="receiver" value="' . $receiver . '">
		<input type="hidden" name="success_text" value="' . $success_text . '">
		<input type="hidden" name="action" value="submit">
		' . $nonce_field . '
	</form>';
	return $display;
}

add_action( 'admin_post_submit', 'form_hook' );
function form_hook() {
	$message = $_POST['message'];
	$to = get_option('admin_email');
	$receiver = $_POST['receiver'];
	$success_text = $_POST['success_text'];

	$sent = wp_mail($to, $subject, strip_tags($message));
	  if($sent) {
		  $display = $success_text;
	  }//message sent!
	  else  {
		  $display = "Något gick fel";	
	}//message wasn't sent
	  
	$url = add_query_arg( 'msf_success', 'true', $_SERVER['HTTP_REFERER'] );
	wp_redirect( $url );
	return $display;
}




//Style
add_action('wp_enqueue_scripts','register_my_scripts', 11);

function register_my_scripts(){
    wp_enqueue_style( 'style', plugins_url( 'css/style.css' , __FILE__ ) );
}
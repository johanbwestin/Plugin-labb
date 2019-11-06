<?php
/*
Plugin Name: CMS 2 Labb 1 Widget
Description: Labb uppgift 2
Author: Johan Westin
Version: 1.0
*/

function button_func($atts, $content = null) {
    $a = shortcode_atts( array(
		'text' => 'Knapp',
		'url' => '',
		'background' => 'gray',
		'width' => '',
		'style' => '',
    ), $atts );
    // var_dump($a['text']);
    $url = '';
    $style = '';
    $width = '';
    $background = ' style="' . ' background:' . $a['background'] . '"';
    
    if ( $a['style'] ) {
      $background = ' style="' . $a['style'] . ';' . ' background:' . $a['background'] . '"';
    }
    if ( $a['width'] ) {
      $background = ' style="' . $a['style'] . ';' . ' background:' . $a['background'] . ';' . ' width:' . $a['width'] . 'px"';
      // $width = ' width="' . $a['width'] . '"';
    }
    if ( $a['url'] ) {
      $url = ' href="' . $a['url'] . '"';
    }
    return '<a' . $url . '><button class="button" '. $background . $width .'>' . $a['text'] . '</button></a> ';
}

add_shortcode( 'button', 'button_func' );


// Style
function wpse_load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'style', $plugin_url . 'css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'wpse_load_plugin_css', 11 );
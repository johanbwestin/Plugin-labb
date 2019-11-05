<?php
/*
Plugin Name: CMS 2 Labb 1 Shortcode
Description: Labb uppgift 1
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
    return '<a ' ($a['url']) ? 'href="'. $a['url']  : "".';"><button class="button" style="' . $a['style'] .';">' . $a['text'] . '</button></a> ';
}

add_shortcode( 'button', 'button_func' );

// [bartag foo="foo-value"]
// function bartag_func( $atts ) {
// 	$a = shortcode_atts( array(
// 		'foo' => 'something',
// 		'bar' => 'something else',
// 	), $atts );

// 	return "foo = {$a['foo']}";
// }
// Style
function wpse_load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'style', $plugin_url . 'css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'wpse_load_plugin_css', 11 );
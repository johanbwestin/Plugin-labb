<?php
/*
Plugin Name: CMS 2 Labb 2 Wrapped
Description: Labb uppgift 2 Lägger till två input fält och visar informationen i backend.
Author: Johan Westin
Version: 1.0
*/

// Creating Checkoutfields
function wrapped_checkbox_field( $checkout ) {
  echo '<div class=""><h3>'.__('Package wrapped? ').'</h3>';
  woocommerce_form_field( 'wrapp_checkbox', array(
      'type'          => 'checkbox',
      'label'         => __('Check if you want package to be wrapped'),
      'required'      => false,
  ), $checkout->get_value( 'wrapp_checkbox' ));
  woocommerce_form_field( 'wrapp_message', array(
    'type'          => 'textarea',
    'label'         => __('Message'),
    'placeholder'         => __('Message for the reciever.'),
    'required'      => false,
  ), $checkout->get_value( 'wrapp_message' ));
  echo '</div>';
}
add_action('woocommerce_after_order_notes', 'wrapped_checkbox_field');

function checkout_order_meta( $order_id ) {
  if ($_POST['wrapp_checkbox']){
    update_post_meta( $order_id, 'Package wrapping', esc_attr($_POST['wrapp_checkbox']));
  } 
  if ($_POST['wrapp_message']){
    update_post_meta( $order_id, 'Message', esc_attr($_POST['wrapp_message']));
  } 
}
add_action('woocommerce_checkout_update_order_meta', 'checkout_order_meta');

// Adding 2 columns on order table
function wrapped_column($columns)
{
  $reordered_columns = array();
  
  // Inserting columns to a specific location
  foreach( $columns as $key => $column){
    $reordered_columns[$key] = $column;
    if( $key ==  'order_status' ){
      // Inserting after "Status" column
      $reordered_columns['wrapped'] = __( 'Wrapped','theme_domain');
      $reordered_columns['message'] = __( 'Message','theme_domain');
    }
  }
  return $reordered_columns;
}
add_filter( 'manage_edit-shop_order_columns', 'wrapped_column', 20 );

// Adding custom fields meta data for each new column (example)
function column_content( $column, $post_id ) {
  switch ( $column ){
    case 'wrapped' :
      // Get custom post meta data
      $my_var_one = get_post_meta( $post_id, 'Package wrapping', true );
      if(!empty($my_var_one)) {
        echo 'Yes';
      } else {
        // Empty value case
        echo 'No';
      }
    break;
    case 'message' :
      // Get custom post meta data
      $my_var_two = get_post_meta( $post_id, 'Message', true );
      if(!empty($my_var_two)) {
        echo $my_var_two;
      } else {
        // Empty value case
        echo 'No Message';
      }
    break;
  }
}
add_action( 'manage_shop_order_posts_custom_column' , 'column_content', 20, 2 );

// Style
function plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'style', $plugin_url . 'css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'plugin_css', 11 );
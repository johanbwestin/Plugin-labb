<?php
/*
Plugin Name: CMS 2 Labb 2 Shipping
Description: Labb uppgift 3 Räknar ut fraktkostnad baserat på vikt.
Author: Johan Westin
Version: 1.0
*/


function shipping_calc( $cart_object ) {
  $total_weight = 0;
  foreach( $cart_object->get_cart() as $cart_item ){
    // Item id ($product ID or variation ID)
    if( $cart_item['variation_id'] > 0) {
      $item_id = $cart_item['variation_id'];
    } else {
      $item_id = $cart_item['product_id'];
    }
    
    // Getting the product weight
    $product_weight = get_post_meta( $item_id , '_weight', true);
    
    // Line item weight
    if ($product_weight) {
      $line_item_weight = $cart_item['quantity'] * $product_weight;
      
      $total_weight = $total_weight + $line_item_weight;
    }
  }
  if($total_weight < 1) {
    $cart_object->add_fee( 'Weight Below 1kg', '30' );
  } else if ($total_weight < 5) {
    $cart_object->add_fee( 'Weight Below 5kg', '60' );
  } else if ($total_weight < 10) {
    $cart_object->add_fee( 'Weight Below 10kg', '100' );
  } else if ($total_weight < 20) {
    $cart_object->add_fee( 'Weight Below 20kg', '200' );
  } else if ($total_weight > 20) {
    $shipping_cost = $total_weight * 10;
    $cart_object->add_fee( 'Weight Above 20kg', $shipping_cost );
  }
}
add_action('woocommerce_cart_calculate_fees', 'shipping_calc', 10, 1);














// add_filter( 'woocommerce_package_rates',  'modify_shipping_rate', 15, 2 );
// function modify_shipping_rate( $available_shipping_methods, $package ){

//     global $woocmmerce;
//     $total_weight = WC()->cart->cart_contents_weight;
    

//     var_dump($total_weight);

//     if( $total_weight < 1 ){
//       $available_shipping_methods['flat_rate:1']; //Remove flat rate for coat abobe 20$
//     }else if( $total_weight < 5 ){
//       $available_shipping_methods['flat_rate:2']; // add 2$ if weight exceeds 10KG
//     }else if( $total_weight < 10 ){
//       $available_shipping_methods['flat_rate:3']; // add 2$ if weight exceeds 10KG
//     }else if( $total_weight < 20 ){
//       $available_shipping_methods['flat_rate:4']; // add 2$ if weight exceeds 10KG
//     }else if( $total_weight > 20 ){
//       // $available_shipping_methods['flat_rate:2']; // add 2$ if weight exceeds 10KG
//     }

//     return $available_shipping_methods;
// }

// add_filter( 'woocommerce_cart_no_shipping_available_html', 'change_msg_no_available_shipping_methods', 10, 1  );
// add_filter( 'woocommerce_no_shipping_available_html', 'change_msg_no_available_shipping_methods', 10, 1 );
// function change_msg_no_available_shipping_methods( $default_msg ) {

//     $custom_msg = "Enter address to view shipping options";
//     if( empty( $custom_msg ) ) {
//       return $default_msg;
//     }

//     return $custom_msg;
// }
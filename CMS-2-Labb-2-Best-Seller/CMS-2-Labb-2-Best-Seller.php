<?php
/*
Plugin Name: CMS 2 Labb 2 Best Seller
Description: Labb uppgift 1
Author: Johan Westin
Version: 1.0
*/

function best_sell() {
  $args = array(
    'post_type' => 'product',
    'meta_key' => 'total_sales',
    'orderby' => 'meta_value_num',
    'posts_per_page' => 10,
  );
  $loop = new WP_Query( $args );
  while ( $loop->have_posts() ) : $loop->the_post(); 
  global $product;
  ?>
  <section class="best-seller">
      <?php echo get_the_post_thumbnail( $loop->post->ID, 'shop_catalog' ); ?>
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      <p><?php echo $product->get_price(); ?></p>
      <p><?php echo wp_trim_words($product->get_description(),  $num_words = 15,  $more = null ); ?></p>
  </section>
  <?php
  endwhile;
  wp_reset_query();
  return null;
}

add_shortcode( 'bestSeller', 'best_sell' );


// Style
function wpse_load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'style', $plugin_url . 'css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'wpse_load_plugin_css', 11 );
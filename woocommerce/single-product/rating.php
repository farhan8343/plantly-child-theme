<?php
/**
 * Single Product Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;
$user_id = get_the_author_ID($product->id);

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

//if ( $rating_count > 0 ) : ?>

	<div class="woocommerce-product-rating">
		
		<?php 
        	global $wpdb;
            $get = get_posts(array('author' => $user_id,'fields' => 'ids', 'post_type' => 'product','posts_per_page'=> -1,'post_status'=>'publish'));
		//print_r($get);
            $product_comments = get_comments(array('post_author'=>$user_id,'post__in'=> $get,'type' => 'review') );
            $count = count($product_comments);
            $string = implode(',',$get);

            if ( $count ) {
                $ratings = $wpdb->get_var(
                    $wpdb->prepare(
                        "
                    SELECT SUM(meta_value) FROM $wpdb->commentmeta
                    LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
                    WHERE meta_key = 'rating'
                    AND comment_post_ID in (" . $string . ")
                    AND comment_approved = '1'
                    AND meta_value > 0
                        "
                    )
                );
                $average = number_format( $ratings / $count, 2, '.', '' );
                
			
                    echo '<div class="custom_shop_reviews"> ' . $count . ' Shop reviews ' . wc_get_rating_html($average, $count) . '</div>';
                
                
            } else {
                $average = 0;
				// echo '<div class="custom_shop_reviews"> ' . $count . ' Shop reviews ' . wc_get_rating_html($average, $count) . '</div>';
            } 
        ?>
       
    	<?php
        	get_total_vendor_products_sale($user_id);
        ?>
        
	</div>

<?php //endif; ?>
<?php do_action('woocommerce_after_rating_hook');?>
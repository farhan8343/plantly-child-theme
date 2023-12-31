<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if (  method_exists( $product, 'get_type') && $product->get_type() == 'auction' ) : 
	$user_id  = get_current_user_id(); //echo 'user:'. $user_id . ' test ' . $product->get_auction_current_bider();
if($product->get_auction_closed() == '2'):
echo '<p class="winner bid-winner"><strong>Winner: </strong>'. get_userdata($product->get_auction_current_bider())->data->display_name .'</p>';
endif;
	if ( $user_id == $product->get_auction_current_bider() && $product->get_auction_closed() == '2' && !$product->get_auction_payed() ) :
		if ( ! ($product->get_auction_type() == 'reverse' && get_option( 'simple_auctions_remove_pay_reverse' ) == 'yes' ) ) :  ?>
			<a href="<?php echo apply_filters( 'woocommerce_simple_auction_pay_now_button',esc_attr(add_query_arg("pay-auction",$product->get_id(), simple_auction_get_checkout_url()))); ?>" class="button"><?php  _e( 'Pay Now', 'wc_simple_auctions' ) ; ?></a>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
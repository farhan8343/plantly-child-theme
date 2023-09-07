<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:
if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
		if(is_checkout() && $_GET['mobile'] == 'true'){ 
			echo "<style>
					
					.site-header,footer.site-footer,.col-form-login{
						display: none !important;
					}
				 </style>";
		} //if($_GET['debug']): implode(',',$_COOKIE); echo '<pre>';print_r($_COOKIE);echo '</pre>'; endif;
		if(strpos(implode(',',array_keys($_COOKIE)), 'wordpress_user_sw_olduser') !== false || current_user_can('administrator')){

		}else{
			echo '<style>[name="settings[stripe]"][value="1"] + .dokan-text-left {display: none;}<style>';
		}
		echo '<meta name="google-play-app" content="app-id=com.google.android.youtube">';
		echo '<meta name="apple-itunes-app" content="app-id=1535020483">';
		wp_enqueue_script('select2','https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.js',array('jquery'),'1.0.0',true);
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'ionicons','font-awesome','eleganticons','bootstrap','martfury','martfury' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );


// END ENQUEUE PARENT ACTION


//changing vendor tab name from Biography to "About Me"
add_filter ('dokan_vendor_biography_title', 'change_vendor_biography_text' );

function change_vendor_biography_text ($biograpy_tab_name){
 $biograpy_tab_name = 'About';
return($biograpy_tab_name);

}

//Chaning vendor tab name from products to My Plants

add_filter ('dokan_store_tabs', 'change_products_text_from_vendor_store', 10, 2 );

function change_products_text_from_vendor_store ( $tabs, $store_id ) {
    $tabs = array(
        'products' => array(
            'title' => __( 'My Items', 'dokan-lite' ),
            'url'   => dokan_get_store_url( $store_id ),
        ),
        'terms_and_conditions' => array(
            'title' => __( 'Terms and Conditions', 'dokan-lite' ),
            'url'   => dokan_get_toc_url( $store_id ),
        )
    );

    return $tabs;
}


//extending class to override setup wizard text at step 1
if (class_exists('Dokan_Seller_Setup_Wizard')) {
	class Dokan_Setup_Wizard_Override extends Dokan_Seller_Setup_Wizard {
	/**
		 * Show the setup wizard.
		 */
		public function setup_wizard() {
			if ( empty( $_GET['page'] ) || 'new-plant-seller' !== $_GET['page'] ) {
				return;
			}

			if ( ! is_user_logged_in() ) {
				return;
			}

			$this->custom_logo = null;
			$setup_wizard_logo_url = dokan_get_option( 'setup_wizard_logo_url', 'dokan_general', '' );

			if ( ! empty( $setup_wizard_logo_url ) ) {
				$this->custom_logo = $setup_wizard_logo_url;
			}

			$this->store_id   = dokan_get_current_user_id();
			$this->store_info = dokan_get_store_info( $this->store_id );

			$steps = array(
				'introduction' => array(
					'name'    => __( 'Introduction', 'dokan-lite' ),
					'view'    => array( $this, 'dokan_setup_introduction' ),
					'handler' => '',
				),
				'store' => array(
					'name'    => __( 'Store', 'dokan-lite' ),
					'view'    => array( $this, 'dokan_setup_store' ),
					'handler' => array( $this, 'dokan_setup_store_save' ),
				),
				'payment' => array(
					'name'    => __( 'Payment', 'dokan-lite' ),
					'view'    => array( $this, 'dokan_setup_payment' ),
					'handler' => array( $this, 'dokan_setup_payment_save' ),
				),
				'next_steps' => array(
					'name'    => __( 'Ready!', 'dokan-lite' ),
					'view'    => array( $this, 'dokan_setup_ready' ),
					'handler' => '',
				),
			);

			$this->steps = apply_filters( 'dokan_seller_wizard_steps', $steps );

			$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

			$this->enqueue_scripts();

			if ( ! empty( $_POST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) { // WPCS: CSRF ok.
				call_user_func( $this->steps[ $this->step ]['handler'] );
			}

			ob_start();
			$this->setup_wizard_header();
			$this->setup_wizard_steps();
			$this->setup_wizard_content();
			$this->setup_wizard_footer();
			load_styles_dokan_wizard();
			exit;
		}
		/**
		 * Introduction step.
		 */
		public function dokan_setup_introduction() {
			$dashboard_url = dokan_get_navigation_url();
			?>
			<h1><?php esc_attr_e( 'We are thrilled to have you!', 'dokan-lite' ); ?></h1>
			<p><?php echo wp_kses( __( 'Plants make people happy, so thank you very much for joining our growing community. <strong>This quick and easy setup wizard will help you configure your new online store\'s basic settings and start selling!</strong>', 'dokan-lite' ), [ 'strong' => [] ] ); ?></p>
			<p><?php esc_attr_e( 'It should only take two minutes, but you can always finish the setup later if you have any questions.', 'dokan-lite' ); ?></p>
			<p class="wc-setup-actions step">
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next lets-go-btn dokan-btn-theme custom-setup-wizard" style="box-shadow: none; box-shadow: none; text-shadow:none;"><?php esc_attr_e( 'Let\'s Go!', 'dokan-lite' ); ?></a></br>
				<a href="<?php echo esc_url( $dashboard_url ); ?>" class="i-will-setup-later" style="font-style: italic; color: #6d6d6d; font-size:11px;"><?php esc_attr_e( 'I\'ll setup later', 'dokan-lite' ); ?></a>
			</p>
			<?php
			do_action( 'dokan_seller_wizard_introduction', $this );
		}
	}
}

new Dokan_Setup_Wizard_Override;


add_action("dokan_seller_wizard_payment_setup_field", 'hiding_payment_page');
function hiding_payment_page(){

echo '<style>
display:none;
</style>';
	
		
}
//style for setup wizard step 1 ,2 ,3
add_action("dokan_setup_wizard_styles", 'seller_setup_wizard_style');

function seller_setup_wizard_style(){

echo '<style>
.wc-setup.wp-core-ui #wc-logo > a > img {
    max-width: 400px;
}
.wc-setup .wc-setup-steps li.done, .wc-setup .wc-setup-steps li.active {
    color:#5aac44;
	border-color:#5aac44;
}
.wc-setup .wc-setup-steps li.done:before, .wc-setup .wc-setup-steps li.active:before{
	border-color:#5aac44;
}
body > div.wc-setup-content > form > table > tbody > tr:nth-child(3) > th > label {
    display: none;
}
body > div.wc-setup-content > form > table > tbody > tr:nth-child(8) {
    display: none;
}
body > div.wc-setup-content > .dokan-seller-setup-form > table > tbody > tr:nth-child(1) {
    display: none !important;
}
.wc-setup .wc-setup-content .checkbox input[type=checkbox]:checked + label::before {
    background: #5aac44;
    border-color: #5aac44;
}
.wc-setup .wc-setup-actions .button-primary {
    box-shadow: unset;
    text-shadow: unset;
}
.wc-setup .wc-setup-actions .button-primary:hover{
    box-shadow: unset;
}
a.button.button-large.button-next.payment-step-skip-btn.dokan-btn-theme,
a.button.button-large.button-next.store-step-skip-btn.dokan-btn-theme {
    background: none !important;
    color: #6d6d6d !important;
    border: none !important;
    display: block;
    padding: 0px !important;
    font-style: italic !important;
    font-size: 11px !important;
}
div.wc-setup-content > p.wc-setup-actions.step > a.i-will-setup-later {
display: none;
}
a.button.button-large.button-next.store-step-skip-btn.dokan-btn-theme,a.button.button-large.button-next.payment-step-skip-btn.dokan-btn-theme {
display: none;
}
.wc-setup .wc-setup-steps li.done:before, .wc-setup .wc-setup-steps li.active:before {
    background: darkgreen !important;
	}
.wc-setup-content {
    border-radius: 8px;
}
a.wc-return-to-dashboard {
    font-size: 13px;
    font-weight: normal;
    color: #444 !important;
}	
.dokan-vendor-setup-wizard a.wc-return-to-dashboard{
display:none !important;
}
</style>';
	
echo "<script type='text/javascript'>
jQuery(document).ready(function(){
if(jQuery('body > div.wc-setup-content > form > table > tbody > tr:nth-child(2) > th > label').html() == 'Street' ) {  jQuery('body > div.wc-setup-content > form > table > tbody > tr:nth-child(2) > th > label').html('Your Address') };  
  
if(jQuery('.wc-setup-content > div.dokan-setup-done > h1').html() == 'Your Store is Ready!' ) {  jQuery('.wc-setup-content > div.dokan-setup-done > h1').html('Congrats, Your Store is Ready!') };    
 
//if(jQuery('.wc-setup-content > form > table > tbody > tr > td > div > div').html() == 'Your account is not connected to Stripe. Connect your Stripe account to receive payouts.' ) {  jQuery('.wc-setup-content > form > table > tbody > tr > td > div > div').html('We use Stripe to simplify the payment process for all of our vendors. As we want to ensure your setup is just right for you, If you are unable to complete the process right now, a representative will assist you further once your new store is activated.') }; 
  
  });
</script>";
}


/*fixing country*/
function woo_remove_specific_country( $country ) 
{
return array(
	'US' => __( 'United States (US)', 'woocommerce' ),
	);
}
add_filter( 'woocommerce_countries', 'woo_remove_specific_country', 10, 1 );


/*chaning user name to store name 

function changing_user_name_to_store_name( $seller_id ) {
global $user_login;
$seller_id= get_current_user_id();
$user_login = $seller_id;
return $user_login;
}
add_filter( 'dokan_store_support_order_id_select_in_form', 'changing_user_name_to_store_name', 10, 1 );

*/
/*Adding some content at contact popup when user click on support button at the vendor store page 

function changing_user_name_to_store_name( $seller_id ) {
global $user_login;
$current_user = wp_get_current_user();
//$seller_id= get_current_user_id();
//$user_login = $seller_id;
$user_login = esc_html( $current_user->user_firstname ) . " - How can I help?" ;
return $user_login;
}
add_filter( 'dokan_store_support_order_id_select_in_form', 'changing_user_name_to_store_name', 10, 1 );
*/
/* Keeping the Year current in footer -KV */
function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');

/* hiding street address */

add_filter ('dokan_get_seller_formatted_address', 'removing_street_address_from_address', 10, 2);

function removing_street_address_from_address( $formatted_address, $profile_info ) {


    if ( isset( $profile_info['address'] ) ) {

        $address = $profile_info['address'];

        $country_obj = new WC_Countries();
        $countries   = $country_obj->countries;
        $states      = $country_obj->states;

        $street_1     = isset( $address['street_1'] ) ? $address['street_1'] : '';
        $street_2     = isset( $address['street_2'] ) ? $address['street_2'] : '';
        $city         = isset( $address['city'] ) ? $address['city'] : '';

        $zip          = isset( $address['zip'] ) ? $address['zip'] : '';
        $country_code = isset( $address['country'] ) ? $address['country'] : '';
        $state_code   = isset( $address['state'] ) ? $address['state'] : '';
        $state_code   = isset( $address['state'] ) ? ( $address['state'] == 'N/A' ) ? '' : $address['state'] : '';

        $country_name = isset( $countries[ $country_code ] ) ? $countries[ $country_code ] : '';
        $state_name   = isset( $states[ $country_code ][ $state_code ] ) ? $states[ $country_code ][ $state_code ] : $state_code;

    } else {
        return 'N/A';
    }



    $country           = new WC_Countries();
    $formatted_address = $country->get_formatted_address( array(
        'city'      => $city,
        'postcode'  => $zip,
        'state'     => $state_code,
        'country'   => $country_code,
    ) );


    return $formatted_address;
}


/*about wish list 

if ( ! function_exists('yith_wcwl_no_product_to_remove_message_custom' ) ) {
    function yith_wcwl_no_product_to_remove_message_custom( $message ){
        $message = __( 'Sorry, you have an empty wishlist!  Go find some gems!', 'yith-woocommerce-wishlist' );
        return $message;
    }
}
add_filter( 'yith_wcwl_no_product_to_remove_message', 'yith_wcwl_no_product_to_remove_message_custom', 10, 1 );

*/

add_filter( 'woocommerce_product_tabs', 'hiding_location_tab_from_single_product_page', 11 );
    function hiding_location_tab_from_single_product_page($tabs) {
    unset($tabs['geolocation']);
    return $tabs;
}


add_action( 'woocommerce_share', 'add_share_text', 5);
function add_share_text( ) {
     global $product;
    echo '<p class="share-text">Share: </p>';
}

// adding "Customers who bought this item also bought" option under single product page

/*
add_action( 'woocommerce_after_single_product', 'customers_who_bought_this_item_also_bought', 5);
function customers_who_bought_this_item_also_bought(){
echo '<section class="related products" data-columns="5">
		<div class="martfury-container">
			<div class="related-content" role="toolbar">
				<h2 class="related-title">Best selling products</h2>
				</div>
					</div>
						</section>';
echo do_shortcode( '[best_selling_products limit="5" columns="5" orderby="rand" ]' );  
}

*/

//add_action('woocommerce_email_header','email_header_css');
function email_header_css (){
echo '<style>

/*email css */

#header_wrapper h1 {
    font-size: 22px !important;
}
</style>';
}

/*
//adding wishlist button with product title

add_action('woocommerce_single_product_summary','wishlist_button_shortcode');
function wishlist_button_shortcode (){
	echo "<div class='wishlist-button'>";
echo do_shortcode('[yith_wcwl_add_to_wishlist]');
	echo "</div>";
}

add_action( 'woocommerce_thankyou', 'adding_wishlist_button', 4 );
function adding_wishlist_button (){
	echo "";
}
*/

/*big image upload issue */
add_filter( 'big_image_size_threshold', '__return_false' );


/*Filtering some post categories - seller hand book category from blog page*/
function exclude_category( $query ) {
  if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'cat', '-262' );
        }
  }
add_action( 'pre_get_posts', 'exclude_category' );

/**
 * Change default gravatar.
 */

//add_filter( 'avatar_defaults', 'new_gravatar' );
function new_gravatar ($avatar_defaults) {
$myavatar = 'https://plantly.io/wp-content/uploads/2020/12/iStock-869995508-1.jpg';
$avatar_defaults[$myavatar] = "Default Gravatar";
return $avatar_defaults;
}


add_filter( 'avatar_defaults', 'new_gravatar_2' );

function new_gravatar_2 ($avatar_defaults) {

//$myavatar = 'https://plantly.io/wp-content/uploads/2020/12/iStock-869995508-1.jpg';

//$avatars = ['https://plantly.io/wp-content/uploads/2020/12/iStock-869995508-0.png','https://plantly.io/wp-content/uploads/2020/12/iStock-869995508-1-1.jpg','https://plantly.io/wp-content/uploads/2020/12/iStock-869995508-2.png','https://plantly.io/wp-content/uploads/2020/12/iStock-869995508-3.jpg'];

$avatars = ['https://plantly.io/wp-content/uploads/2020/12/plant.png'];
	
$avatars_rand=array_rand($avatars,1);
$avatars_rand_link = $avatars[$avatars_rand];

$avatar_defaults[$avatars_rand_link] = "Default Gravatar";
return $avatar_defaults;
}


/**
 * Modify brand dropdown at vendor dashboard
 */


/**
 * Filter url to identify the newly added product
 */
function dpe_newly_added_product_msg( $url, $product_id ) {
    return add_query_arg( 'new', $product_id, $url );
}
add_filter( 'dokan_add_new_product_redirect', 'dpe_newly_added_product_msg', 10, 2 );


function dpe_listing_product_new_product_msg() {

    if ( !empty( $_GET['new'] ) ) { ?>
        <div class="dokan-message">
            <button type="button" class="dokan-close" data-dismiss="alert">&times;</button>
            <strong><?php echo sprintf( 'Your new product added successfully. Product ID is: %d', intval($_GET['new']) ) ?></strong>
        </div>
    <?php
    }

}
//add_action( 'dokan_before_listing_product', 'dpe_listing_product_new_product_msg' );
//
//
/* code for adding link to ShipStation*/

add_action('woocommerce_admin_order_actions_end', 'order_action_shipstation',10,1);

function order_action_shipstation($order){

$order_id =  $order->get_id();

echo '<a target="_blank" class="dokan-btn dokan-btn-default dokan-btn-sm tips" href="https://ship.shipstation.com/orders/all-orders-search-result?quickSearch='.$order_id.'" data-toggle="tooltip" data-placement="top" title="" data-original-title="View on Shipstation"><i class="fa fa-plane">&nbsp;</i></a>';


}

add_action( 'send_headers', 'send_frame_options_header', 10, 0 );



/* rename RMA tab name in my-account 
add_filter( 'woocommerce_account_menu_items', 'rename_rma_tab_name', 50 );
function rename_rma_tab_name($menu_links){
$menu_links = array_slice( $menu_links, 0, 5, true )
        + array( 'rma-requests' => __( 'Return Requests', 'dokan' ) )
        + array_slice( $menu_links, 5, NULL, true );
return $menu_links;
}

*/

/* filter to change position of details tab and only show it if it has attributes */
add_filter('woocommerce_product_tabs', 'change_position_of_details_tabs_if_it_has_attributes');  
  
function change_position_of_details_tabs_if_it_has_attributes($tabs) {  
	/*Check if product has attributes, dimensions or weight to override the call_user_func() expects parameter 1 to be a valid callback error when changing the additional tab */
	
	global $product;
	
	if( $product->has_attributes() || $product->has_dimensions() || $product->has_weight() ) {
	
    $tabs['additional_information']['priority'] = 4;
	}
    return $tabs;  
		
}

/* removing some menus items from the seller dashboard*/
add_filter( 'dokan_get_dashboard_nav', 'remove_some_menus_from_seller_dashboard' );
function remove_some_menus_from_seller_dashboard( $menus ) {
    unset($menus['withdraw']);
    return $menus;
}

/* view dashbaord button short code */

function current_user_store_url() { 
$url=esc_url( dokan_get_store_url( dokan_get_current_user_id() ) );
return "<a class='view-my-store-btn dokan-btn' href='" . $url . "' target='_blank'>Visit My Store <i class='fa fa-external-link'></i></a>";
}

add_shortcode('current_user_store_url', 'current_user_store_url'); 

function dpe_update_dokan_added_product( $product_id, $post_data ) {
    update_post_meta( $product_id, '_manage_stock', 'yes' );
	
    update_post_meta( $product_id, '_stock', 1 );
	// Update the post into the database
    wp_update_post(
        array(
			'ID'             => $product_id,
			'comment_status' => 'open',
        )
    );
}
add_action( 'dokan_new_product_added', 'dpe_update_dokan_added_product', 10, 2 );



// Woocommerce Notices
add_shortcode('woocommerce_notices', function($attrs) {

    if (function_exists('wc_notice_count') && wc_notice_count() > 0) {
    ?>

    <div class="woocommerce-notices-shortcode woocommerce">
    <?php wc_print_notices(); ?>
    </div>

    <?php
    }

});

//Changing Brand Name.
add_filter('martfury_product_brand_text','modify_brand_text',10);
function modify_brand_text($html){
	return 'Genus:';
}

// Show out of stock product in vendor dashboard
add_action("wp_ajax_update_show_out_of_stock_usermeta", "update_show_out_of_stock_usermeta");
function update_show_out_of_stock_usermeta(){
  if(isset($_POST['show_out_of_stock'])) update_usermeta(get_current_user_id(),'show_out_of_stock',$_POST['show_out_of_stock']); return ""; exit();
}

//Redirecting non logged-in user from auction page
//add_filter('the_content','restricted_non_loggedin_content',10,1);
function restricted_non_loggedin_content($content){
	if(is_page('auctions') && !is_user_logged_in()){
		$content = "<div class='auction-banner-btn' style='max-width:920px;display:block;height:auto;margin-left:auto;margin-right:auto;margin-bottom:100px;'><a href='/my-account?redirect_to=/auctions'><img src='/wp-content/uploads/2020/10/PlantAuctionYearEnd-landingpage.jpeg'></a><a href='/my-account?redirect_to=/auctions' class='dokan-btn dokan-btn-theme vendor-dashboard'style='display: block;margin: 20px 15%;font-size: 1.3em;font-weight: 500;background-color: #00a651;'>Login to Enter Auction</a></div>";
	}
	return $content;
}

//enable upload for webp image files.
function webp_upload_mimes($existing_mimes) {
    $existing_mimes['webp'] = 'image/webp';
    return $existing_mimes;
}
add_filter('mime_types', 'webp_upload_mimes');

//enable preview / thumbnail for webp image files.
function webp_is_displayable($result, $path) {
    if ($result === false) {
        $displayable_image_types = array( IMAGETYPE_WEBP );
        $info = @getimagesize( $path );

        if (empty($info)) {
            $result = false;
        } elseif (!in_array($info[2], $displayable_image_types)) {
            $result = false;
        } else {
            $result = true;
        }
    }

    return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);


// Changes on 14-April 2021

//Product is in another cart
function dpe_in_someones_cart_to_loop() {

    global $wpdb;

    $product_id = get_the_ID();
	$product = wc_get_product(get_the_ID());
    if( empty( $product_id ) || !$product_id ) {
        return;
    }

    $query   = 's:10:"product_id";i:'.$product_id;
    $user_id = get_current_user_id();
    $carts   = $wpdb->get_var(
        "SELECT COUNT(*) from {$wpdb->usermeta} WHERE meta_key = '_woocommerce_persistent_cart_1' and user_id != {$user_id} and meta_value like '%{$query}%'"
    );
//echo $carts;
//echo $product->get_stock_quantity();
    if( intval( $carts ) > 0 && $product->is_in_stock() &&  $product->managing_stock()) {
         $in_other_cart_translation = __('This product is in another cart','Dokan');
 echo "<div class='loop-in-someones-cart'>Only " . $product->get_stock_quantity() . " available and it's in " . $carts . " people's basket</div>";
      //  echo '<div class="loop-in-someones-cart">'.$in_other_cart_translation . '</div>';
    }

}
add_action( 'woocommerce_after_shop_loop_item_title', 'dpe_in_someones_cart_to_loop' ,2);
add_action( 'woocommerce_single_product_summary', 'dpe_in_someones_cart_to_loop',12);


//adding free shipping label at archive page

add_action( 'woocommerce_after_rating_hook', 'additional_single_product_badges',4);
add_action( 'woocommerce_after_shop_loop_item_title', 'additional_single_product_badges',110);
function additional_single_product_badges() {
    global $product;
    ##  ----  SHIPPING CLASSES  ----  ##

    // Define the related shipping classes data in this multidimensional array
    $shipping_class_badges_data = [
        'free-shipping'    => ['Free Shipping'],
    ];

    if( $shipping_class = $product->get_shipping_class() ) {
        foreach( $shipping_class_badges_data as $key => $badge ) {
            if ( $shipping_class == $key ) {
                foreach( $badge as $img_src => $alt_text ) {
                    $html  = '<a href="'.home_url("/shipping-policy/").'" "target="_blank">';
                 $html .= 'Free Shipping';
                    $html .= '</a>';
                }
                echo '<span class="shipping-badge ">'.$html.'</span>';
                break;
            }
        }
    }   
}


// Gettings Vendor Total Sales on Single Product Page
function get_total_vendor_products_sale($user_id){
	global $wpdb;
	$get = get_posts(array('author' => $user_id,'fields' => 'ids', 'post_type' => 'product','posts_per_page'=> -1,'post_status'=>'publish'));
	$string = implode(',',$get);

	$sales = $wpdb->get_var(
				$wpdb->prepare(
					"select SUM(meta_value) from $wpdb->postmeta join $wpdb->posts a on a.ID = post_id where meta_key = 'total_sales' and a.ID in ($string)"
				)
			);
	$sales = $sales + intval( get_the_author_meta( 'custom_sales', $user_id,true));
	if($sales > 0 && !is_admin()){
		echo  '<span class="total_sales">' . $sales . ' sales</span>';
	}elseif($sales > 0 && is_admin()){
		echo  '<span class="total_sales">' . $sales . '</span>';
	}
}

// Adding option on user edit page in wordpress admin to add extra number of store sales

function save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    /* Edit the following lines according to your set fields */
    update_usermeta( $user_id, 'custom_sales', $_POST['custom_sales'] );
	if(isset($_POST['hide_only_shop_products'])){
		 update_usermeta( $user_id, 'hide_only_shop_products', true );
	}else{
		 update_usermeta( $user_id, 'hide_only_shop_products', false );
	}
}

add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );

function extra_profile_fields( $user ) { //print_r($user);
	if(in_array( 'seller', (array) $user->roles) || in_array( 'administrator', (array) $user->roles)):
	?>

		<h3><?php _e('Extra User Details'); ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="gmail">Custom Sales</label></th>
				<td>
				<input type="text" name="custom_sales" id="custom_sales" value="<?php echo esc_attr( get_the_author_meta( 'custom_sales', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Enter custom sales to add the quantity in total vendor sales.</span>
				</td>
			</tr>
			<tr>
				<th><label for="shop">Hide products from the category pages:</label></th>
				<td>
				<input type="checkbox" name="hide_only_shop_products" id="hide_only_shop_products" <?php if(get_user_meta( $user->ID, 'hide_only_shop_products', true ) == true){echo 'checked';} ?>><br />
				<span class="description">This option will hide products of this vendor from all category pages and will show the product at the shop page only.</span>
				</td>
			</tr>
		</table>
	<?php
	endif;
}
add_action( 'show_user_profile', 'extra_profile_fields', 10 );
add_action( 'edit_user_profile', 'extra_profile_fields', 10 );


//add_action('pre_get_comments','modifying_comments_query',10,1);
function modifying_comments_query($query){
	$query->set('type','rating');
	echo "<pre>"; print_r($query);echo "</pre>";
	//return $query;


}



// Stock Quantity @ WooCommerce Shop / Cart / Archive Pages


//add_action( 'woocommerce_after_shop_loop_item', 'plantly_show_stock_shop', 10 );

//function plantly_show_stock_shop() {

//   global $product;

//   echo wc_get_stock_html( $product );

//}



// Showing star ratting and review count at archive pages
function get_shop_reviews_html($user_id){
	global $wpdb;
	$get = get_posts(array('author' => $user_id, 'post_type' => 'product','fields' => 'ids','posts_per_page'=> -1,'post_status'=>'publish'));
	
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
		$html = '<div class="custom_shop_reviews"> ' . wc_get_rating_html($average, $count) .'</div>';
			echo apply_filters('archieve_reviews_start',$html,$average,$count);
		//  <span>('. $count . ')</span>'. '
	} else {
		$average = 0;
	} 
}


/**
 * Customizing the Review short code to just show the all product review of the vendor at the product page "Review Tab"
 */
add_filter( 'woocommerce_product_tabs', 'woo_custom_description_tab', 98 );
function woo_custom_description_tab( $tabs ) {
	global $product; 
	$get = get_posts(array('author' => get_the_author_ID($product->id),'fields' => 'ids', 'post_type' => 'product','posts_per_page'=> -1,'post_status'=>'publish'));
	$product_comments = get_comments(array('post_author'=>$user_id,'post__in'=> $get,'type' => 'review') );
	$count = count($product_comments);
	$tabs['reviews']['callback'] = 'woo_custom_description_tab_content';	// Custom description callback
	$tabs['reviews']['title'] = 'Store Reviews ('. $count .')';
	return $tabs;
}
function woo_custom_description_tab_content() {
	global $product; 
	$get = get_posts(array('author' => get_the_author_ID($product->id),'fields' => 'ids', 'post_type' => 'product','posts_per_page'=> -1,'post_status'=>'publish'));
	$product_comments = get_comments(array('post_author'=>$user_id,'post__in'=> $get) );
	//echo "<pre>";print_r($product_comments);echo "</pre>";
	$string = implode(',',$get);
	$shortcode = '[cusrev_all_reviews sort="DESC" sort_by="date" per_page="10" show_more=10 number="-1" show_summary_bar="true" show_pictures="true" show_products="true"  products="'. $string .'" shop_reviews="false" number_shop_reviews="-1" inactive_products="true" show_replies="true"]';
	if(count($get) > 0){
		echo do_shortcode($shortcode);
	}
	
	echo do_shortcode('[cusrev_reviews]');
}



/*
* 	Class for adding new shop reviews and total sells below title on single product page.
*/
class Martfury_WooCommerce_Extended {
	
	function __construct(){
		
		add_action( 'woocommerce_single_product_summary', array( $this, 'single_product_entry_header_extended' ), 5 );
	}
	public function single_product_entry_header_extended(){
		$layout = martfury_get_product_layout();
		if ( ! in_array( $layout, array( '2', '3', '4', '6' ) ) ) {
			return;
		}
		$this->get_single_product_header( $layout );
	}
	
	
	function get_single_product_header( $layout ) {
		?>

        <div class="mf-entry-product-header">
            <div class="entry-left">
				<?php
				if ( function_exists( 'woocommerce_template_single_title' ) ) {
					woocommerce_template_single_title();
				}
				?>

                <ul class="entry-meta">
					<?php

					$this->single_product_brand();
					global $product;
					if ( function_exists( 'woocommerce_template_single_rating' ) ) {
						echo '<li>'; 
						woocommerce_template_single_rating();
						echo '</li>';
					}
					if ( in_array( $layout, array( '1', '5' ) ) ) {
						$this->single_product_sku();
					}
					?>

                </ul>
            </div>
			<?php
			if ( in_array( $layout, array( '1', '5' ) ) ) {
				$this->single_product_socials();
			}
			?>
        </div>
		<?php
	}
	/**
	 * Get product SKU
	 */
	function single_product_socials() {

		if ( ! function_exists( 'martfury_addons_share_link_socials' ) ) {
			return;
		}

		$image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		martfury_addons_share_link_socials( get_the_title(), get_the_permalink(), $image );
	}
	/**
	 * Get sinlge product brand
	 */
	function single_product_brand() {
		global $product;
		$terms = get_the_terms( $product->get_id(), 'product_brand' );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ): ?>
            <li class="meta-brand">
				<?php echo apply_filters( 'martfury_product_brand_text', esc_html__( 'Brand:', 'martfury' ) ); ?>
                <a href="<?php echo esc_url( get_term_link( $terms[0] ), 'product_brand' ); ?>"
                   class="meta-value"><?php echo esc_html( $terms[0]->name ); ?></a>
            </li>
		<?php endif;
	}
	/**
	 * Get product SKU
	 */
	function single_product_sku() {
		global $product;
		if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
            <li class="meta-sku">
				<?php esc_html_e( 'SKU:', 'martfury' ); ?>
                <span class="meta-value">
                    <?php
                    if ( $sku = $product->get_sku() ) {
	                    echo wp_kses_post( $sku );
                    } else {
	                    esc_html_e( 'N/A', 'martfury' );
                    }
                    ?>
                </span>
            </li>
		<?php endif;
	}

}
new  Martfury_WooCommerce_Extended();








// Adding new store reviews in single product vendor info tab
add_action( 'dokan_product_seller_tab_end','store_reviews_in_vendor_info_tab',10,2 );
function store_reviews_in_vendor_info_tab( $author, $store_info){
	global $wpdb;
	$get = get_posts(array('author' => $author->ID, 'post_type' => 'product','fields' => 'ids','posts_per_page'=> -1,'post_status'=>'publish'));
	$product_comments = get_comments(array('post_author'=>$author->ID,'post__in'=> $get,'type' => 'review') );
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
		$html = '<div class="custom_shop_reviews"> ' . wc_get_rating_html($average, $count) .' ' . $average .' rating from '. $count .' reviews </div>';
		if($count > 0){
			echo apply_filters('archieve_reviews_start',$html,$average,$count);
		}
			
		//  <span>('. $count . ')</span>'. '
	} else {
		$average = 0;
	} 
}

// Updating Thumbnails for api
add_action( 'rest_api_init', 'add_thumbnail_to_JSON' );
function add_thumbnail_to_JSON() {
//Add featured image
register_rest_field( 'post',
    'featured_image_src', //NAME OF THE NEW FIELD TO BE ADDED - you can call this anything
    array(
        'get_callback'    => 'get_image_src',
        'update_callback' => null,
        'schema'          => null,
         )
    );
}
function get_image_src( $object, $field_name, $request ) {
    $size = 'small'; // Change this to the size you want | 'medium' / 'large'
    $feat_img_array = wp_get_attachment_image_src($object['featured_media'], $size, true);
    return $feat_img_array[0];
}

function prepare_product_images($response, $post, $request) {
global $_wp_additional_image_sizes;
if (empty($response->data)) {
return $response;
}
foreach ($response->data['images'] as $key => $image) {
$image_urls = [];
foreach ($_wp_additional_image_sizes as $size => $value) {
$image_info = wp_get_attachment_image_src($image['id'], $size);
$response->data['images'][$key][$size] = $image_info[0];
}
}
return $response;
}
add_filter("woocommerce_rest_prepare_product_object", "prepare_product_images", 10, 3);
add_filter("dokan_rest_prepare_product_object", "prepare_product_images", 10, 3);
//add_action( 'pre_get_posts', 'hidden_catalog_visibility' );
function hidden_catalog_visibility( $query = false ) {
	if ( ! is_admin() && isset( $query->query['post_type'] ) && $query->query['post_type'] === 'product' ) {
		$tax_query = $query->get( 'tax_query' );
		$tax_query = [
			'relation' => 'OR',
			[
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',
			],
			[
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'exclude-from-catalog',
				'operator' => '!=',
			],
		];

		$query->set( 'tax_query', $tax_query );
	}
}


add_action( 'dokan_store_profile_frame_after',function($user_data,$store_info){
echo do_shortcode('[woocommerce_notices]');
},100,2);

// Adding Help and FAQ tab
add_filter( 'dokan_query_var_filter', 'dokan_load_custom_document_menu' );
function dokan_load_custom_document_menu( $query_vars ) { 
    $query_vars['help'] = 'help';
    return $query_vars;
}

// Adding links in vendor dashboard menu
add_filter( 'dokan_get_dashboard_nav', 'dokan_add_custom_help_menu',9999 );
function dokan_add_custom_help_menu( $urls ) {
    $urls['help'] = array(
        'title' => __( 'Help', 'dokan'),
        'icon'  => '<i class="fa fa-question-circle"></i>',
        'url'   => dokan_get_navigation_url( 'help' ),
        'pos'   => 1000,
		'permission' => 'dokan_view_product_menu'
    );
	unset($urls['reviews']);
    return $urls;
}

// Content for FAQ and Help tab vendor dashboard
add_action( 'dokan_load_custom_template', 'dokan_load_custom_template' );
function dokan_load_custom_template( $query_vars ) {
    if ( isset( $query_vars['help'] ) ) {	?>
		<div class="dokan-dashboard-wrap">
			<?php do_action( 'dokan_dashboard_content_before' ); ?>
			<div class="dokan-dashboard-content">
				<?php do_action( 'dokan_help_content_inside_before' ); ?>
				<?php echo do_shortcode('[elementor-template id="12892"]')?>
				<?php do_action( 'dokan_dashboard_content_inside_after' ); ?>
			</div><!-- .dokan-dashboard-content -->
			<?php do_action( 'dokan_dashboard_content_after' ); ?>
		</div><!-- .dokan-dashboard-wrap --> <?php
	}
}
// Changing Vendor Wizard Link 
add_filter('dokan_seller_setup_wizard_url',function($url){
	
	return site_url( '?page=new-plant-seller');
},100);
//Style vendor setup wizard
function load_styles_dokan_wizard() {
        $page = ( isset( $_GET['page'] ) && $_GET['page'] == 'new-plant-seller' ) ? 'seller-setup' : '';

        if ( ( ! dokan_is_seller_dashboard() && get_query_var( 'post_type' ) !== 'product' ) && $page !== 'seller-setup' && ! dokan_is_store_listing() && ! is_account_page() ) {
            return;
        }

        $btn_text   = dokan_get_option( 'btn_text', 'dokan_colors', '#ffffff' );
        $btn_bg     = dokan_get_option( 'btn_primary', 'dokan_colors', '#f05025' );
        $btn_border = dokan_get_option( 'btn_primary_border', 'dokan_colors', '#f05025' );

        $btn_h_text   = dokan_get_option( 'btn_hover_text', 'dokan_colors', '#ffffff' );
        $btn_h_bg     = dokan_get_option( 'btn_hover', 'dokan_colors', '#dd3b0f' );
        $btn_h_border = dokan_get_option( 'btn_hover_border', 'dokan_colors', '#ca360e' );

        $dash_active_menu = dokan_get_option( 'dash_active_link', 'dokan_colors', '#f05025' );
        $dash_nav_text    = dokan_get_option( 'dash_nav_text', 'dokan_colors', '#ffffff' );
        $dash_nav_bg      = dokan_get_option( 'dash_nav_bg', 'dokan_colors', '#242424' );
        $dash_nav_border  = dokan_get_option( 'dash_nav_border', 'dokan_colors', '#454545' );
        ?>
        <style>
            input[type="submit"].dokan-btn-theme, a.dokan-btn-theme, .dokan-btn-theme {
                color: <?php echo $btn_text ?> !important;
                background-color: <?php echo $btn_bg ?> !important;
                border-color: <?php echo $btn_border ?> !important;
            }
            input[type="submit"].dokan-btn-theme:hover,
            a.dokan-btn-theme:hover, .dokan-btn-theme:hover,
            input[type="submit"].dokan-btn-theme:focus,
            a.dokan-btn-theme:focus, .dokan-btn-theme:focus,
            input[type="submit"].dokan-btn-theme:active,
            a.dokan-btn-theme:active, .dokan-btn-theme:active,
            input[type="submit"].dokan-btn-theme.active, a.dokan-btn-theme.active,
            .dokan-btn-theme.active,
            .open .dropdown-toggleinput[type="submit"].dokan-btn-theme,
            .open .dropdown-togglea.dokan-btn-theme,
            .open .dropdown-toggle.dokan-btn-theme{
                color: <?php echo $btn_h_text ?> !important;
                background-color: <?php echo $btn_h_bg ?> !important;
                border-color: <?php echo $btn_h_border ?> !important;
            }

            .dokan-dashboard .dokan-dash-sidebar,
            .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu{
                background-color : <?php echo $dash_nav_bg ?> !important;
            }

            .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li a{
                color : <?php echo $dash_nav_text ?> !important;
            }

            .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.active,
            .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li:hover,
            .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.active,
            .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a:hover{
                background-color : <?php echo $dash_active_menu ?> !important;
            }

            .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li,
            .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li a,
            .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a{
                border-color : <?php echo $dash_nav_border ?> !important;
            }
        </style>

        <?php
    }

/*
add_action( 'init', 'createnewfilemy' );
function createnewfilemy()
{
    $myfile = fopen(get_stylesheet_directory_uri()."/dokan/orders/shipment/html-shipping-status.php", "w") or die("Unable to open file!");
    $txt = "test\n";
    fwrite($myfile, $txt);
    $txt = "test\n";
    fwrite($myfile, $txt);
    fclose($myfile);

}


*/




// Feature Image Required Add product page

add_filter('dokan_can_add_product',function($errors){
	if(empty($_POST['feat_image_id'])){
		$errors[] = 'Please select product image';
	}
	
	return $errors;
},100,2);


add_filter('woocommerce_get_price_html',function($html, $product){

$html.= '<div class="search-stock-status" style="display:none;">' . wc_get_stock_html($product) . '</div>';
return $html;

},100,2);


// Reviews API modification for Mobile APP
add_filter('woocommerce_rest_product_review_query',function($prepared_args, $request){
	global $wpdb;
		$author_id = get_post_field( 'post_author',$request['product'][0]);
		if(isset($request['store'])){
			$author_id = $request['store'];
		} 
// 	echo $request['product'][0];
// 	echo '<pre>';print_r($author_id); echo '</pre>';
		$get = get_posts(array('author' => $author_id, 'post_type' => 'product','fields' => 'ids','posts_per_page'=> -1,'post_status'=>'publish'));
		if(!empty($get)){
			$prepared_args['post__in'] = $get;
		}elseif(isset($request['product'][0]) || isset($request['store'])){
			echo 'Something Wrong with arguments';exit();
		}
		
		if($request['all'] == true){
			$prepared_args['number'] = 9999999;
		}
	//print_r($prepared_args); die();
	return $prepared_args;
},100,2);


// Store Sales API
class WC_REST_Product_Sales_Controller extends WC_REST_Controller {

	protected $namespace = 'wc/v3';
	protected $rest_base = 'products/(?P<product_id>[\d]+)/sales';

	public function register_routes() {
		register_rest_route(
			$this->namespace, '/' . $this->rest_base , array(
				'args'   => array(
					'product_id' => array(
						'description' => __( 'Unique identifier for the resource.', 'woocommerce' ),
						'type'        => 'integer',
					),
				),
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_item' ),
					'permission_callback' => array( $this, 'get_item_permissions_check' ),
					'args'                => array(
						'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					),
				),
				'schema' => array( $this, 'get_public_item_schema' )
			)
		);
	}

	public function get_item_permissions_check( $request ) {
		return true;
	}

	public function get_item( $request ) {
		
		global $wpdb;
    $user_id = get_post_field( 'post_author',$request['product_id']);
    $get = get_posts(array('author' => $user_id,'fields' => 'ids', 'post_type' => 'product','posts_per_page'=> -1,'post_status'=>'publish'));
    $string = implode(',',$get);
  
    $sales = $wpdb->get_var(
          $wpdb->prepare(
            "select SUM(meta_value) from $wpdb->postmeta join $wpdb->posts a on a.ID = post_id where meta_key = 'total_sales' and a.ID in ($string)"
          )
        );
    $sales += get_the_author_meta( 'custom_sales', $user_id );
      $response = array(
          'author_id' => $user_id,
          'store_sales' => $sales
      );
		return rest_ensure_response($response);
	}
} 


// Review Summary
class WC_REST_Product_Review_Summary_Controller extends WC_REST_Controller {

	protected $namespace = 'wc/v3';
	protected $rest_base = 'products/review-summary/(?P<store>[\d]+)';

	public function register_routes() {
		register_rest_route(
			$this->namespace, '/' . $this->rest_base , array(
				'args'   => array(
					'store' => array(
						'description' => __( 'Unique identifier for the resource.', 'woocommerce' ),
						'type'        => 'integer',
					),
				),
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_summary' ),
					'permission_callback' => array( $this, 'get_item_permissions_check' ),
					'args'                => array(
						'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					),
				),
				'schema' => array( $this, 'get_public_item_schema' )
			)
		);
	}

	public function get_item_permissions_check( $request ) {
		return true;
	}

	public function get_summary( $request ) {
		
	global $wpdb;
	$user_id = $request['store'];
		$get = get_posts(array('author' => $user_id,'fields' => 'ids', 'post_type' => 'product','posts_per_page'=> -1,'post_status'=>'publish'));
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
		} else {

			$average = 0;
		} 
 	  $response = array(
          'store_id' => $user_id,
          'no_of_reviews' => $count,
		  'average' => $average
      );
		return rest_ensure_response($response);
	}
} 



add_filter('woocommerce_rest_api_get_rest_namespaces',function($namespaces){
	 $namespaces['wc/v3']['product-sales'] = 'WC_REST_Product_Sales_Controller';
	 $namespaces['wc/v3']['reviews-summary'] = 'WC_REST_Product_Review_Summary_Controller';
	 return $namespaces;
},100);


add_filter('get_terms_orderby',function($orderby,$query_vars,$taxonomy){
	if($taxonomy[0] == 'product_shipping_class'){
		$orderby = 't.term_order';	
	}
	return $orderby;
},100,3);



/*hiding out of stock product from the short code

*/
add_filter( 'woocommerce_shortcode_products_query', function( $query_args, $atts, $loop ){

	if($atts['class'] == 'outofstock') {
		$query_args['meta_query'] = array( array(
		    'key'     => '_stock_status',
		    'value'   => 'outofstock',
		    'compare' => '!=',
		) );
	}
    

    return $query_args;

}, 10, 3);


add_filter('dokan_rest_get_stores_args',function($args,$request){
// $args['include'] = array(19,12);
// $args['orderby'] = 'include';
	//echo '<pre>'; print_r($args); echo '</pre>'; die();
	return $args;
},100,2);


add_action( "woocommerce_shortcode_before_products_loop", function($attributes ){
// 	print_r($attributes);
if($attributes['class'] == 'outofstock'){
	echo '<div style="display:none;" class="hide-on-app">';
}
});
add_action( "woocommerce_shortcode_after_products_loop", function($attributes ){
// 	print_r($attributes);
if($attributes['class'] == 'outofstock'){
	echo '</div>';
}
});

add_filter( 'gettext', function($translation, $text, $domain ){
	if(!is_admin() && $translation == 'Dokan Stripe Connect'){
		$translation = "Stripe Connect";
	}
	if($translation == 'Active Auctions'){ 
		$translation = 'Your Active Auctions';
	}
	if($translation == 'Won auctions'){
		$translation = 'Auctions you won';
	}
	
	return $translation;
},900,3);


// Adding a custom Meta container to admin products pages
add_action( 'add_meta_boxes', 'create_custom_meta_box_adsence' );
function create_custom_meta_box_adsence(){
	add_meta_box(
		'custom_product_meta_box',
		__( 'Adsence Script <em>(optional)</em>', 'cmb' ),
		'add_custom_content_meta_box_adsence',
		'product',
		'normal',
		'default'
	);
}

//  Custom metabox content in admin product pages
function add_custom_content_meta_box_adsence( $post ){
	$adsence_script_related = get_post_meta($post->ID, 'adsence_script', true) ? get_post_meta($post->ID, 'adsence_script', true) : '';
	$adsence_script_social = get_post_meta($post->ID, 'adsence_script_social', true) ? get_post_meta($post->ID, 'adsence_script_social', true) : '';
	$adsence_script_siderbar = get_post_meta($post->ID, 'adsence_script_sidebar', true) ? get_post_meta($post->ID, 'adsence_script_sidebar', true) : '';
	echo '<p><strong>Script Above Related Products</strong></p>';
	echo '<textarea style="width:100%; min-height:100px;" name="adsence_script" >'.$adsence_script_related.'</textarea>';
	echo '<p><strong>Script Below Social Media</strong></p>';
	echo '<textarea style="width:100%; min-height:100px;" name="adsence_script_social" >'.$adsence_script_social.'</textarea>';
	echo '<p><strong>Script Sidebar </strong></p>';
	echo '<textarea style="width:100%; min-height:100px;" name="adsence_script_sidebar" >'.$adsence_script_siderbar.'</textarea>';
	echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
}

//Save the data of the Meta field
add_action( 'save_post', 'save_custom_content_meta_box', 10, 1 );
if ( ! function_exists( 'save_custom_content_meta_box' ) )
{
    function save_custom_content_meta_box( $post_id ) {
       
        if ( ! isset( $_POST[ 'custom_product_field_nonce' ] ) ) {
            return $post_id;
        }
        $nonce = $_REQUEST[ 'custom_product_field_nonce' ];
        if ( ! wp_verify_nonce( $nonce ) ) {
            return $post_id;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        if ( 'product' == $_POST[ 'post_type' ] ){
            if ( ! current_user_can( 'edit_product', $post_id ) )
                return $post_id;
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) )
                return $post_id;
        }
        update_post_meta( $post_id, 'adsence_script', $_POST[ 'adsence_script' ]);
		update_post_meta( $post_id, 'adsence_script_social', $_POST[ 'adsence_script_social' ]);
		update_post_meta( $post_id, 'adsence_script_sidebar', $_POST[ 'adsence_script_sidebar' ]);
        
    }
}

// add_action('woocommerce_after_single_product_summary',function(){ 
// 	global $post;
	
// 	$adsence_script = get_post_meta($post->ID, 'adsence_script', true);
// 	if(!empty($adsence_script)){ 
// 		echo '<div style="margin: 20px 0px;" class="adsence_ad">' . $adsence_script . '</div>';
// 	}
// },25);
// add_action('woocommerce_single_product_summary',function(){ 
// 	global $post;
	
// 	$adsence_script = get_post_meta($post->ID, 'adsence_script_social', true);
// 	if(!empty($adsence_script)){ 
// 		echo '<div style="margin: 20px 0px;" class="adsence_ad">' . $adsence_script . '</div>';
// 	}
// },9999);

// add_shortcode( 'adsense_shortcode', 'adsense_shortcode' );
// function adsense_shortcode( $atts ) {
//    global $post;
	
// 	$adsence_script = get_post_meta($post->ID, 'adsence_script_sidebar', true);
// 	if(!empty($adsence_script)){ 
// 		$html = '<div style="margin: 20px 0px;" class="adsence_ad">' . $adsence_script . '</div>';
// 	}
// 	return $html;
// }

add_action( 'widgets_init', function() {
    register_sidebar(
        array(
            'id'            => 'blog-below-header',
            'name'          => __( 'Blog Below Header' ),
            'description'   => __( 'Show Widget Below Header' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
});



add_filter('dokan_rest_get_stores_args',function($args,$request){
   // echo "<pre>"; print_r($args); echo '</pre>';
	//$args['orderby'] = 'total_orders';
// 	$args['include'] = array(6,11,12,19);
// 	$args['order'] = 'DESC';
	return $args;
},100,2);

// Checkout payment icon
function njengah_woocommerce_cod_icon( $icon, $id ) {
	if( $id == 'dokan-stripe-connect'){
		return '<img class="paymenticons" src="https://plantly.io/plantly-credit-card-icons.svg">'; 
	}
	return $icon;
} 
add_filter( 'woocommerce_gateway_icon', 'njengah_woocommerce_cod_icon', 999999999999999, 2 );



// Automate View Send Sms to the Vendor
add_filter( 'automatewoo/variables', 'my_automatewoo_variables' );
function my_automatewoo_variables( $variables ) {
	$variables['order']['vendor_phone'] = dirname(__FILE__) . '/vendor_message.php';
	return $variables;
}

// Automate rules.
add_filter('automatewoo/rules/includes', 'my_automatewoo_rules' );
function my_automatewoo_rules( $rules ) {
	$rules['vendor_orders'] = dirname(__FILE__) . '/vendor_message_rule.php'; // absolute path to rule
	return $rules;
}

// Automate workflow for vendor sms
add_action('dokan_dashboard_content_inside_before',function(){
	$store_info = dokan_get_store_info( get_current_user_id() );
	if(empty($store_info['phone'])){ echo '<style>.dokan-warning.phone-warning {max-width:100% !important;width: max-content;padding: 10px 20px;border-radius: 3px;background: #ff000091;color: white;border: 1px solid #ff6c6c;}
	.dokan-warning.phone-warning a {
    color: white;
    text-decoration: underline;
    font-weight: bold;
}</style>';
		echo '<div class="dokan-warning phone-warning"> Please add your phone number in order to receive new order notifications on your phone. <a href="/dashboard/settings/store"> Click here to add</a></div>';
	}
});


// Modifying PDF Invoice Print
add_action( 'wpo_wcpdf_after_document', function($type , $order){
	if($type == 'invoice'):
	    
		$sellers = dokan_get_sellers_by( $order->get_id() );	
		foreach($sellers as $seller_id => $products){
			
			
			echo '<div style="text-align:center;">';
				$seller_info = get_user_meta( $seller_id, 'dokan_profile_settings', true ); //print_r( wp_get_attachment_image_src($seller_info['gravatar']));
// 				if(!empty($seller_info['gravatar'])){
// 					echo '<img width="75" height="75" src="'.wp_get_attachment_image_src($seller_info["gravatar"])[0].'">';
// 				}
// 				if(!empty($seller_info['store_name'])){
// 					echo '<div>' . $seller_info["store_name"] . '</div>';
// 				}
				echo '<div>Thank you for shopping with us!<br>Powered by <img width="20" style="margin-left: 3px;margin-top:5px;display:inline-block;" src="https://plantly.io/wp-content/uploads/2020/10/leaf-black.jpg"> </div>';
			echo '</div>';
		}// echo 'heelo'; print_r(
	endif;
},100,2 );

add_action('wpo_wcpdf_before_order_details',function($type, $order){
	if($type == 'invoice'):
	    
		$sellers = dokan_get_sellers_by( $order->get_id() );
		
		foreach($sellers as $seller_id => $products){
			$store_user = dokan()->vendor->get( $seller_id );
			$seller_info = get_user_meta( $seller_id, 'dokan_profile_settings', true );
			if(!empty(dokan_get_seller_short_address( $seller_id , false )) || !empty($store_user->get_phone())){
				echo '<div style="margin-bottom: 20px;"><h3 style="font-size:20px;"><strong>Seller Details</strong></h3><br>';
				if(!empty($seller_info['store_name'])){
					echo '<strong>'.$seller_info[store_name] . '</strong><br>';
				}
				echo dokan_get_seller_short_address( $seller_id , false ) . '<br>';
				if(!empty($store_user->get_phone())){
					echo $store_user->get_phone() . '<br>';
				}
				if(!empty($store_user->get_email())){
					echo '<a href="mailto:'.$store_user->get_email() . '">'.$store_user->get_email().'</a><br>';
				}
				echo '</div>';
			}
		}// echo 'heelo'; print_r(
	endif;
	
},100,2);



//Modifying Query on Store page.
add_action('pre_get_posts','store_query_filter_wdc',100,1);
function store_query_filter_wdc( $query ) {
		
        global $wp_query; //echo 'f';
if(strpos( $_SERVER['REQUEST_URI'], 'wp-json/wc/v3/products/reviews' ) !== false): return; endif;
if(strpos( $_SERVER['REQUEST_URI'], 'wp-json/ajax-search-pro/v0' ) !== false): return; endif;
        $author = get_query_var( dokan_get_option( 'custom_store_url', 'dokan_general', 'store' ) );

        if ( ! is_admin() && $query->is_main_query() && ! empty( $author ) ) { //echo '<pre>'; print_r($query); echo '</pre>';
            $seller_info = get_user_by( 'slug', $author );

            if ( ! $seller_info ) {
                return get_404_template();
            }

            $store_info    = dokan_get_store_info( $seller_info->data->ID );
            $post_per_page = 20;

            do_action( 'dokan_store_page_query_filter', $query, $store_info );
            set_query_var( 'posts_per_page', $post_per_page );
			$query->set('orderby','meta_value');
			$query->set('meta_key','_stock_status');
			$query->set('order','ASC');

            $query->set( 'post_type', 'product' );
            $query->set( 'author_name', $author );

            $tax_query                    = [];
            $query->query['term_section'] = isset( $query->query['term_section'] ) ? $query->query['term_section'] : [];

            if ( $query->query['term_section'] ) {
                array_push(
                    $tax_query, [
                        'taxonomy' => 'product_cat',
                        'field'    => 'term_id',
                        'terms'    => $query->query['term'],
                    ]
                );
            }

            // Hide out of stock products
            $product_visibility_terms  = wc_get_product_visibility_term_ids();
            $product_visibility_not_in = [ is_search() && $query->is_main_query() ? $product_visibility_terms['exclude-from-search'] : $product_visibility_terms['exclude-from-catalog'] ];

            if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
                $product_visibility_not_in[] = $product_visibility_terms['outofstock'];
            }

            if ( ! empty( $product_visibility_not_in ) ) {
                array_push(
                    $tax_query, [
                        'taxonomy' => 'product_visibility',
                        'field'    => 'term_taxonomy_id',
                        'terms'    => $product_visibility_not_in,
                        'operator' => 'NOT IN',
                    ]
                );
            }
			
            $query->set( 'tax_query', apply_filters( 'dokan_store_tax_query', $tax_query ) );
        }
    }



//Thankyou text change order confimation page
add_filter('woocommerce_thankyou_order_received_text',function($text, $order){
	return 'Success! Thank you. Your order has been received.<div style="font-size:14px">You will receive a note from the vendor when shipped.</div> ';
},100,2);






// For gettings all the products have no shipping class assigned
add_shortcode('disabled_reviews_products',function(){
	$html = '';
	
		$args = array(
			//'author' => $current_user->ID,
			'post_type' => 'product',
		//	'fields' => 'ids',
			'post_status' => 'publish',
			'posts_per_page' =>-1,
			'comment_status' => 'closed'
			
		);
		if(isset($_GET['_stock_status'])){
			$args['meta_value']    = $_GET['_stock_status'];
			$args['meta_key'] = '_stock_status';
			$checked = $_GET['_stock_status'] == 'instock' ? 'checked="checked" ': '';
		}
		$query = new WP_Query($args); //echo '<pre>'; print_r($query); echo '</pre>';
	
	
	// Code for opening reviews on all products. 
// 	echo count($query->posts);
// 	echo '<pre>'; print_r($query->posts); echo '</pre>';
	//foreach($query->posts as $post){
	//echo	$post->ID;
        //  wp_update_post(
        // array(
		// 	'ID'             =>$post->ID,
		// 	'comment_status' => 'open',
        // )
   // );
	//}
	
	
	
	
	
		$html = '<div>';
		$html .=  'Total : ' . count($query->posts);
	$html .= "<table><tr><th>Link</th><th>Vendor</th><th>Email</th><th>In Stock</th><th>Visible</th></tr>";
		while($query->have_posts()){ $query->the_post();
			$product = wc_get_product(get_the_ID());
			$visible = $product->is_visible() ? 'Yes' : 'No';
			$stock = $product->is_in_stock() ? 'Yes' : 'No';
			$html .=  '<tr><td><a href="' . get_the_permalink() . '">'. get_the_permalink() .'</a> </td><td>'. dokan_get_store_info(get_the_author_meta("id") )["store_name"] .'</td><td>'. get_the_author_meta("user_email") .'</td><td>'.$stock.'</td><td>'.$visible.'</td></tr>';
		}
	$html .= "</table>";
		$html .=  '</div>';
	
	return $html;
});





add_action( 'dokan_new_product_added', function($product_id, $post_data){
$product_shipping_class = ( isset( $post_data['product_shipping_class'] ) && $post_data['product_shipping_class'] > 0 && 'external' !== $product_type ) ? absint( $post_data['product_shipping_class'] ) : '';
        wp_set_object_terms( $product_id, $product_shipping_class, 'product_shipping_class' );
},10,2);




// No Shipping Classes Products Notice to Vendor.
add_action('dokan_dashboard_content_inside_before',function(){
	global $current_user;
	$args = array(
		'author' => $current_user->ID,
		'post_type' => 'product',
		'post_status' => 'any',
		'post_per_page' => -1,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'product_shipping_class',
				'operator'  => 'NOT EXISTS'
			)
		)
	
	);
	$query = new WP_Query($args); 
	if(count($query->posts) > 0 ){
		
		echo '<style>.dokan-warning.phone-warning {max-width:100% !important; width: max-content;padding: 10px 20px;border-radius: 3px;background: #ff000091;color: white;border: 1px solid #ff6c6c;}
	.dokan-warning.phone-warning a {
    color: white;
    text-decoration: underline;
    font-weight: bold;
}</style>';
		echo '<div class="dokan-warning phone-warning"> There are some products on your store without shipping class. <a class="without-class"> Click here</a> to see the products. Please add shipping class to these products to make them purchaseable. </div>';
	}
}); 


//For saving Terms
add_action( 'wp_ajax_save_shipping_class', 'save_shipping_class' );
add_action( 'wp_ajax_nopriv_save_shipping_class', 'save_shipping_class' );
function save_shipping_class(){
	if(!isset($_POST['id']) || empty($_POST['id'])){
		wp_send_json_error();
		return;
	}
	$post = get_post($_POST['id']);
	if(empty($post)){
		wp_send_json_error();
	}else{
		$product_shipping_class = (isset( $_POST['product_shipping_class']) && $_POST['product_shipping_class'] > 0 && 'external' !== $product_type) ? absint($_POST['product_shipping_class']) : '';
		$response = wp_set_object_terms( $post->ID , $product_shipping_class, 'product_shipping_class' );
		if(!is_wp_error($response)){
			wp_send_json_success(array('message'=>'success'));
		}
	}
	
}

add_shortcode('vendor_products_without_shipping-class',function(){
	global $current_user;
	$args = array(
		'author' => $current_user->ID,
		'post_type' => 'product',
		'post_status' => 'any',
		'post_per_page' => -1,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'product_shipping_class',
				'operator'  => 'NOT EXISTS'
			)
		)
	);
	$query = new WP_Query($args); 
	if(count($query->posts) > 0){
		$html = '<h3 style="font-size:20px;">Please select a shipping class for each of the following products so they can be purchased.</h3>';
	}
		ob_start();
	?>
<style>
.edit-section a.button {
    height: unset !important;
    line-height: 2.3;
    border-radius: 3px;
}
.edit-section a.button.disabled {
    pointer-events: none !important;
    height: unset !important;
    line-height: 2.3 !important;
    padding: 0px 25px !important;
}
</style>
	<table class="shipping-classes-table dokan-table dokan-table-striped product-listing-table dokan-inline-editable-table" id="dokan-product-list-table">
			
			<thead>
				<tr>
		
					<th><?php esc_html_e( 'Image', 'dokan-lite' ); ?></th>
					<th><?php esc_html_e( 'Name', 'dokan-lite' ); ?></th>
					<th><?php esc_html_e( 'Choose Shipping Class', 'dokan-lite' ); ?></th>
					<th><?php esc_html_e( 'Action', 'dokan-lite' ); ?></th>

				</tr>
			</thead>
			<tbody>
				<?php
				if ( $query->have_posts() ) {
					while ($query->have_posts()) {
						$query->the_post(); ?>
							<tr class="post-item" data-id="<?php echo get_the_ID(); ?>">
								<td class="img"><img width="60" height="60" src="<?php echo get_the_post_thumbnail_url(); ?>"></td>
								<td class="name"><?php the_title(); ?></td>
								<td class="add-shipping">
									<?php
										$args = array(
											'taxonomy'          => 'product_shipping_class',
											'hide_empty'        => 0,
											'name'              => 'product_shipping_class',
											'id'                => 'product_shipping_class',
											'selected'          => $current_shipping_class,
											'class'             => 'dokan-form-control'
										);
										wp_dropdown_categories( $args );
									?>
								</td>
								<td class="edit-section" ><a class="button" data-id="<?php echo get_the_ID(); ?>">Save</a></td>
							</tr>
						

						<?php
					}

				} else {
				?>
					<tr>
						<td colspan="11"><?php esc_html_e( 'No product found', 'dokan-lite' ); ?></td>
					</tr>
				<?php } ?>
			</tbody>

	</table> <?php 
	
	return $html.ob_get_clean();
});



// No Shipping Class Products
add_shortcode('no_shipping_class_products',function(){
	$html = '';
	
		$args = array(
			//'author' => $current_user->ID,
			'post_type' => 'product',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'product_shipping_class',
					'operator'  => 'NOT EXISTS'
				)
			)

		);
		$checked = '';
		if(isset($_GET['_stock_status'])){
			$args['meta_value']    = $_GET['_stock_status'];
			$args['meta_key'] = '_stock_status';
			$checked = $_GET['_stock_status'] == 'instock' ? 'checked="checked" ': '';
		}
		$query = new WP_Query($args); //echo '<pre>'; print_r($query); echo '</pre>';
	$html = '<div>';
		$html .=  'Total : ' . count($query->posts);
	$html .= "<table><tr><th>Link</th><th>Vendor</th><th>Email</th><th>In Stock</th><th>Visible</th></tr>";
		while($query->have_posts()){ $query->the_post();
			$product = wc_get_product(get_the_ID());
			$visible = $product->is_visible() ? 'Yes' : 'No';
			$stock = $product->is_in_stock() ? 'Yes' : 'No';
			$html .=  '<tr><td><a href="' . get_the_permalink() . '">'. get_the_permalink() .'</a> </td><td>'. dokan_get_store_info(get_the_author_meta("id") )["store_name"] .'</td><td>'. get_the_author_meta("user_email") .'</td><td>'.$stock.'</td><td>'.$visible.'</td></tr>';
		}
	$html .= "</table>";
		$html .=  '</div>';
	return $html;
}); 









// Having products tax disabled. 
add_shortcode('no_tax_class_products',function(){
	$html = '';
	
		$args = array(
			//'author' => $current_user->ID,
			'post_type' => 'product',
			//'fields' => 'ids',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => '_tax_status',
					'value'  => 'taxable',
					'compare' => '!='
				)
			)

		);
	/*
	 // Code for making products taxable.
	$query = new WP_Query($args); //echo '<pre>'; print_r($query); echo '</pre>';
	echo count($query->posts);
	echo '<pre>'; print_r($query->posts); echo '</pre>';
	foreach($query->posts as $post){
		
        update_post_meta($post,'_tax_status','taxable');
	};*/
	
	
		$checked = '';
		if(isset($_GET['_stock_status'])){
			$args['meta_value']    = $_GET['_stock_status'];
			$args['meta_key'] = '_stock_status';
			$checked = $_GET['_stock_status'] == 'instock' ? 'checked="checked" ': '';
		}
		$query = new WP_Query($args); //echo '<pre>'; print_r($query); echo '</pre>';
	$html = '<div>';
		$html .=  'Total : ' . count($query->posts);
	$html .= "<table><tr><th>Link</th><th>Vendor</th><th>Email</th><th>In Stock</th><th>Visible</th></tr>";
		while($query->have_posts()){ $query->the_post();
			$product = wc_get_product(get_the_ID());
			$visible = $product->is_visible() ? 'Yes' : 'No';
			$stock = $product->is_in_stock() ? 'Yes' : 'No';
			$html .=  '<tr><td><a href="' . get_the_permalink() . '">'. get_the_permalink() .'</a> </td><td>'. dokan_get_store_info(get_the_author_meta("id") )["store_name"] .'</td><td>'. get_the_author_meta("user_email") .'</td><td>'.$stock.'</td><td>'.$visible.'</td></tr>';
		}
	$html .= "</table>";
		$html .=  '</div>';
	return $html;
}); 












/*
//Assign Small Class to all products having no shipping assigned shortcode = [no_shipping_class_products_update]
add_shortcode('no_shipping_class_products_update',function(){
	$html = '';
	
		$args = array(
			//'author' => $current_user->ID,
			'post_type' => 'product',
			'fields'    => 'ids',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'product_shipping_class',
					'operator'  => 'NOT EXISTS'
				)
			)

		);
		$checked = '';
		if(isset($_GET['_stock_status'])){
			$args['meta_value']    = $_GET['_stock_status'];
			$args['meta_key'] = '_stock_status';
			$checked = $_GET['_stock_status'] == 'instock' ? 'checked="checked" ': '';
		}
		$query = new WP_Query($args); //echo '<pre>'; print_r($query); echo '</pre>';
	echo count($query->posts);
	echo '<pre>'; print_r($query->posts); echo '</pre>';
	foreach($query->posts as $post){
        wp_set_object_terms($post, 530 , 'product_shipping_class' );
	}
	$html = '';
	return $html;
}); */

// Shortcode for showing faulty class price in shipping. 
add_shortcode('wrong-shipping-cost',function(){	
	$users = new WP_User_Query(array('role__in' => array('seller','administrator'),'fields'=>'ID'));
	$html = '<table style="margin: auto;"><thead><tr><th>User ID</th><th>Email</th><th>Store Name</th><th>Wrong Cost Input?</th></tr></thead><tbody>';
	foreach($users->results as $seller){ //echo $seller;
		$shipping_methods = WeDevs\DokanPro\Shipping\ShippingZone::get_shipping_methods(1,$seller);
		$checked = false;
		foreach($shipping_methods as $method){
			if($method['id'] == 'flat_rate'){
				if (strpos($method['settings']['cost'], '$') !== false) {
					$checked = true;
					break;
				}
				foreach($method['settings'] as $key => $value){
					if(strpos($key,'class_cost_') != false && strpos($value , '$') != false){
						$checked = true;
						break;
					}
				}
			}
		} //echo '<pre>'; print_r(get_user_meta($seller)); echo '</pre>';
		$checked = $checked ? 'Yes' : 'No';
		$html .= '<tr><td>'.$seller.'</td><td>'.get_userdata($seller)->user_email.'</td><td>'.dokan_get_store_info($seller)["store_name"].'</td><td>'.$checked.'</td></tr>';
	}
	$html .= '</tbody></table>';
	return $html;
});








// Shortcode for zero_base_cost_users 
add_shortcode('zero_base_cost_users',function(){	
	$users = new WP_User_Query(array('role__in' => array('seller','administrator'),'fields'=>'ID'));
	$html = '<table style="margin: auto;"><thead><tr><th>User ID</th><th>Email</th><th>Store Name</th><th>Zero/Not Zero</th></tr></thead><tbody>';
	foreach($users->results as $seller){ //echo $seller;
		$shipping_methods = WeDevs\DokanPro\Shipping\ShippingZone::get_shipping_methods(1,$seller);
		$checked = false;
		foreach($shipping_methods as $method){ //echo '<pre>';print_r($method);echo'</pre>';
			if($method['id'] == 'flat_rate' && $method['enabled'] == 'yes' ){
				$checked = $method['settings']['cost'];
// 				if ($method['settings']['cost'] !== '0') {
// 					$checked = true;
// 					break;
// 				}
				
			}
		} //echo '<pre>'; print_r(get_user_meta($seller)); echo '</pre>';
		//$checked = $checked ? 'Not Zero' : 'Zero';
		$html .= '<tr><td>'.$seller.'</td><td>'.get_userdata($seller)->user_email.'</td><td>'.dokan_get_store_info($seller)["store_name"].'</td><td>'.$checked.'</td></tr>';
	}
	$html .= '</tbody></table>';
	return $html;
});











// Modifying Help Text on Shipping Page. 
add_filter('dokan_dashboard_settings_helper_text',function($help_text,$query_vars){
	 if ( $query_vars == 'shipping' ) {

		 $help_text = sprintf ( '<p>%s</p>',
							   __( 'A shipping zone is a geographic region where a certain set of shipping methods are offered. We will match a customer to a single zone using their shipping address and present the shipping methods within that zone to them.', 'dokan' ),
							   __( 'If you want to use the previous shipping system then', 'dokan' ),
							   esc_url( dokan_get_navigation_url('settings/regular-shipping' ) ),
							   __( 'Click Here', 'dokan' )
							  );

		 if ( 'yes' == $enable_shipping ) {
			 $help_text .= sprintf ( '<p>%s <a href="%s">%s</a></p>',
									__( 'If you want to use the previous shipping system then', 'dokan' ),
									esc_url( dokan_get_navigation_url('settings/regular-shipping' ) ),
									__( 'Click Here', 'dokan' )
								   );
		 }
	 }
	return $help_text;
	
},100,2);



// Hiding Base Cost

add_action( 'wp_enqueue_scripts', function(){

	
		$shipping_methods = WeDevs\DokanPro\Shipping\ShippingZone::get_shipping_methods(1,get_current_user_id());
		$checked = false; 
		foreach($shipping_methods as $method){ //echo '<pre>';print_r($method);echo'</pre>';
			if($method['id'] == 'flat_rate' && $method['enabled'] == 'yes' ){
				//$checked = $method['settings']['cost'];
				if ($method['settings']['cost'] != '0'  ) {
					$checked = true;
					//echo '<pre>'; print_r($shipping_methods) ; echo '</pre>farhan';
					break;
				}
				
			}
		}
	if($checked == false){
		echo '<style>label[for="method_cost"], #method_cost {display: none !important;}</style>';
	}
	
} );





// Showing Auction Detail on Post Grid
// add_action('woocommerce_after_shop_loop_item','woocommerce_auction_bid');
// add_action('woocommerce_after_shop_loop_item','woocommerce_auction_add_to_cart');
// add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_auction_ajax_conteiner_start', 21 );
// add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_auction_condition', 23 );
// add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_auction_countdown', 24 );
// add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_auction_dates', 24 );
// add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_auction_reserve', 25 );
// add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_auction_sealed', 25 );
// add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_auction_max_bid', 25 );
// add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_auction_bid_form', 25 );
// add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_auction_ajax_conteiner_end', 27 );




add_filter ( 'woocommerce_account_menu_items', function( $menu_links ){
	unset( $menu_links['payment-methods'] ); 
	unset( $menu_links['view-feeds'] ); 
	return $menu_links;	
},100,1);


// Sms Newsfeed
add_shortcode('sms_notification_form',function(){ 
	$user_id = get_current_user_id();
	if(is_user_logged_in() && get_user_meta($user_id , 'billing_phone', true) == '' && !isset($_COOKIE['sms-notification-form-closed'])){
		$html = '<div class="sms-notification-form"><a class="sms-notification-close"><i class="fa fa-times"></i></a>';
		$html .= '<label>🔮 Level up your Plant Auction Game with SMS bidding notifications. <br>Add Your Mobile Number:</label>';
		$html .= '<div class="form"><input type="phone" name="phone" placeholder="507-556-4769" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"><button class="save-phone dokan-btn dokan-btn-theme">Submit</button></div>';
		$html .= '</div>';
	}
	return $html;
	
},100,1);
add_action( 'wp_ajax_save_billing_phone', 'save_billing_phone' );
add_action( 'wp_ajax_save_billing_phone', 'save_billing_phone' );
function save_billing_phone(){
	$user_id = get_current_user_id();
	if(empty($_POST['phone'])){
		return false;
	}
	update_user_meta($user_id , 'billing_phone', $_POST['phone']);
	wp_send_json_success(array('success' => true));
}


add_action('woocommerce_simple_auction_won',function($product_id){
	$bidder = get_post_meta($product_id, '_auction_current_bider', true);
	add_to_cart_product_programmatically( $bidder, $product_id );	
});


function add_to_cart_product_programmatically( $user_id, $product_id ){

    global $woocommerce,$wpdb;

    $array = $wpdb->get_results("select meta_value from ".$wpdb->prefix."usermeta where meta_key='_woocommerce_persistent_cart_1' and user_id = ".$user_id);
    $data =$array[0]->meta_value;
    $cart_data=unserialize($data);

    $flag = 0;
    foreach($cart_data['cart'] as $key => $val) {
        //$_product = $val['data'];
        if($val['product_id'] != $product_id){
            $flag = 0;
        }
        elseif($val['product_id'] == $product_id) {
            $flag = 2;

        }
    }
    if($flag == 2){
       // $cart_data['cart'][$key]['quantity']++;
    }
    else{
        $string = $woocommerce->cart->generate_cart_id( $product_id, 0, array(), $cart_data['cart'] );
        $product = wc_get_product( $product_id );
        $cart_data['cart'][$string] = array(
            'key' => $string,
            'product_id' => $product_id,
            'variation_id' => 0,
            'variation' => array(),
            'quantity' => 1,
            'line_tax_data' => array(
                'subtotal' => array(),
                'total' => array()
            ),
            'line_subtotal' => $product->get_price(),
            'line_subtotal_tax' => 0,
            'line_total' => $product->get_price(),
            'line_tax' => 0,
        );
		$objProduct = new WC_Session_Handler();
		$wc_session_data = $objProduct->get_session($user_id);
		if($wc_session_data){
			$wc_session_data['cart'] = serialize($cart_data['cart']);
			$serializedObj = maybe_serialize($wc_session_data);
			$table_name = 'wp_woocommerce_sessions';
			// Update the wp_session table with updated cart data
			$wpdb->update( $table_name, array( 'session_value' => $serializedObj ), array( 'session_key' => $user_id ) );
		}
		
	

		//echo "<pre>";
		//print_r($cart_data);
		//exit;
		//$serialize_data = serialize($cart_data);
		//$woocommerce->cart->add_to_cart( $_POST['product_id'] );
		update_user_meta($user_id,'_woocommerce_persistent_cart_1',$cart_data);
	   // API response whatever you want
	}
}



// add_action( 'wp_enqueue_scripts', 'bbloomer_disable_woocommerce_cart_fragments', 11 ); 
// function bbloomer_disable_woocommerce_cart_fragments() { 
//    wp_dequeue_script( 'wc-cart-fragments' ); 
// }



add_action('woocommerce_product_query',function($p_query,$instance){
	if(is_product_category()){
		$query = new WP_User_Query(array(
			'role' => 'seller',
			'fields' => 'ids',
			'meta_key' => 'hide_only_shop_products',
			'meta_value' => true,
			'meta_compare' =>  '='
		));
		
	}
	if(!empty($query->results)){
		$posts = get_posts(array('post_type'=> 'product','author__in' => $query->results ,'post_status'=>'publish','fields'=>'ids'));
		if(!empty($posts)){
			if(!empty($p_query->get('post__not_in'))){
				$exclude =	array_merge($posts,$p_query->get('post__not_in'));
			}else{
				$exclude = $posts;
			}
//echo '<pre>'; print_r($exclude); echo '</pre>';
			$p_query->set('post__not_in',$exclude);
		}
		//echo '<pre>'; print_r($posts); echo '</pre>';
	}
	

},9999,2);






add_action( 'pre_get_posts', 'hidden_search_query_fix' ,999999);
function hidden_search_query_fix( $query ) {
	if(strpos( $_SERVER['REQUEST_URI'], 'wp-json/wc/v3/products/reviews' ) !== false): return; endif;
	if ( ! is_admin() && isset( $query->query['post_type'] ) && $query->query['post_type'] === 'product' && is_rest()) { 
		if($_GET['catalog_visibility'] != 'all'){
			$tax_query = $query->get( 'tax_query' );
			if(!empty($tax_query)){
				$tax_query[] = array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'exclude-from-catalog',
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'exclude-from-catalog',
						'operator' => '!=',
					),
				);
			}else{
				$tax_query = array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'exclude-from-catalog',
						'operator' => 'NOT IN',
					),
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'exclude-from-catalog',
						'operator' => '!=',
					),
				);
			}
			

			$query->set( 'tax_query', $tax_query );
		}
		
	}
}

if ( !function_exists( 'is_rest' ) ) {
	
	function is_rest() {
		$prefix = rest_get_url_prefix( );
		if (defined('REST_REQUEST') && REST_REQUEST // (#1)
				|| isset($_GET['rest_route']) // (#2)
						&& strpos( trim( $_GET['rest_route'], '\\/' ), $prefix , 0 ) === 0)
				return true;

		// (#3)
		global $wp_rewrite;
		if ($wp_rewrite === null) $wp_rewrite = new WP_Rewrite();
			
		// (#4)
		$rest_url = wp_parse_url( trailingslashit( rest_url( ) ) );
		$current_url = wp_parse_url( add_query_arg( array( ) ) );
		return strpos( $current_url['path'], $rest_url['path'], 0 ) === 0;
	}
}
add_action('wp_head',function(){
	?>
	<script>
		jQuery(document).ready(function(){
			jQuery('body').on('click','#hard-link',function(){
				jQuery.blockUI();
				window.location.href = jQuery(this).attr('href');
			});
		});
	</script>

	<?php
});


function searchfilter($query) {

if ($query->is_search && !is_admin() ) {
	if(empty($query->get('post_type'))){
		$query->set('post_type',array('post'));
	}
    
}

return $query;
}

add_filter('pre_get_posts','searchfilter');



/**
 * This is our callback function that embeds our phrase in a WP_REST_Response
 */
function prefix_get_endpoint_phrase() {
     	$cookie = $request["cookie"];
        if (isset($request["token"])) {
            $cookie = urldecode(base64_decode($request["token"]));
        }
        if (!isset($cookie)) {
           return new WP_Error( 'invalid_user', esc_html__( 'Token is not valid.', 'my-text-domain' ), array( 'status' => 404 ) );
        }

        $user_id = validateCookieLogin($cookie);
        if (is_wp_error($user_id)) {
            return $user_id;
        }
        $user = get_userdata($user_id);
    return rest_ensure_response( $user);
}
 
function prefix_register_example_routes() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( '/vendor-admin', '/storeinfo', array(
        'methods'  => WP_REST_Server::READABLE,
        'callback' => 'prefix_get_endpoint_phrase',
    ) );
}
 
add_action( 'rest_api_init', 'prefix_register_example_routes' );
add_action( 'template_redirect', function() {
	if(!is_admin()){
		global $wp;
		$store = explode('/',$wp->request); 
		if($store[0] == 'store' && !empty($store[1])){
			$user = get_user_by('slug',$store[1]);
           if(empty($user)){
            wp_redirect( home_url( '/404' ) );
           }
		}
	}
	
    // if ( is_front_page() ) {
    //     wp_redirect( home_url( '/dashboard/' ) );
    //     die;
    // }
 
    // if ( is_page('contact') ) {
    //     wp_redirect( home_url( '/new-contact/' ) );
    //     die;
    // }
 
},1000);


// add_action('wp_head',function(){
// 	global $martfury_customize;
// 	if(get_current_user_id() == 6){ echo '<pre>'; print_r($martfury_customize->get_option('catalog_vendor_name')); echo '</pre>';
// 		//echo martfury_get_option( 'catalog_vendor_name' ); //echo 'farhanahmed';
// 	}

	

// });
// function martfury_get_option( $name ) {
// 	global $martfury_customize;

// 	$value = false;

// 	$value = $martfury_customize->get_option( $name );

// 	return apply_filters( 'martfury_get_option', $value, $name );
// }

add_filter( 'get_avatar', function($avatar, $id_or_email, $size, $default, $alt, $args ){

$store_info = dokan_get_store_info($id_or_email); 
if(!empty($store_info['gravatar'])){
	$url = wp_get_attachment_image_src($store_info['gravatar']); 
	$avatar = '<img src="'.$url[0].'">';
}
	return $avatar;
},999999,6);


/**
 * Register the WooCommerce endpoints so they will be cached.
 */
function wprc_add_wc_endpoints( $allowed_endpoints ) {
    if ( ! isset( $allowed_endpoints[ 'wc/v3' ] ) || ! in_array( 'products', $allowed_endpoints[ 'wc/v3' ] ) ) {
        $allowed_endpoints[ 'wc/v3' ][] = 'products';
    }
    return $allowed_endpoints;
}
add_filter( 'wp_rest_cache/allowed_endpoints', 'wprc_add_wc_endpoints', 10, 1);

/**
 * Register the WooCommerce endpoints so they will be cached.
 */
function wprc_add_cacheable_request_headers( $cacheable_headers ) {
    $cacheable_headers['wc/v3/products'] = 'authorization';
    return $cacheable_headers;
}
add_filter('wp_rest_cache/cacheable_request_headers', 'wprc_add_cacheable_request_headers', 10, 1);



/** Disable Ajax Call from WooCommerce */
// add_action( 'wp_enqueue_scripts', 'dequeue_woocommerce_cart_fragments', 1000); 
// function dequeue_woocommerce_cart_fragments() { 
// 	wp_dequeue_script('wc-cart-fragments'); 
// }

add_action('wp_head',function(){
	wp_register_script( 'mediavine', '//scripts.mediavine.com/tags/plantly.js' );
	wp_enqueue_script( 'mediavine' );
	//echo '<script type="text/javascript" async="async" data-noptimize="1" data-cfasync="false" src="//scripts.mediavine.com/tags/plantly.js"></script>';
});


add_action( 'after_setup_theme', 'wdc_custom_image_size_theme_setup' );
function wdc_custom_image_size_theme_setup() {
    add_image_size( 'shop_catalog', 300,300, true ); // 300 pixels wide (and unlimited height)
}

// add_action( 'wp_insert_post', function( $post_ID, $post ){
//      $post->comment_status = 'open';
//      wp_update_post( $post );
// }, 10, 2 );


// Balty Image
add_filter('woocommerce_product_get_image', function($image_html, $product, $size, $attr, $placeholder, $image){
	if(!isset($attr['alt'])){

		if ( $product->get_image_id() ) {
			$attr['alt'] = $product->get_name();
			$image = wp_get_attachment_image( $product->get_image_id(), $size, false, $attr );
		} elseif ( $product->get_parent_id() ) {
			$parent_product = wc_get_product( $product->get_parent_id() );
			if ( $parent_product ) {
				$attr['alt'] = $parent_product->get_name();
				$image = $parent_product->get_image( $size, $attr, $placeholder );
			}
		}
	}
	return $image;
},100,6);


function asp_custom_rest_handler( $data ) {
	global $wpdb;
    $id = -2;
    $defaults = $args = array(
        's' => ''
    );
    foreach ( $defaults as $k => $v ) {
        $param = $data->get_param($k);
        if ( $param !== null ) {
            $args[$k] = $param;
        }
    }

    // Fetch the search ID, which is probably the WooCommerce search
    foreach ( wd_asp()->instances->get() as $instance ) {
        if ( in_array('product', $instance['data']['customtypes'] ) ) {
            $id = $instance['id'];
            break;
        }
    }

    // No search was found with products enabled, set it explicitly
    if ( $id == -2 ) {
        $args['post_type'] = array('product');
    }

    $asp_query = new ASP_Query($args, $id);
	$posts = array();
	foreach($asp_query->posts as $post){
		$user_id = $post->post_author;
		$get = get_posts(array('author' => $user_id, 'post_type' => 'product','fields' => 'ids','posts_per_page'=> -1,'post_status'=>'publish'));
		$get = $wpdb->get_col(
			$wpdb->prepare(
					"
				SELECT ID FROM $wpdb->posts
				WHERE post_author = $user_id
				AND post_type = 'product'
				AND post_status = 'publish'
					"
				)
		
		); //print_r($get);
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
			
		} else {
			$average = 0;
		} 
		$post->rating_count = $count;
		$post->average_rating = $average;
		$product = wc_get_product( $post->ID );
		$post->regular_price = $product->get_regular_price();
		$post->sale_price = $product->get_sale_price();
		$post->price = 	$product->get_price();
		$posts[] = $post;
		//print_r($post); 
	}
    return $posts;
}

// POST to: http://example.com/wp-json/ajax-search-pro/v1/woo_search
add_action( 'rest_api_init', function () {
    register_rest_route('ajax-search-pro/v0', '/woo_search', array(
        'methods' => 'POST',
        'callback' => 'asp_custom_rest_handler',
    ));
}); 



function my_dequeue_cf7md_assets() { 
   // if( is_page(324) ) { 
		
     	// wp_deregister_script( 'wp-i18n' );
		wp_dequeue_script('wp-i18n' );
		// wp_deregister_script( 'wp-hooks' );
		wp_dequeue_script( 'wp-hooks' );
		// wp_deregister_script( 'wp-polyfill' );
		wp_dequeue_script( 'wp-polyfill' );
		// wp_deregister_script( 'wp-dom-ready' );
		wp_dequeue_script( 'wp-dom-ready' );
		// wp_deregister_script( 'regenerator-runtime' );
		wp_dequeue_script( 'regenerator-runtime' );
		// wp_deregister_script( 'moxiejs' );
		wp_dequeue_script( 'moxiejs' );
		// wp_deregister_script( 'elementor-recaptcha-api' );
		wp_dequeue_script( 'elementor-recaptcha-api' );
		// wp_deregister_script( 'elementor-recaptcha_v3-api' );
		wp_dequeue_script( 'elementor-recaptcha_v3-api' );
		// wp_deregister_script( 'dokan-google-recaptcha' );
		wp_dequeue_script( 'dokan-google-recaptcha' );
		// wp_deregister_script( 'advanced-google-recaptcha-custom');
		wp_dequeue_script( 'advanced-google-recaptcha-custom' );
		// wp_deregister_script( 'clipboard' );
		wp_dequeue_script( 'clipboard' );
	
		wp_dequeue_style( 'cwginstock_bootstrap' );
		wp_dequeue_style( 'cwginstock_frontend_css' );
		wp_dequeue_style( 'wc-prl-css' );
		wp_dequeue_style( 'advanced-google-recaptcha-style' );
	
		wp_dequeue_style( 'jetpack_css' );
		wp_dequeue_style( 'ionicons' );
		wp_dequeue_style( 'elementor-icons-linearicons' );
		wp_dequeue_style( 'elementor-icons-shared-1' );
		wp_dequeue_style( 'dashicons' );
		wp_dequeue_style( 'wc-blocks-style' );
		wp_dequeue_style( 'mediaelement' );
		wp_dequeue_style( 'wc-blocks-vendors-style' );
		wp_dequeue_style( 'dokan-fontawesome' );
		
		if($_GET['debug']){
			echo '<pre>';print_r( wp_styles() );echo '</pre>';
			echo '<pre>';print_r( wp_scripts() );echo '</pre>';
		}
		//wp_dequeue_style( 'photoswipe-default-skin' );
		//wp_dequeue_style( 'photoswipe' );
		
		
    //}
}
add_action( 'wp_enqueue_scripts', 'my_dequeue_cf7md_assets', 999999999 );


add_action('wp_print_scripts',function(){
	// wp_deregister_script( 'wp-i18n' );
	wp_dequeue_script('wp-i18n' );
	// wp_deregister_script( 'wp-hooks' );
	wp_dequeue_script( 'wp-hooks' );
	// wp_deregister_script( 'wp-polyfill' );
	wp_dequeue_script( 'wp-polyfill' );
	// wp_deregister_script( 'wp-dom-ready' );
	wp_dequeue_script( 'wp-dom-ready' );
	// wp_deregister_script( 'regenerator-runtime' );
	wp_dequeue_script( 'regenerator-runtime' );
	// wp_deregister_script( 'moxiejs' );
	wp_dequeue_script( 'moxiejs' );
	// wp_deregister_script( 'elementor-recaptcha-api' );
	wp_dequeue_script( 'elementor-recaptcha-api' );
	// wp_deregister_script( 'elementor-recaptcha_v3-api' );
	wp_dequeue_script( 'elementor-recaptcha_v3-api' );
	// wp_deregister_script( 'dokan-google-recaptcha' );
	wp_dequeue_script( 'dokan-google-recaptcha' );
	// wp_deregister_script( 'advanced-google-recaptcha-custom');
	wp_dequeue_script( 'advanced-google-recaptcha-custom' );
	// wp_deregister_script( 'clipboard' );
	wp_dequeue_script( 'clipboard' );
},100);

add_action( 'before_delete_post', function( $id ) {
    $product = wc_get_product( $id );
    if ( ! $product ) {
        return;
    }
    $all_product_ids         = [];
    $product_thum_id_holder  = [];
    $gallery_image_id_holder = [];
    $thum_id                 = get_post_thumbnail_id( $product->get_id() );
    if ( function_exists( 'dokan' ) ) {
        $vendor = dokan()->vendor->get( dokan_get_current_user_id() );

        if ( ! $vendor instanceof WeDevs\Dokan\Vendor\Vendor || $vendor->get_id() === 0 ) {

            return;
        }
        $products = $vendor->get_products();
        if ( empty( $products->posts ) ) {
            return;
        }
        foreach ( $products->posts as $post ) {
            array_push( $all_product_ids, $post->ID );
        }
    } else {
        $args     = [ 'posts_per_page' => '-1' ];
        $products = wc_get_products( $args );
        foreach ( $products as $product ) {
            array_push( $all_product_ids, $product->get_id() );
        }
    }
    foreach ( $all_product_ids as $product_id ) {
        if ( intval( $product_id ) !== intval( $id ) ) {
            array_push( $product_thum_id_holder, get_post_thumbnail_id( $product_id ) );
            $wc_product        = wc_get_product( $product_id );
            $gallery_image_ids = $wc_product->get_gallery_image_ids();
            if ( empty( $gallery_image_ids ) ) {
                continue;
            }
            foreach ( $gallery_image_ids as $gallery_image_id ) {
                array_push( $gallery_image_id_holder, $gallery_image_id );
            }
        }
    }
    if ( ! in_array( $thum_id, $product_thum_id_holder ) && ! in_array( $thum_id, $gallery_image_id_holder ) ) {
        wp_delete_attachment( $thum_id, true );
        if ( empty( $thum_id ) ) {
            return;
        }
        $gallery_image_ids = $product->get_gallery_image_ids();
        if ( empty( $gallery_image_ids ) ) {
            return;
        }
        foreach ( $gallery_image_ids as $gallery_image_id ) {
            wp_delete_attachment( $gallery_image_id, true );
        }
    }
} );

// add_action('wp_head',function(){
// if($_GET['debugg']){
	
// 	echo '<pre>'; print_r(get_post_meta(95141,'order_id',true)); echo '</pre>';
// }
// });

// add_filter( 'get_the_title', function($post_title, $post_id){

// 	if(!empty(get_post_meta($post_id,'order_id',true))){
// 		$post_title .= ' (Order#'. get_post_meta(95141,'order_id',true).')';
// 	}
// 	return $post_title;
// },100,2);


/* add_filter( 'dokan_rest_get_stores_args', function($args, $request){
	global $wpdb;
   
	$users = $wpdb->get_col( $wpdb->prepare("
		SELECT p.post_author,count(*) AS post_count
		FROM {$wpdb->prefix}posts AS p
		WHERE p.post_status = 'publish' AND p.post_type = 'product'
		GROUP BY p.post_author order by post_count desc
 	"));
// 	$args['orderby'] = 'ID';
// 	$args['order'] = implode(',',$users);
	$ids = array();

	$stores = dokan()->vendor->get_vendors( $args );
	foreach($stores as $store){
		$ids[] = $store->get_id();
	}
	
	
	
$first_array = $users;
$second_array = $ids;

$intersected = array_intersect( $first_array, $second_array );
$users = array_merge( $intersected, array_diff( $first_array, $second_array ) );
$args['include'] = $users;
	//echo '<pre>'; print_r($ids); echo '</pre>';
//echo '<pre>'; print_r($users); echo '</pre>';die();
	return $args;
},99999,2); 
add_action( 'pre_get_users', function($query){
	global $wpdb;
session_start();
	if(!is_admin()){
		   //echo 'ff'; die();
	}

	$users = $wpdb->get_col( $wpdb->prepare("
		SELECT p.post_author,count(*) AS post_count
		FROM {$wpdb->prefix}posts AS p
		WHERE p.post_status = 'publish' AND p.post_type = 'product'
		GROUP BY p.post_author order by post_count desc
 	"));
	
	$ids = array();
	
$query->set('blog_id','');//print_r($query);
	$stores = $query->get_results(); 
	foreach($stores as $store){ 
		$ids[] = $store->ID;
	}

	$first_array = $users;
	$second_array = $ids;
	if(!is_admin()):
	$args = array(
		'meta_query' => array(
			array(
				'key' => 'seller',
				'value' => '1',
				'compare' => '=',
				'type' => 'NUMERIC',
			),
		),
	);
	
// 		$user_query = get_users( $args ); 
// 		echo '<pre>'; print_r($user_query->get_results()); echo '</pre>'; die();
	
	endif;
	$intersected = array_intersect( $first_array, $second_array );
	$users = array_merge( $intersected, array_diff( $first_array, $second_array ) );
	$args['include'] = $users;
	
	$query->set('include',$users);

},1000); */

// add_filter( 'woocommerce_rest_product_review_query', function($prepared_args, $request){
// $user_id = $post->post_author;
// 		$get = get_posts(array('author' => $user_id, 'post_type' => 'product','fields' => 'ids','posts_per_page'=> -1,'post_status'=>'publish'));
// 		$product_comments = get_comments(array('post_author'=>$user_id,'post__in'=> $get,'type' => 'review') );

// echo '<pre>'; print_r($prepared_args); echo '</pre>';
// 	return $prepared_args;
// },999,2);
	
if ( ! function_exists( 'martfury_promotion_custom' ) ) :
	function martfury_promotion_custom() { 
		remove_action( 'martfury_before_header', 'martfury_promotion', 5 );
		$promotion = apply_filters( 'martfury_get_promotion', martfury_get_option( 'promotion' ) );
		
		if ( ! intval( $promotion ) ) {
			return;
		}

		if ( is_page_template( 'template-coming-soon-page.php' ) ) { 
			return;
		}

		if ( intval( martfury_get_option( 'promotion_home_only' ) ) && ! is_front_page() ) { 
			return;
		}

		$button      = '';
		$button_text = martfury_get_option( 'promotion_button_text' );
		$button_link = martfury_get_option( 'promotion_button_link' );
		if ( ! empty( $button_text ) && ! empty( $button_link ) ) {
			$button = sprintf( '<a class="link" href="%s">%s</a>', esc_url( $button_link ), esc_html( $button_text ) );
		}

		if ( intval( martfury_get_option( 'promotion_close' ) ) ) {
			$button .= '<span class="close"><i class="icon-cross2"></i></span>';
		}

		$css_classes = empty( martfury_get_option('promotion_mobile') ) ? 'hidden-xs' : '';

		printf(
			'<div id="top-promotion" class="top-promotion  %s style-%s">
				<div class="%s">
					<div class="promotion-content">
						<div class="promo-inner">
						%s
						</div>
						<div class="promo-link">
						%s
						</div>
					</div>
				</div>
			</div>',
			esc_attr( $css_classes ),
			esc_attr( martfury_get_option( 'promotion_style' ) ),
			martfury_header_container_classes(),
			do_shortcode( wp_kses( martfury_get_option( 'promotion_content' ), wp_kses_allowed_html( 'post' ) ) ),
			$button
		);
	}
endif;
remove_action( 'martfury_before_header', 'martfury_promotion', 5 );
add_action( 'martfury_before_header', 'martfury_promotion_custom', 4 );


add_action( 'template_redirect', function() {
	global $wp;
	global $wpdb;

	if(is_404() && !empty($wp->request)){
		if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
			$current_url = esc_url( $_SERVER['REQUEST_URI'] );
			if ( false !== strpos( $current_url, 'reviews/page' ) ) {
			
				$new_url = explode( '/page', $current_url );
				wp_redirect( $new_url[0] );
				exit;
			}
			
		} 
		$table_name = $wpdb->prefix . 'posts';

		$field_name = 'ID';
		
		$query = "SELECT {$field_name} FROM {$table_name} WHERE  post_name like '{$wp->request}'";
		$prepared_statement = $wpdb->prepare( $query );

		$values = $wpdb->get_row( $prepared_statement );

		if(empty($values)){
			$mysqli = new mysqli('localhost', 'yygpzdrzrc', 'XTkYS9P6C7', 'yygpzdrzrc');
			$result = $mysqli->query($query);

			if ($row = $result->fetch_assoc()) {
			   wp_redirect(get_the_permalink($row['ID']) );
			}
		}else{
			wp_redirect(get_the_permalink($values->ID) );
		}
	}


},1000);


add_action('wp_head',function(){
if(is_404()){
 //echo '404';
}
},100);


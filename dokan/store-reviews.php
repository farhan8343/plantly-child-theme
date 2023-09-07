<?php
global $wp;
$store = explode('/',$wp->request); 
if($store[0] == 'store' && !empty($store[1])){
    $user = get_user_by('slug',$store[1]);
  
}
/**
 * The Template for displaying all reviews.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

$store_user = get_userdata( get_query_var( 'author' ) );
$store_info = dokan_get_store_info( $store_user->ID );
$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';
$layout       = get_theme_mod( 'store_layout', 'left' );

get_header( 'shop' );
if(empty($user)){
    wp_redirect( home_url( '/404' ) );
   }
   else{

   
?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<div class="dokan-store-wrap layout-<?php echo esc_attr( $layout ); ?>">

    <?php if ( 'left' === $layout ) { ?>
        <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
    <?php } ?>

<div id="dokan-primary" class="dokan-single-store dokan-w8">
    <div id="dokan-content" class="store-review-wrap woocommerce" role="main">

        <?php dokan_get_template_part( 'store-header' ); ?>


        <?php
		// adding store reviews by geting all products of the vendor
		$get = get_posts(array('author' => $store_user->ID,'fields' => 'ids', 'post_type' => 'product','posts_per_page'=> -1,'post_status'=>'publish'));
		$get = implode(',',$get);
		if(!empty($get)):?>
			<h2 class="headline">Product Review</h2>
			<?php 
			$shortcode = '[cusrev_all_reviews sort="DESC" sort_by="date" per_page="10" show_more=10 number="-1" show_summary_bar="true" show_pictures="true" show_products="true"  products="'. $get .'" shop_reviews="false" number_shop_reviews="-1" inactive_products="true" show_replies="show"]';

			echo do_shortcode($shortcode); 
		endif;
		
		
        $dokan_template_reviews = dokan_pro()->review;
        $id                     = $store_user->ID;
        $post_type              = 'product';
        $limit                  = 20;
        $status                 = '1';
        $comments               = $dokan_template_reviews->comment_query( $id, $post_type, $limit, $status );
        $product_comments = get_comments(array('post_author'=>$store_user->ID,'post__in'=> $get) );
        $comments = array_merge($comments ,  $product_comments);


       //echo $get;

//echo '<pre>';print_r($comments); echo '</pre>';

//echo '<br>'. count($product_comments); ?>

        <div id="reviews">
            <div id="comments">

              <?php do_action( 'dokan_review_tab_before_comments' ); ?>

                <h2 class="headline"><?php _e( 'Vendor Review', 'dokan' ); ?></h2>

                <ol class="commentlist">
                    <?php echo $dokan_template_reviews->render_store_tab_comment_list( $comments , $store_user->ID); ?>
                </ol>

            </div>
        </div>

        <?php
        echo $dokan_template_reviews->review_pagination( $id, $post_type, $limit, $status );
        ?>

    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

    <?php if ( 'right' === $layout ) { ?>
        <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
    <?php } ?>

</div><!-- .dokan-store-wrap -->
<?php } ?>
<?php do_action( 'woocommerce_after_main_content' ); ?>
   
<?php get_footer(); ?>
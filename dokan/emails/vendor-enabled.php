<?php
/**
* Vendor enable email to vendors.
*
* An email sent to the vendor(s) when a he or she is enabled by the admin
*
* @class    Dokan_Email_Vendor_Enable
* @version  2.7.6
*
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<p style="text-align:center;">
    <?php printf( __( 'Congratulations %s!', 'dokan' ), $data['display_name'] ); ?>
</p>
<p style="text-align:center;">
    <?php _e( 'Your vendor account is activated', 'dokan' ); ?>
</p>
<p style="text-align:center;">
    <?php echo sprintf( __( '<a href="%s" target="_blank" style="background: #00a651; padding: 7px; border-radius: 5px; color: #fff !important; text-decoration: none !important;">Start Selling!</a> ', 'dokan' ), wc_get_page_permalink( 'myaccount' ) ) ; ?>
</p>
<?php
do_action( 'woocommerce_email_footer', $email );

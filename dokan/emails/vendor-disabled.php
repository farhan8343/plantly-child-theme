<?php

/**
* Vendor enable email to vendors.
*
* An email sent to the vendor(s) when a he or she is enabled by the admin
*
* @class    Dokan_Email_Vendor_Disable
* @version  2.7.6
*
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<p>
    <?php printf( __( 'Hello %s', 'dokan' ), $data['display_name'] ); ?>
</p>
<p>
    <?php _e( 'Hope this finds you well.', 'dokan' ); ?>
</p>
<p>
    <?php _e( 'We are letting you know that your Plantly vendor account has been deactivated. Unfortunately, you will not be able to sell on the marketplace again until your account is reinstated', 'dokan' ); ?>
</p>
<p>
    <?php _e( 'If you feel this action was in error, please contact <a href = "mailto: support@plantly.io"> support@plantly.io</a>', 'dokan' ); ?>
</p>
<p>
    <?php _e( 'Best always,', 'dokan' ); ?>
</p>

<p>
    <?php _e( 'The Plantly Team', 'dokan' ); ?>
</p>

<?php
do_action( 'woocommerce_email_footer', $email );

<?php
defined( 'ABSPATH') || exit;

require_once ABSPATH . WPINC . '/formatting.php';

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<div id="dokan-follow-store">
    <h1 id="dokan-follow-store-title" style="text-align:center;">
        <?php if ( 'following' === $data['status'] ) {
            esc_html_e( 'Congrats on your new store follower!', 'dokan' );
        } else {
            esc_html_e( 'Someone just unfollowed your store!', 'dokan' );
        } ?>
    </h1>

    <p class="status">
        <?php if ( 'following' === $data['status'] ) {
            printf( __( '%s', 'dokan' ), $data['follower']->display_name );
        } else {
            printf( __( '%s', 'dokan' ), $data['follower']->display_name );
        } ?>
    </p>

</div>

<style type="text/css">
    .status {
        font-size: 18px;
        text-align: center;
        margin-top: 30px !important;
        margin-bottom: 60px !important;
    }
</style>

<?php do_action( 'woocommerce_email_footer', $email );

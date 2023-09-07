<?php 
use AutomateWoo\Phone_Numbers;
if ( ! defined( 'ABSPATH' ) ) exit;

class Automate_Variable_Vendor extends AutomateWoo\Variable {
	public $use_fallback = false;
	protected $name = 'order.vendor_phone';
	function load_admin_details() {
		$this->description = __( 'Vendor of the product', 'automatewoo');
		parent::load_admin_details();
	}

	function get_value( $order, $parameters ) {
		$sellers = dokan_get_sellers_by( $order->get_id() );
		$phone = array();
		
		foreach($sellers as $seller_id => $products){
			$seller_info = get_user_meta( $seller_id, 'dokan_profile_settings', true );
			if(!empty($seller_info['phone'])){
				$number = Phone_Numbers::parse( strval($seller_info['phone']), $seller_info['address']['country']);
				$phone[] = $number;
			}
		}// echo 'heelo'; print_r($phone); die();
		$phone = implode(',',$phone);
		 //echo $phone; die();
		
		return $phone;
	}
}

return new Automate_Variable_Vendor();
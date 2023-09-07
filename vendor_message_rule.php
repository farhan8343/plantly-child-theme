<?php
/**
 * In this example we create a rule for order billing post/zip codes.
 * This will be a simple true/false string match
 */

class Vendor_Message_Rule extends AutomateWoo\Rules\Rule {
	
	
	public $type = 'string';
	public $data_item = 'order';

	/**
	 * Init
	 */
	function init() {
		
		$this->title = __( 'Order - Vendor Orders', 'automatewoo' );
		$this->group = __( 'Order', 'automatewoo' );

		$this->compare_types = [
			'is' => __( 'is', 'automatewoo' ),
			'is_not' => __( 'is not', 'automatewoo' )
		];
	}
	
	function validate( $data_item, $compare, $expected_value ) {
		// because $this->data_item == 'order' $data_item wil be a WC_Order object
		$order = $data_item;
		$sellers = dokan_get_sellers_by( $order->get_id() );
		if($order->get_parent_id() == 0 && count($sellers) == 1){
			return true;
		}elseif($order->get_parent_id() != 0 && count($sellers) == 1){
			return true;
		}else{
			return false;
		}
	}

}

return new Vendor_Message_Rule(); // must return a new instance
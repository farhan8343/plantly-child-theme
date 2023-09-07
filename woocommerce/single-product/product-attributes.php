<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $product_attributes ) {
        return;
}
?>

<style>@media only screen and (max-width:600px) {
	.attribute-container>div {
		background-color: #f1f1f1;
		width: 46%;
		margin: 6px;
		text-align: center;
		font-size: 14px !important;
		line-height: 18px;
		border-radius: 5px;
	}
	.attribute {
		padding: 12px 12px;
	}
	span.attribute-label {
		text-transform: uppercase;
		font-size: 13px;
		display: block;
	}
	span.attribute-value {
		text-transform: uppercase;
		font-size: 16px;
		font-weight: 400;
	}
}

@media only screen and (min-width:600px) {
	.attribute-container>div {
		background-color: #f1f1f1;
		width: 200px;
		margin: 10px;
		text-align: center;
		font-size: 30px;
		line-height: 23px;
		border-radius: 5px;
	}
	.attribute {
		padding: 20px 15px;
	}
	span.attribute-label {
		text-transform: uppercase;
		font-size: 18px;
		display: block;
	}
	span.attribute-value {
		text-transform: uppercase;
		font-size: 18px;
		font-weight: 400;
	}
}

.attribute-container {
	display: flex;
	flex-wrap: wrap;
	justify-content: flex-start;
}

span.attribute-icon {
	display: block;
	height: 45px;
}

span.attribute-value p {
	margin: 4px 0 0 0;
}

</style>


<div class="attribute-container">

<?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : ?>



	<?php //print_r($product_attribute_key); 
		switch($product_attribute_key){
			case "attribute_pa_sunlight":
				$icon = "light";
				break;
			case "attribute_pa_watering":
				$icon = "watering";
				break;
			case "attribute_pa_air-purifying":
				$icon = "air-cleaner";
				break;
			case "attribute_pa_of-nodes":
				$icon = "no-of-nodes";
				break;
			case "attribute_pa_plant-origin":
				$icon = "plant-origin";
				break;
			case "attribute_pa_perfect-place":
				$icon = "perfect-place";
				break;
			case "attribute_pa_hardiness":
				$icon = "plant-zone";
				break;
			case "attribute_pa_fertilizer":
				$icon = "fertilizer";
				break;
			case "attribute_pa_temperature":
				$icon = "temperature";
				break;
			case "attribute_pa_humidity":
				$icon = "humidity";
				break;
			case "attribute_pa_cutting-type":
				$icon = "pruning";
				break;
			case "attribute_pa_longest-leaf-length":
				$icon = "leaf-length";
				break;
			case "attribute_pa_flowering-season":
				$icon = "flowering-season";
				break;
			case "attribute_pa_pot-size":
				$icon = "pot-size";
				break;
			case "attribute_pa_plant-size":
				$icon = "plant-size";
				break;
			case "attribute_pa_plant-height":
				$icon = "plant-size";
				break;
			case "attribute_pa_plant-type":
				$icon = "plant-type";
				break;
			case "attribute_pa_maintenance":
				$icon = "maintenance";
				break;
			case "attribute_pa_pet-friendly":
				$icon = "toxic";
				break;
			case "attribute_pa_propagation":
				$icon = "propagation";
				break;
			case "attribute_pa_pruning":
				$icon = "pruning";
				break;
			case "attribute_pa_stage-of-rooting":
				$icon = "stage-of-rooting";
				break;
			case "attribute_pa_did-you-know":
				$icon = "did-you-know";
				break;
            case "attribute_sunlight":
                $icon = "light";
                break;
            case "attribute_watering":
                $icon = "watering";
                break;
            case "attribute_air-purifying":
                $icon = "air-cleaner";
                break;
            case "attribute_of-nodes":
                $icon = "no-of-nodes";
                break;
            case "attribute_plant-origin":
                $icon = "plant-origin";
                break;
            case "attribute_perfect-place":
                $icon = "perfect-place";
                break;
            case "attribute_hardiness":
                $icon = "plant-zone";
                break;
            case "attribute_fertilizer":
                $icon = "fertilizer";
                break;
            case "attribute_temperature":
                $icon = "temperature";
                break;
            case "attribute_humidity":
                $icon = "humidity";
                break;
            case "attribute_cutting-type":
                $icon = "pruning";
                break;
            case "attribute_longest-leaf-length":
                $icon = "leaf-length";
                break;
            case "attribute_flowering-season":
                $icon = "flowering-season";
                break;
            case "attribute_pot-size":
                $icon = "pot-size";
                break;
            case "attribute_plant-size":
                $icon = "plant-size";
                break;
            case "attribute_plant-type":
                $icon = "plant-type";
                break;
            case "attribute_maintenance":
                $icon = "maintenance";
                break;
            case "attribute_pet-friendly":
                $icon = "toxic";
                break;
            case "attribute_propagation":
                $icon = "propagation";
                break;
            case "attribute_pruning":
                $icon = "pruning";
                break;
			case "attribute_plant-height":
				$icon = "plant-size";
				break;
            case "attribute_stage-of-rooting":
                $icon = "stage-of-rooting";
                break;
            case "attribute_did-you-know":
                $icon = "did-you-know";
                break;
			case "attribute_pa_bonsai":
                $icon = "bonsai";
                break;			
			case "attribute_pa_growth-rate":
                $icon = "growth-rate";
                break;		
			case "attribute_pa_leaf-shape":
                $icon = "leaf-shape";
                break;				
			case "attribute_pa_orchid":
                $icon = "orchid";
                break;				
			case "attribute_pa_plant-color":
                $icon = "plant-color";
                break;				
			case "attribute_pa_plant-style":
                $icon = "plant-style";
                break;				
			case "attribute_pa_pollination":
                $icon = "pollination";
                break;
				
			case "attribute_pa_pro-tip":
                $icon = "pro-tip";
                break;
				
			case "attribute_pa_soil-type":
                $icon = "soil-type";
                break;
				
			case "attribute_pa_tree-type":
                $icon = "tree-type";
                break;		
			case "attribute_bonsai":
                $icon = "bonsai";
                break;
				
			case "attribute_growth-rate":
                $icon = "growth-rate";
                break;
				
			case "attribute_leaf-shape":
                $icon = "leaf-shape";
                break;
				
			case "attribute_orchid":
                $icon = "orchid";
                break;
				
			case "attribute_plant-color":
                $icon = "plant-color";
                break;
				
			case "attribute_plant-style":
                $icon = "plant-style";
                break;
				
			case "attribute_pollination":
                $icon = "pollination";
                break;
				
			case "attribute_pro-tip":
                $icon = "pro-tip";
                break;
				
			case "attribute_soil-type":
                $icon = "soil-type";
                break;
				
			case "attribute_tree-type":
                $icon = "tree-type";
                break;
			case "attribute_height":
				$icon = "plant-size";
				break;
	
			default:
				$icon = "pro-tip-2";

		}

	?>


		<div class="attribute <?php echo $icon; ?>">
			<span class="attribute-icon img"><img src="https://plantly.io/wp-content/uploads/2021/01/<?php echo $icon; ?>.svg" style=""></span>
			<span class="attribute-label"><?php echo wp_kses_post( $product_attribute['label'] ); ?></span>
			<span class="attribute-value"><?php echo wp_kses_post( $product_attribute['value'] ); ?></span>
		</div>


<?php endforeach; ?>



</div>

<?php

include "connectVend.php";
include_once "Product.php";

function getVendProducts() {
	$data = connectVend::getProducts();

	$products = array();

	foreach($data->products as $product) {
		$prod = new Product();
		
		if( $product->handle != "vend-discount" ) {
			$prod->name = $product->handle;
			
			if( $product->variant_option_one_value != null ) {
				$prod->variant = $product->variant_option_one_value;
			}
			elseif( $product->variant_option_two_value != null ) {
				$prod->variant = $product->variant_option_two_value;
			}
			elseif( $product->variant_option_three_value != null ) {
				$prod->variant = $product->variant_option_three_value;
			}
			else {
				// no variant!
			}

			$prod->vendhqId = $product->id;
			$prod->sku = $product->sku;
			
			foreach($product->inventory as $inventory) {
				$prod->quantity = $inventory->count;
			}

			foreach($product->price_book_entries as $price) {
				$prod->price = $price->price;
			}

			array_push($products, $prod);
		}

	}

	return $products;
}

//echo "<pre>" . print_r(getVendProducts(), true) . "</pre>";

?>

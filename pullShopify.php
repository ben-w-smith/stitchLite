<?php

include "connectShopify.php";
include_once "Product.php";

function getShopifyProducts() {
	$data = connectShopify::getProducts();
		
	$products = array();

	foreach($data->products as $product) {
		foreach($product->variants as $variant) {
			$prod = new Product();

			$prod->name = $product->title;
			$prod->variant = $variant->title;
			$prod->shopifyId = $product->id . ':' . $variant->id;
			$prod->sku = $variant->sku;
			$prod->quantity = $variant->inventory_quantity;
			$prod->price = $variant->price;

			//echo "<pre>" . print_r($prod, true) . "</pre>";
			array_push($products, $prod);
		}
	}
	return $products;
}

//echo "<pre>" . print_r(getShopifyProducts(), true) . "</pre>";

?> 

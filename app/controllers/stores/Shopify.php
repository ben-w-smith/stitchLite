<?php

class Shopify {
	public $apiKey;
	public $domain;
	public $password;

	private function curl($url, $method, $json = null) {
		$c = curl_init($url);

		$opts = array(
			CURLOPT_CUSTOMREQUEST 	=> $method,
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_SSL_VERIFYPEER 	=> false,
			CURLOPT_POSTFIELDS 		=> json_encode($json),
			CURLOPT_HTTPHEADER 		=> array('Content-type: application/json'),
		);

		curl_setopt_array($c, $opts);

		return json_decode(curl_exec($c));
	}

	// returns array of product objs used by Pull/PushController
	public function getProducts() {
		$baseUrl = 'https://'.$this->apiKey.':'.$this->password.'@'.$this->domain.'.myshopify.com';
		$request = '/admin/products.json';
		$method = 'GET';

		$result = $this->curl($baseUrl.$request, $method);

		$products = array();
		foreach($result->products as $shopify) {
			foreach($shopify->variants as $variant) {
				// need to make a class Product in this folder?
				$product = new stdClass;
				$product->id 		= $shopify->id;
				$product->sku 		= $variant->sku;
				$product->name 		= $shopify->title;
				$product->price 	= $variant->price;
				$product->quantity 	= $variant->inventory_quantity;	
				array_push($products, $product);
			}
		}

		return $products;
	}

	public function pushProducts($products) {
		$baseUrl = 'https://'.$this->apiKey.':'.$this->password.'@'.$this->domain.'.myshopify.com';
		$request = '/admin/products.json';
		$method = 'GET';

		$result = $this->curl($baseUrl.$request, $method);

		foreach($products as $product) {
			$new = true;
			foreach($result->products as $shopify) {
				foreach($shopify->variants as $variant) {
					if($variant->sku == $product->sku) {
						// update product
						$request = '/admin/products/'.$shopify->id.'.json';
						$method = 'PUT';

						$prodJson = array('product' => array(
							'id' 		=> $shopify->id,
							'title' 	=> $product->name,
							'variants' 	=> array(array(
								'id' 					=> $variant->id,
								'sku' 					=> $product->sku,
								'price' 				=> $product->price,
								'inventory_quantity' 	=> $product->quantity,
							)),
						));
						$this->curl($baseUrl.$request, $method, $prodJson);

						$new = false;
						break;
					}
				}
			}

			if($new) {
				$request = '/admin/products.json';
				$method = 'POST';

				$prodJson = array('product' => array(
					'title' 		=> $product->name,
					'product_type' 	=> 'made by stitch',
					'variants'		=> array(array(
						'option1' 				=> 'Stitch',
						'sku' 					=> $product->sku,
						'price' 				=> $product->price,
						'inventory_management' 	=> 'shopify',
						'inventory_quantity' 	=> $product->quantity
					)),
				));

				$this->curl($baseUrl.$request, $method, $prodJson);
			}
		}

	}

}
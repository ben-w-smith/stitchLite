<?php

class Vendhq {
	public $domain;
	public $password;
	public $username;

	public function curl($url, $method, $json = null) {
		$c = curl_init($url);

		$opts = array(
			CURLOPT_CUSTOMREQUEST 	=> $method,
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_SSL_VERIFYPEER 	=> false,
			CURLOPT_POSTFIELDS 		=> json_encode($json),
			CURLOPT_HTTPHEADER 		=> array('Content-type: application/json'),
			CURLOPT_USERPWD 		=> "$this->username:$this->password",
		);

		curl_setopt_array($c, $opts);

		return json_decode(curl_exec($c));
	}	

	public function getProducts() {
		$baseUrl = 'https://'.$this->domain.'.vendhq.com/api';
		$request = '/products';
		$method = 'GET';

		$result = $this->curl($baseUrl.$request, $method);

		$products = array();
		foreach($result->products as $vendhq) {
			if($vendhq->handle != 'vend-discount') {
				foreach($vendhq->inventory as $variant) {
					$product = new stdClass;
					$product->id 		= $vendhq->id;
					$product->sku 		= $vendhq->sku;
					$product->name 		= $vendhq->name;
					$product->price 	= $vendhq->price;
					$product->quantity 	= $variant->count;	
					array_push($products, $product);
				}
			}
		}

		return $products;
	}

	public function pushProducts($products) {
		$baseUrl = 'https://'.$this->domain.'.vendhq.com/api';
		$request = '/products/active:1';
		$method = 'GET';

		$result = $this->curl($baseUrl.$request, $method);

		foreach($products as $product) {
			$new = true;
			foreach($result->products as $vendhq) {
				if($vendhq->handle != 'vend-discount') {
					foreach($vendhq->inventory as $variant) {
						// update product
						if($vendhq->sku == $product->sku) {
							$request = '/products';
							$method = 'POST';

							$prodJson = array(
								'id' 			=> $vendhq->id,
								'sku' 			=> $product->sku,
								'handle' 		=> $product->name,
								'name'			=> $product->name,
								'retail_price' 	=> $product->price,
								'inventory' 	=> array(array(
									'outlet_name' => $variant->outlet_name,
									'count' => $product->quantity
								)),
							);

							$this->curl($baseUrl.$request, $method, $prodJson);
							$new = false;
							break;
						}
					}
				}
			}

			// create new product
			if($new) {
				$request = '/products';
				$method = 'POST';

				$prodJson = array(
					'sku' 			=> $product->sku,
					'name' 			=> $product->name,
					'handle'		=> $product->name,
					'retail_price'	=> $product->price,
					'inventory' 	=> array(array(
						'outlet_name' => 'Main Outlet',
						'count' => $product->quantity,
					)),
				);

				$this->curl($baseUrl.$request, $method, $prodJson);
			}
		}
	}
}
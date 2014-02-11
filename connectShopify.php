<?php

class connectShopify {

	public static function getProducts() {
		$domain = 'kungfuemporium.myshopify.com';
		$url = '/admin/products.json?';
		$apiKey = '939157936e325a4185327b82bf396226';
		$password = '2394192536c74907aa448b8c46b4f9f3';

		$shopifyUrl = 'https://'.$apiKey.':'.$password."@".$domain.$url;

		$c = curl_init( $shopifyUrl );
		$opts = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json'),
		CURLOPT_SSL_VERIFYPEER => false,
		);

		curl_setopt_array($c, $opts);

		$result = curl_exec($c);

		return json_decode($result);
	}

}

?>

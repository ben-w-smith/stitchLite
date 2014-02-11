<?php

class ConnectVend {

	public static function getProducts() {
		$domain = 'https://kungfuemporium.vendhq.com';
		$url = '/api/products';
		$username = 'benwsmith@gmail.com';
		$password = 'plummer7';

		$c = curl_init( $domain.$url );

		$opts = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json'),
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_USERPWD => "$username:$password",
		);

		curl_setopt_array($c, $opts);

		$result = curl_exec($c);

		return json_decode($result);
	}

}

?>

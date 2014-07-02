<?php

include 'stores/Shopify.php';
include 'stores/Vendhq.php';

class PullController extends BaseController {
	public function pull() {
		$user = Auth::user()->id;

		$stores = Store::where('user_id', '=', $user)->get();
		$products = Product::where('user_id', '=', $user)->get();

		$stores_products = array();
		foreach($stores as $store) {
			$creds = StoreCredential::where('store_id', '=', $store->id)->get();
			$type = $store->type;
			$store = new $type;
			foreach($creds as $cred) {
				$store->{$cred->key} = $cred->value;
			}

			array_push($stores_products, $store->getProducts());
		}

		$subtract = array();
		foreach($stores_products as $store_products) {
			$products = Product::where('user_id', '=', $user)->get();
			foreach($store_products as $store_product) {
				$new = true;
				foreach($products as $product) {
					if($product->sku == $store_product->sku) {
						if(array_key_exists($product->sku, $subtract)) {
							$subtract[$product->sku] += $product->quantity - $store_product->quantity;
						}
						else {
							$subtract[$product->sku] = $product->quantity - $store_product->quantity;
						}
						$new = false;
						break;
					}
				}

				if($new) {
					$prod = new Product;
					$prod->sku 		= $store_product->sku;
					$prod->name 	= $store_product->name;
					$prod->price 	= $store_product->price;
					$prod->quantity = $store_product->quantity;
					$prod->user_id 	= $user;
					$prod->save();
				}
			}
		}

		$products = Product::where('user_id', '=', $user)->get();
		foreach($subtract as $key => $value) {
			foreach($products as $product) {
				if($key == $product->sku) {
					$product->quantity = $product->quantity - $value;
					$product->save();
				}
			}
		}

		$products = Product::where('user_id', '=', $user)->get();

		Session::flash('message', 'Successfully updated quantities!');
		return Redirect::route('products.index')
			->with('products', $products);
	}
}
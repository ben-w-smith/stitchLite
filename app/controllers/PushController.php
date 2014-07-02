<?php

include 'stores/Shopify.php';
include 'stores/Vendhq.php';

class PushController extends BaseController {
	public function push() {
		$user = Auth::user()->id;

		$stores = Store::where('user_id', '=', $user)->get();
		$products = product::where('user_id', '=', $user)->get();

		foreach($stores as $store) {
			$creds = StoreCredential::where('store_id', '=', $store->id)->get();
			$type = $store->type;
			$store = new $type;
			foreach($creds as $cred) {
				$store->{$cred->key} = $cred->value;
			}

			$store->pushProducts($products);
		}

		Session::flash('message', 'Successfully pushed products!');
		return Redirect::route('products.index');
	}
}
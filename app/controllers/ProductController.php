<?php

class ProductController extends BaseController {
	public function index() {
		$products = Product::where('user_id', '=', Auth::user()->id)->get();

		return View::make('products.index')
			->with('products', $products);
	}

	public function create() {
		return View::make('products.create');
	}

	public function store() {
		$user_id = Auth::user()->id;

		$rules = array(
			'sku' 		=> 'required|unique:products,user_id,'.$user_id,
			'name' 		=> 'required',
			'price' 	=> 'required|numeric',
			'quantity' 	=> 'required|numeric'
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return Redirect::route('products.create')
				->withErrors($validator)
				->withInput(Input::all());
		}
		else {
			$product = new Product;
			$product->sku 		= Input::get('sku');
			$product->name 		= Input::get('name');
			$product->price 	= Input::get('price');
			$product->quantity 	= Input::get('quantity');
			$product->user_id 	= Auth::user()->id;
			$product->save();

			Session::flash('message', 'Successfully created product!');
			return Redirect::to('products');
		}
	}

	public function show($id) {
		$product = Product::find($id);

		return View::make('products.show')
			->with('product', $product);
	}

	public function edit($id) {
		$product = Product::find($id);

		return View::make('products.edit')
			->with('product', $product);
	}

	public function update($id) {
		$user_id = Auth::user()->id;

		$rules = array(
			'sku' 		=> 'required|unique:products,user_id,'.$user_id,
			'name' 		=> 'required',
			'price' 	=> 'required|numeric',
			'quantity' 	=> 'required|numeric'
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return Redirect::to('products/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::all());
		}
		else {
			$product = Product::find($id);
			$product->sku 		= Input::get('sku');
			$product->name 		= Input::get('name');
			$product->price 	= Input::get('price');
			$product->quantity	= Input::get('quantity');
			$product->save();

			Session::flash('message', 'Successfully updated product!');
			return Redirect::to('products');
		}
	}

	public function destroy($id) {
		$product = Product::find($id);
		$product->delete();

		Session::flash('message', 'Product deleted!');
		return Redirect::to('products');
	}
}
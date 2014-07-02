<?php

class StoreController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$stores = Store::where('user_id', '=', Auth::user()->id)->get();

		return View::make('stores.index')
			->with('stores', $stores);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$column = DB::select("SHOW COLUMNS FROM stores LIKE 'type'");
		$stores = explode("','", substr($column[0]->Type, 6, -2));

		array_unshift($stores, '');

		return View::make('stores.create')
			->with('stores', $stores);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$rules = array();
		foreach(Input::except("_token") as $key => $value) {
			if($key == 'store') {
				$rules[$key] = 'required|unique:stores,type,'.Auth::user()->id;
			} 
			else {
				$rules[$key] = 'required';
			}
		}
		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return Redirect::route('stores.create')
				->withErrors($validator)
				->withInput(Input::all());
		}
		else {
			$store = new Store;
			$store->type 	= Input::get('store');
			$store->user_id = Auth::user()->id;
			$store->save();

			$message = '';
			foreach(Input::except(array('store', '_token')) as $key => $value) {
				$cred = new StoreCredential;
				$cred->store_id = $store->id;
				$cred->key 		= $key;
				$cred->value 	= $value; 
				$cred->save();
			}

			Session::flash('message', 'Successfully created store!'.$message);
			return Redirect::to('stores');
		}
		// other stores go here
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$store = Store::find($id);
		$inputs = StoreCredential::where('store_id', '=', $id)->get();
		
		return View::make('stores.edit')
			->with('store', $store)
			->with('inputs', $inputs);	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array();
		$inputs = Input::except('_method', '_token');
		foreach($inputs as $key => $value) {
			$rules[$key] = 'required';
		}

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return Redirect::to('stores/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::all());
		}	
		else {
			$creds = StoreCredential::where('store_id', '=', $id)->get();

			foreach($creds as $cred) {
				foreach($inputs as $key => $value) {
					if($cred->key == $key) {
						$cred->value = $value;
						break;
					}
				}
				$cred->save();
			}

			Session::flash('message', 'Successfully updated store!');
			return Redirect::to('stores');	
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$store = Store::find($id);
		$store->delete();

		$creds = StoreCredential::where('store_id', '=', $id)->get();
		foreach($creds as $cred) {
			$cred->delete();
		}

		Session::flash('message', 'Store deleted!');
		return Redirect::to('stores');
	}

	/**
	 * Gets the view from the dir stores/create/ needed to create the store
	 *
	 * @param string $name
	 * @return Response
	 */
	public function getCreateForm($name) {
		if(View::exists('stores.create.'.$name)) {
			return View::make('stores.create.'.$name);
		}
		else {
			// returns an empty page if no store view exists
			return View::make('stores.create.none');
		}
	}

}
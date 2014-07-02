<?php

class UserController extends BaseController {
	public function getLogin() {
		return View::make('users.login');
	}

	public function postLogin() {
		$rules = array(
			'email' => 'required',
			'password' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return Redirect::to('users/index')
				->withErrors($validator)
				->withInput(Input::all());
		}
		else {
			$remember = (Input::has('remember')) ? true : false;

			$auth = Auth::attempt(array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
			), $remember);

			if($auth) {
				return Redirect::route('products.index');
			}
			else {
				Session::flash('message', 'Auth failed!');
				return Redirect::route('users.get.login');
			}
		}
	}

	public function	getCreate() {
		return View::make('users.create');
	}

	public function postCreate() {
		$rules = array(
			'email'		=> 'required|email|unique:users',
			'password' 	=> 'required|min:6|max:200',
			'password_again' => 'required|same:password'
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return Redirect::to('users/create')
				->withErrors($validator)
				->withInput(Input::all());
		}
		else {
			$user = new User;
			$user->email 	= Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->save();

			if($user) {
				Session::flash('message', 'Successfully created account!');
				return Redirect::route('users.get.login');
			}
			else {
				Session::flash('messsage', 'Failed to make your account.');
				return Redirect::route('users.get.create');
			}
		}
	}

	public function getLogout() {
		Auth::logout();
		return Redirect::route('users.get.login');
	}
}
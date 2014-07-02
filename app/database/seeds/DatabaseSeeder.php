<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$user = new User;
		$user->fill(array(
			'email' => 'benwsmith@gmail.com',
			'password' => Hash::make('plummer7'),
		));
		$user->save();

		$store = new Store;
		$store->fill(array(
			'type' => 'Shopify',
			'user_id' => $user->id
		));
		$store->save();

		$creds = array(
			'apiKey' => '3005ef509d79359395a5201e7063beda',
			'domain' => 'stitchlite',
			'password' => '5a03b4fcf1e5b04c139c4db6046dafd5'
		);

		foreach($creds as $key => $value) {
			$cred = new StoreCredential;
			$cred->fill(array(
				'store_id' => $store->id,
				'key' => $key,
				'value' => $value
			));	
			$cred->save();
		}

		$store = new Store;
		$store->fill(array(
			'type' => 'Vendhq',
			'user_id' => $user->id
		));
		$store->save();

		$creds = array(
			'domain' => 'laravel4',
			'password' => 'plummer7',
			'username' => 'benwsmith@gmail.com'
		);

		foreach($creds as $key => $value) {
			$cred = new StoreCredential;
			$cred->fill(array(
				'store_id' => $store->id,
				'key' => $key,
				'value' => $value
			));	
			$cred->save();
		}
	}

}
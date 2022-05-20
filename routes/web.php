<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome', [
    	// 'stations' => App\Station::all(),
    	'addresses' => App\Address::all(),
    	'manufacturers' => App\Manufacturer::all()
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('vehicles', 'VehiclesController')->middleware('auth');
Route::resource('search', 'SearchesController')->middleware('auth');
Route::resource('plans', 'PlansController')->middleware('auth');
Route::resource('trip', 'TripsController')->middleware('auth');
Route::get('activity', function () {
	return view('modules.activity.list', [
		'els' => Spatie\Activitylog\Models\Activity::where('causer_id', Auth::user()->id)->get()
	]);
})->middleware('auth');
Route::view('profile', 'profile')->middleware('auth');
Route::patch('profile/{id}', 'UsersController@update')->middleware('auth');

Route::get('404', function () {
	abort(404);
});

// Route::get('reference-data', function () {
// 	$data = json_decode(file_get_contents('https://api.openchargemap.io/v2/referencedata/'));

// 	foreach ($data->Countries as $country) {
// 		DB::table('countries')->insert([
// 			'title' => $country->Title,
// 			'is_code' => $country->ISOCode,
// 			'continent' => $country->ContinentCode
// 		]);
// 	}

// 	foreach ($data->StatusTypes as $type) {
// 		DB::table('status_types')->insert([
// 			'title' => $type->Title,
// 			'is_operational' => (bool) $type->IsOperational,
// 			'remote_id' => $type->ID
// 		]);
// 	}

// 	foreach ($data->UsageTypes as $type) {
// 		DB::table('usage_types')->insert([
// 			'title' => $type->Title,
// 			'is_membership' => (bool) $type->IsMembershipRequired,
// 			'is_pay_location' => (bool) $type->IsPayAtLocation,
// 			'is_access_key' => (bool) $type->IsAccessKeyRequired,
// 			'remote_id' => $type->ID
// 		]);
// 	}

// 	foreach ($data->ConnectionTypes as $connector) {
// 		DB::table('connections')->insert([
// 			'title' => $connector->Title,
// 			'technical' => $connector->FormalName,
// 			'is_discontinued' => (bool) $connector->IsDiscontinued,
// 			'is_obsolete' => (bool) $connector->IsObsolete,
// 			'remote_id' => $connector->ID
// 		]);
// 	}
// });

// Route::get('stations', function () {
// 	$data = json_decode(file_get_contents('https://api.openchargemap.io/v2/poi/?output=json&countrycode=AL&opendata=true&compact=true&verbose=false&camelcase=true&maxresults=10000&distanceunit=KM'));

// 	foreach ($data as $station) {
// 		$instance = App\Station::create([
// 			'cost' => (isset($station->usageCost)) ? $station->usageCost : '',
// 			'points' => (isset($station->numberOfPoints)) ? $station->numberOfPoints : 0,
// 			'is_verified' => $station->isRecentlyVerified,
// 			'remote_id' => $station->id,
// 			'remote_uuid' => $station->uuid,
// 			'hash' => ''
// 		]);

// 		$address = App\Address::create([
// 			'title' => $station->addressInfo->title,
// 			'address' => ((isset($station->addressInfo->addressLine1)) ? $station->addressInfo->addressLine1 : ''),
// 			'town' => (isset($station->addressInfo->town)) ? (string) $station->addressInfo->town : '',
// 			'state' => (isset($station->addressInfo->stateOrProvince)) ? $station->addressInfo->stateOrProvince : '',
// 			'postcode' => (isset($station->addressInfo->postcode)) ? $station->addressInfo->postcode : '',
// 			'lat' => $station->addressInfo->latitude,
// 			'lng' => $station->addressInfo->longitude,
// 			'hash' => ''
// 		]);

// 		$address->country()->associate(App\Country::find($station->addressInfo->countryID));
// 		$address->save();

// 		if (isset($station->usageTypeID)) {
// 			$instance->usage()->associate(App\Usage::where('remote_id', $station->usageTypeID)->firstOrFail());
// 		}

// 		if (isset($station->statusTypeID)) {
// 			$instance->status()->associate(App\Status::where('remote_id', $station->statusTypeID)->firstOrFail());
// 		}

// 		$instance->address()->associate($address);
// 		$instance->save();

// 		foreach ($station->connections as $connection) {
// 			DB::table('station_connections')->insert([
// 				'station_id' => $instance->id,
// 				'connection_id' => $connection->connectionTypeID,
// 				'level_id' => (isset($connection->levelID)) ? $connection->levelID : 0,
// 				'power_kw' => (isset($connection->powerKW)) ? $connection->powerKW : 0.0,
// 				'amps' => (isset($connection->amps)) ? $connection->amps : (double)0,
// 				'voltage' => (isset($connection->voltage)) ? $connection->voltage : (double)0,
// 				'current_id' => (isset($connection->currentTypeID)) ? $connection->currentTypeID : 0
// 			]);
// 		}
// 	}
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

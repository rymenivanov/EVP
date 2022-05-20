<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('v1/manufacturers/{hash}/makes', function ($hash) {
	return response()->json(
		App\Manufacturer::where('hash', $hash)->firstOrFail()->makes
	);
});

Route::get('v1/makes/{hash}', function ($hash) {
	$make = App\Make::where('hash', $hash)->firstOrFail();

	return response()->json($make);
});
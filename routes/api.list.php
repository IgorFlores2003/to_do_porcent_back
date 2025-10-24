<?php

use App\Http\Controllers\ListTo\ListToController;
use Illuminate\Support\Facades\Route;

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

/*
|--------------------------------------------------------------------------
| Endpoints
|--------------------------------------------------------------------------
*/

// Candidate
Route::prefix('list-to')->controller(ListToController::class)->group(function () {
  Route::get('', 'index');
  Route::post('', 'store');
  Route::get('{id}', 'show');
  Route::match(['put', 'patch'], '{id}', 'update');
  Route::delete('{id}', 'destroy');
});

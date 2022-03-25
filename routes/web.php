<?php

use App\Http\Controllers\LicenseController;
use Illuminate\Support\Facades\Route;

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

/* Route::get('/{license:key}', [LicenseController::class, 'show']);
Route::post('/{license}/{company:code}', [LicenseController::class, 'assign']); */
Route::get('/', [LicenseController::class, 'assign']);
//Route::get('/{license}/{company:code}', [LicenseController::class, 'assign']);

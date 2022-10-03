<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/addbill',[App\Http\Controllers\HomeController::class, 'AddBill']);
Route::get('/addcourier',[App\Http\Controllers\HomeController::class, 'AddCourier']);
Route::get('/getcourier',[App\Http\Controllers\HomeController::class, 'GetCourier']);
Route::get('/getbills',[App\Http\Controllers\HomeController::class, 'GetBills']);
Route::get('/createbill',[App\Http\Controllers\HomeController::class, 'CreateBill']);
Route::get('/deletebill',[App\Http\Controllers\HomeController::class, 'DeteteBill']);
Route::get('/export',[App\Http\Controllers\HomeController::class, 'export']);
Route::get('/isCourierExists',[App\Http\Controllers\HomeController::class, 'isCourierExists']);



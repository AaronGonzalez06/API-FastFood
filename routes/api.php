<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BillController;

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


Route::get('section/list', [SectionController::class, 'list']);
Route::get('product/list', [ProductController::class, 'list']);
Route::get('product/listProductSection/{id}', [ProductController::class, 'listProductSection']);
Route::get('product/listPrice/{priceOne}/{priceTwo}', [ProductController::class, 'listPrice']);

Route::post('user/add', [UserController::class, 'addUser']);
Route::post('user/login', [UserController::class, 'login']);

Route::get('bill/userBills/{id}', [BillController::class, 'bills']);
Route::post('bill/addBill', [BillController::class, 'addBill']);
Route::post('bill/addProductBill', [BillController::class, 'addProductBill']);
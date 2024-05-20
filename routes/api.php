<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

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

## Categories
Route::middleware('jwtAuth')->get('categories', [API\Categories\Get::class, 'index']);
Route::middleware('jwtAuth:admin')->post('categories', [API\Categories\Post::class, 'index']);
Route::middleware('jwtAuth:admin')->put('categories/{id}', [API\Categories\Put::class, 'index']);
Route::middleware('jwtAuth:admin')->delete('categories/{id}', [API\Categories\Delete::class, 'index']);

## Products
Route::middleware('jwtAuth')->get('products', [API\Products\Get::class, 'index']);
Route::middleware('jwtAuth')->post('products', [API\Products\Post::class, 'index']);
Route::middleware('jwtAuth')->put('products/{id}', [API\Products\Put::class, 'index']);
Route::middleware('jwtAuth')->delete('products/{id}', [API\Products\Delete::class, 'index']);

## Register
Route::post('register', [API\Register::class, 'index']);

## Login
Route::post('login', [API\Login::class, 'index']);

## Login with Google
Route::middleware(['web'])->get('oauth/register', [API\LoginGoogle::class, 'authenticateGoogle']);
Route::middleware(['web'])->get('oauth/register/callback', [API\LoginGoogle::class, 'handleCallback']);

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
/**
 * Registration user route.
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/**
 * Email verfication route.
 */
Route::get('/checkemail', 'HomeController@checkEmail');
/**
 * Return all plans in the database.
 */
Route::get('/plans', 'HomeController@plans');
/**
 * Return all payments in the database.
 */
Route::get('/payments', 'HomeController@payments');
/**
 * Return the payment.
 */
Route::get('/payments/{payment}', 'HomeController@paymentById');
/**
 * Return all payments that belongs to the user.
 */
Route::get('/users/{user}/payments', 'HomeController@paymentsByUser');
/**
 * User registration route.
 */
Route::post('/register', 'HomeController@register');
/**
 * Process a payment.
 */
Route::post('/charge', 'HomeController@charge');